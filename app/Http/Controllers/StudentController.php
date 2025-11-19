<?php

namespace App\Http\Controllers;

use App\Models\SupervisorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentProfile;
use App\Models\User;
use App\Models\SupervisionRequest;
use App\Models\StudentSession;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function find_supervisor() {
        $student = Auth::user();
        $studentProfile = $student->student_profile;

        if(!$studentProfile) {
            return redirect('student_profile')->with('error', 'User must create a profile first!');
        }

        $supervisors = SupervisorProfile::paginate(5);

        // Check if student already has 1 approved supervisor
        $hasApproved = SupervisionRequest::where('student_id', $studentProfile->id)
                        ->where('status', 'approved')
                        ->exists();

        $statuses = SupervisionRequest::where('student_id', $studentProfile->id)->get();
        $users = User::all();

        return view('student.find_supervisor', compact('supervisors', 'statuses', 'users', 'studentProfile', 'hasApproved'));
    }
    public function search_supervisor(Request $request)
    {
        $query = $request->input('query');

        // Search SupervisorProfile using Meilisearch
        $supervisorMatches = SupervisorProfile::search($query)->get();

        // Search User model using Meilisearch
        $userMatches = User::search($query)->get();

        // Get supervisors linked to matched users
        $supervisorsFromUsers = SupervisorProfile::whereIn(
            'user_id',
            $userMatches->pluck('id')
        )->get();

        // Merge all supervisor results & remove duplicates
        $allSupervisors = $supervisorMatches
            ->merge($supervisorsFromUsers)
            ->unique('id');

        $student = Auth::user();
        $studentProfile = $student->student_profile;
        $statuses = SupervisionRequest::where('student_id', $studentProfile->id)->get();

        return view('student.search_result', [
            'results' => $allSupervisors,
            'query' => $query,
            'statuses' => $statuses,
        ]);
    }
    public function view_profile() {
        $user = Auth::user();
        $student = StudentProfile::all();
        $sessions = StudentSession::all();
        return view('student.student_profile', compact('user', 'student', 'sessions'));
    }
    public function create_profile(Request $request, $id) {

        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_phone' => 'required|string|unique:student_profiles',
            'student_course' => 'string|max:255',
            'student_semester' => 'string|max:2|required',
            'student_session' => 'string|max:255|required',
            'student_profile_picture' => 'nullable | mimes:jpg,jpeg,png',
        ]);

        $student = new StudentProfile();
        $student->user_id = $id;
        $student->student_name = $validated['student_name'];
        $student->student_phone = $validated['student_phone'];
        $student->student_course = $validated['student_course'];
        $student->student_semester = $validated['student_semester'];
        $student->student_session = $validated['student_session'];

        $student_profile_picture = $request->student_profile_picture;

        if ($student_profile_picture) {
            $imagename = time().'.'.$student_profile_picture->getClientOriginalExtension();

            $request->student_profile_picture->move('uploads/students/', $imagename);
            $student->student_profile_picture = $imagename;
        }

        $student->save();

        if (Auth::user()->role == 'admin') {
            return redirect()->back()->with('success', 'Student profile created successfully.');
        } else {
            return redirect('/student_profile');
        }


    }
    public function edit_profile($id) {

        $user = StudentProfile::find($id);
        $sessions = StudentSession::all();

        return view('student.edit_profile', compact('user', 'sessions'));
    }
    public function update_profile(Request $request, $id) {

        $student = StudentProfile::find($id);

        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_phone' => 'required|string',
            'student_course' => 'string|max:255',
            'student_semester' => 'string|max:2|required',
            'student_session' => 'string|max:255|required',
            'student_profile_picture' => 'nullable|mimes:jpg,jpeg,png',
        ]);

        $student->student_name = $validated['student_name'];
        $student->student_phone = $validated['student_phone'];
        $student->student_course = $validated['student_course'];
        $student->student_semester = $validated['student_semester'];
        $student->student_session = $validated['student_session'];

        $student_profile_picture = $request->student_profile_picture;

        if ($student_profile_picture) {
            $imagename = time().'.'.$student_profile_picture->getClientOriginalExtension();

            $request->student_profile_picture->move('uploads/students/', $imagename);
            $student->student_profile_picture = $imagename;
        }

        $student->save();

        if (Auth::user()->role == 'admin') {
            return redirect()->back()->with('success', 'Student profile created successfully.');
        } else {
            return redirect('/student_profile');
        }
    }
    public function view_lecturer($id) {

        $user = User::find($id);
        $supervisor = SupervisorProfile::find($id);

        $requests = SupervisionRequest::where('lecturer_id', $id)->get();
        $supervisees = $supervisor ? $supervisor->supervisees : collect();

        return view('student.view_lecturer', compact('supervisor', 'user', 'requests', 'supervisees'));
    }
    public function request_page($id)
    {
        $user = User::find($id);
        $supervisor = SupervisorProfile::find($id);

        $student = Auth::user();
        $studentProfile = $student->student_profile;

        if (!$studentProfile) {
            return redirect('student_profile')->with('error', 'Please create your student profile before requesting supervision.');
        }

        // ✅ Block new requests if the student already has an approved supervisor
        $hasApproved = SupervisionRequest::where('student_id', $studentProfile->id)
            ->where('status', 'approved')
            ->exists();

        if ($hasApproved) {
            return redirect()->back()->with('error', 'You already have an approved supervisor and cannot make new requests.');
        }

        // ✅ Check if student already has 3 pending requests
        $pendingCount = SupervisionRequest::where('student_id', $studentProfile->id)
            ->where('status', 'pending')
            ->count();

        if ($pendingCount >= 3) {
            return redirect()->back()->with('error', 'You can only request up to 3 supervisors at a time.');
        }

        $exists = SupervisionRequest::where('student_id', $studentProfile->id)
            ->where('lecturer_id', $id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already requested supervision from this lecturer.');
        }

        return view('student.request_page', compact('supervisor', 'user'));
    }
    public function request_supervision(Request $request, $id) {
        $student = Auth::user();
        $studentProfile = $student->student_profile;

        SupervisionRequest::create([
            'student_id' => $studentProfile->id,
            'lecturer_id' => $id,
            'project_title' => $request->input('project_title') ?: 'Not provided',
            'request_message' => $request->input('request_message') ?: 'Not provided',
            'status' => 'pending',
            'request_date' => now(),
        ]);

        return redirect('find_supervisor')->with('success', 'Supervision request sent!');
    }
    public function view_supervision_request() {
        $student = Auth::user();
        $studentProfile = $student->student_profile;

        if (!$studentProfile) {
            return redirect('student_profile')->with('error', 'User must create a profile first!');
        }

        $requests = SupervisionRequest::where('student_id', $studentProfile->id)->get();
        $users = User::all();

        return view('student.view_supervision_request', compact('requests', 'users'));
    }
    public function edit_supervision_request($id){
        $request = SupervisionRequest::find($id);

        return view('student.edit_supervision_request', compact('request'));
    }
    public function update_supervision_request(Request $request, $id){
        $student_request = SupervisionRequest::find($id);

        $student_request->project_title = $request['project_title' ?: 'Not provided'];
        $student_request->request_message =  $request['request_message' ?: 'Not provided'];
        $student_request->request_date = now();

        $student_request->save();

        return redirect('view_supervision_request')->with('success','Request data updated Successfully');
    }
    public function delete_supervision_request($id){
        $student_request = SupervisionRequest::find($id);

        if(!$student_request) {
            return redirect()->back()->with('error','Request data not does not exist!');
        }

        $student_request->delete();

        return redirect()->back()->with('success','Request data removed Successfully');
    }
    public function propose_title() {
        return view('student.propose_title');
    }
    public function recommend_supervisors(Request $request) {
        $projectTitle = $request->input('project_title');

        $student = Auth::user();
        $studentProfile = $student->student_profile;

        if(!$studentProfile) {
            return redirect('student_profile')->with('error', 'User must create a profile first!');
        }

        // Check if student already has an approved supervisor
        $hasApproved = SupervisionRequest::where('student_id', $studentProfile->id)
                        ->where('status', 'approved')
                        ->exists();

        $statuses = SupervisionRequest::where('student_id', $studentProfile->id)->get();
        $users = User::all();

        if(!$projectTitle) {
            return redirect()->back()->with('error', 'Please enter a project title');
        }

        // Split the title
        $keywords = explode(' ', $projectTitle);

        // Find supervisors whose expertise contains any of the keywords
        $query = SupervisorProfile::query();

        foreach ($keywords as $word) {
            $query->orWhere('supervisor_expertise', 'LIKE', '%' . $word . '%');
        }

        $supervisors = $query->get();

        return view('student.recommended_supervisors', compact('supervisors', 'projectTitle', 'statuses', 'users', 'studentProfile', 'hasApproved'));
    }
    public function view_my_supervisor($id)
    {
        // 1. Get the logged-in student profile
        $student = StudentProfile::where('user_id', $id)->first();

        if (!$student) {
            return redirect('student_profile')->with('error', 'User must create a profile first!');
        }

        // 2. Get the approved supervision request
        $approvedRequest = SupervisionRequest::where('student_id', $student->id)
            ->where('status', 'approved')
            ->first();

        if (!$approvedRequest) {
            return redirect('home')->with('error', 'You do not have an approved supervisor yet.');
        }

        // 3. Get the supervisor info
        $supervisor = SupervisorProfile::find($approvedRequest->lecturer_id);

        if (!$supervisor) {
            return redirect()->back()->with('error', 'Supervisor not found.');
        }

        // 4. Get supervisor's supervisees
        $supervisees = $supervisor->supervisees ?? collect();

        return view('student.view_my_supervisor', compact('supervisor', 'student', 'supervisees'));
    }
}
