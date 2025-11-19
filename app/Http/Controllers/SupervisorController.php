<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\Request;
use App\Models\SupervisorProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SupervisionRequest;
use App\Models\Expertise;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;

class SupervisorController extends Controller
{
    public function view_profile() {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user = Auth::user();
        $supervisor = SupervisorProfile::all();
        // Provide expertise tags for profile create forms
        $expertiseTags = Expertise::getAllExpertiseTags();

        if (Auth::user()->role === 'admin') {
            return view('admin.profile', compact('user', 'supervisor', 'expertiseTags'));
        } else {
            return view('lecturer.profile', compact('user', 'supervisor', 'expertiseTags'));
        }
    }

    public function create_profile(Request $request, $id) {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'supervisor_name' => 'required|string|max:255',
            'supervisor_phone' => 'required|string|unique:supervisor_profiles',
            'supervisor_expertise' => 'string|max:255',
            'supervisor_department' => 'required',
            'supervisor_profile_picture' => 'nullable | mimes:jpg,jpeg,png',
        ]);

        $supervisor = new SupervisorProfile();
        $supervisor->user_id = $id;
        $supervisor->supervisor_name = $validated['supervisor_name'];
        $supervisor->supervisor_phone = $validated['supervisor_phone'];
        $supervisor->supervisor_expertise = $validated['supervisor_expertise'];
        $supervisor->supervisor_department = $validated['supervisor_department'];

        $supervisor_profile_picture = $request->supervisor_profile_picture;

        if ($supervisor_profile_picture) {
            $imagename = time().'.'.$supervisor_profile_picture->getClientOriginalExtension();

            $request->supervisor_profile_picture->move('uploads/supervisors/', $imagename);
            $supervisor->supervisor_profile_picture = $imagename;
        }

        $supervisor->save();

        if (Auth::user()->id == $supervisor->user_id) {
            return redirect('/profile');
        } else {
            return redirect()->back()->with('success', 'Supervisor profile created successfully.');
        }
    }

    public function edit_profile($id) {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user = SupervisorProfile::find($id);
        $trueUser = Auth::user();
        // Get all expertise tags to populate the select in the view
        $expertiseTags = Expertise::getAllExpertiseTags();

        if (Auth::user()->role === 'admin') {
            return view('admin.edit_profile', compact('user', 'trueUser', 'expertiseTags'));
        } else {
            return view('lecturer.edit_profile', compact('user', 'trueUser', 'expertiseTags'));
        }
    }

    public function update_profile(Request $request, $id) {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $supervisor = SupervisorProfile::find($id);

        $validated = $request->validate([
            'supervisor_name' => 'required|string|max:255',
            'supervisor_phone' => 'required|string',
            'supervisor_expertise' => 'string|max:255',
            'supervisor_department' => 'string|required',
            'supervisor_profile_picture' => 'nullable|mimes:jpg,jpeg,png',
        ]);

        $supervisor->supervisor_name = $validated['supervisor_name'];
        $supervisor->supervisor_phone = $validated['supervisor_phone'];
        $supervisor->supervisor_expertise = $validated['supervisor_expertise'];
        $supervisor->supervisor_department = $validated['supervisor_department'];

        $supervisor_profile_picture = $request->supervisor_profile_picture;

        if ($supervisor_profile_picture) {
            $imagename = time().'.'.$supervisor_profile_picture->getClientOriginalExtension();

            $request->supervisor_profile_picture->move('uploads/supervisors/', $imagename);
            $supervisor->supervisor_profile_picture = $imagename;
        }

        // Save profile first
        $supervisor->save();

        // Persist any new expertise tags into the `expertises` table and clear cache
        if (!empty($validated['supervisor_expertise'])) {
            $tags = array_map('trim', explode(',', $validated['supervisor_expertise']));
            foreach ($tags as $tag) {
                if ($tag === '') continue;
                Expertise::firstOrCreate(['expertise_tag' => $tag]);
            }
            // Invalidate cached tags so next load picks up new ones
            Cache::forget('expertise_tags');
        }

        if (Auth::user()->id == $supervisor->user_id) {
            return redirect('/profile');
        } else {
            return redirect()->back()->with('success', 'Supervisor profile created successfully.');
        }
    }

    public function view_request($id) {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user = User::find($id);
        $supervisor = SupervisorProfile::where('user_id', $id)->first();

        $requests = SupervisionRequest::where('lecturer_id', $id)->get();
        $supervisee_requests = $supervisor ? $supervisor->supervisee_requests : collect();

        if (Auth::user()->role === 'admin') {
            return view('admin.view_request', compact('supervisor', 'user', 'requests', 'supervisee_requests'));
        } else {
            return view('lecturer.view_request', compact('supervisor', 'user', 'requests', 'supervisee_requests'));
        }
    }

    public function view_supervisee($id) {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user = User::find($id);
        $supervisor = SupervisorProfile::where('user_id', $id)->first();

        $requests = SupervisionRequest::where('lecturer_id', $id)->get();
        $supervisees = $supervisor ? $supervisor->supervisees : collect();

        if (Auth::user()->role === 'admin' && $supervisor) {
            return view('admin.view_supervisee', compact('supervisor', 'user', 'requests', 'supervisees'));
        } else if (Auth::user()->role === 'lecturer' && $supervisor) {
            return view('lecturer.view_supervisee', compact('supervisor', 'user', 'requests', 'supervisees'));
        } else if (!$supervisor) {
            return redirect()->back()->with('error', 'Please create your supervisor profile first.');
        } else {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
    }

    public function view_supervisee_profile($id){
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user = User::where('id',$id)->get();
        $student_profile = StudentProfile::find($id);

        if (Auth::user()->role === 'admin') {
            return view('admin.view_supervisee_profile', compact('user', 'student_profile'));
        } else {
            return view('lecturer.view_supervisee_profile', compact('user', 'student_profile'));
        }
    }

    public function approve_request($id) {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request = SupervisionRequest::find($id);

        if (!$request) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        // ✅ Check if this student already has an approved supervisor
        $alreadyApproved = SupervisionRequest::where('student_id', $request->student_id)
            ->where('status', 'approved')
            ->exists();

        if ($alreadyApproved) {
            return redirect()->back()->with('error', 'This student already has an approved supervisor.');
        }

        // ✅ Approve this request
        $request->status = 'approved';
        $request->save();

        // ✅ Delete other pending requests from this student
        SupervisionRequest::where('student_id', $request->student_id)
            ->where('id', '!=', $id)
            ->where('status', 'pending')
            ->delete();

        if (Auth::user()->role === 'admin') {
            return redirect()->back()->with('success', 'Admin: Request approved and other requests removed.');
        } else {
            return redirect()->back()->with('success', 'Lecturer: Request approved and other requests removed.');
        }
    }

    public function decline_request($id) {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request = SupervisionRequest::find($id);
        if ($request) {
            $request->status = 'declined';
            $request->save();
        }

        return redirect()->back()->with('success', 'Request declined successfully');
    }

    public function generateSuperviseeReport($lecturerId) {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'lecturer') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Resolve SupervisorProfile: the caller may pass either a SupervisorProfile id or a User id.
        $supervisorProfile = SupervisorProfile::find($lecturerId);
        if (!$supervisorProfile) {
            // maybe a user id was passed
            $supervisorProfile = SupervisorProfile::where('user_id', $lecturerId)->first();
        }

        if (!$supervisorProfile) {
            return redirect()->back()->with('error', 'User must create a profile first.');
        }

        // Use the resolved supervisor profile
        $supervisor = $supervisorProfile;

        // Get supervisees linked through SupervisionRequest (lecturer_id stores supervisor_profile id)
        $superviseeIds = SupervisionRequest::where('lecturer_id', $supervisorProfile->id)
            ->where('status', 'approved')->pluck('student_id'); // get only student IDs

        // Get student profiles
        $supervisees = StudentProfile::whereIn('id', $superviseeIds)->get();

        // Load view
        $pdf = PDF::loadView('reports.supervisee_report', compact('supervisor', 'supervisees'));

        // Optional: set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Set filename based on role
        $role_prefix = Auth::user()->role === 'admin' ? 'coordinator' : 'lecturer';
        // Use supervisor name field if available; fall back to id
        $supervisorLabel = $supervisor->supervisor_name ?? ($supervisor->name ?? $supervisor->id);
        // Stream the PDF inline so it opens in browser (new tab) instead of forcing download
        return $pdf->stream($role_prefix . '_supervisee_report_'.preg_replace('/[^A-Za-z0-9-_]/', '_', $supervisorLabel).'.pdf');
    }

    public function generateStudentReport($studentId) {
        $student = StudentProfile::findOrFail($studentId);

        // Get supervisor IDs based on status
        $supervisorIds = SupervisionRequest::where('student_id', $studentId)
            ->whereNotIn('status', ['approved'])
            ->pluck('lecturer_id');

        $approvedSupervisorIds = SupervisionRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->pluck('lecturer_id');

        // Fetch supervisor profiles
        $supervisors = SupervisorProfile::whereIn('id', $supervisorIds)->get();
        $approvedSupervisors = SupervisorProfile::whereIn('id', $approvedSupervisorIds)->get();

        // Get approved project (if any)
        $approvedProject = SupervisionRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();

        // Generate PDF
        $pdf = PDF::loadView('reports.student_report', compact(
            'student',
            'supervisors',
            'approvedSupervisors',
            'approvedProject'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('student_report_'.$student->student_name.'.pdf');
    }
}
