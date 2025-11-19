<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentSession;
use App\Models\SupervisionRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Expertise;

class AdminController extends Controller
{
    public function index(){
        if(Auth::id())
        {
            $role = Auth::user()->role;

            if($role=='admin')
            {
                $supervisorProfile = SupervisorProfile::where('user_id', Auth::id())->first();
                if ($supervisorProfile) {
                    $totalSupervisees = SupervisionRequest::where('lecturer_id', $supervisorProfile->id)
                        ->where('status', 'approved')
                        ->count();

                    $pendingRequests = SupervisionRequest::where('lecturer_id', $supervisorProfile->id)
                        ->where('status', 'pending')
                        ->count();

                        return view('admin.home', compact('totalSupervisees', 'pendingRequests'));
                }

                $totalSupervisees = 0;
                $pendingRequests = 0;

                return view('admin.home', compact(
                    'pendingRequests',
                    'totalSupervisees',
                ));
            }
            if($role=='lecturer')
            {
                $supervisorProfile = SupervisorProfile::where('user_id', Auth::id())->first();
                if ($supervisorProfile) {
                    $totalSupervisees = SupervisionRequest::where('lecturer_id', $supervisorProfile->id)
                        ->where('status', 'approved')
                        ->count();

                    $pendingRequests = SupervisionRequest::where('lecturer_id', $supervisorProfile->id)
                        ->where('status', 'pending')
                        ->count();
                    return view('lecturer.home', compact('totalSupervisees', 'pendingRequests'));
                }
                return view('lecturer.home', ['totalSupervisees' => 0, 'pendingRequests' => 0]);
            }
            if($role=='student')
            {
                $studentProfile = StudentProfile::where('user_id', Auth::id())->first();
                if ($studentProfile) {
                    $approvedRequest = SupervisionRequest::where('student_id', $studentProfile->id)
                        ->where('status', 'approved')
                        ->first();

                    $pendingRequests = SupervisionRequest::where('student_id', $studentProfile->id)
                        ->where('status', 'pending')
                        ->count();

                    return view('student.home', [
                        'hasSupervisor' => !is_null($approvedRequest),
                        'supervisorId' => $approvedRequest ? $approvedRequest->lecturer_id : null,
                        'pendingRequests' => $pendingRequests,
                        'studentProfile' => $studentProfile
                    ]);
                }
                return view('student.home', [
                    'hasSupervisor' => false,
                    'supervisorId' => null,
                    'pendingRequests' => 0,
                    'studentProfile' => null
                ]);
            }
            else
            {
                return redirect()->back();
            }
        }
    }

    public function create_student() {
        return view('admin.create_student');
    }

    public function store_student(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'userId' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'usertype' => 'string',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->userId = $validated['userId'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $user->role = 'student';
        $user->save();

        return redirect()->back()->with('success', 'Student created successfully.');
    }

    public function create_lecturer() {
        return view('admin.create_lecturer');
    }

    public function store_lecturer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'userId' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'usertype' => 'string',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->userId = $validated['userId'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $user->role = 'lecturer';
        $user->save();

        return redirect()->back()->with('success', 'Lecturer created successfully.');
    }

    public function create_admin() {
        return view('admin.create_admin');
    }

    public function store_admin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'userId' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'usertype' => 'string',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->userId = $validated['userId'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $user->role = 'admin';
        $user->save();

        return redirect()->back()->with('success', 'Admin created successfully.');
    }

    public function admin_edit_student_profile($id) {
        $user = User::find($id);
        $sessions = StudentSession::all();
        $student_profile = StudentProfile::where('id', $id)->first();
        return view('admin.admin_edit_student_profile', compact('user', 'sessions', 'student_profile'));
    }

    public function admin_edit_lecturer_profile($id) {
        $user = User::find($id);
        $profile = SupervisorProfile::where('id', $id)->first();
        $expertiseTags = Expertise::getAllExpertiseTags();
        return view('admin.admin_edit_lecturer_profile', compact('user', 'profile', 'expertiseTags'));
    }

    public function view_admins(Request $request)
    {
    if ($request->ajax()) {
            $data = User::select(['id', 'name', 'email', 'userId'])->where('role', '=', 'admin');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {

                    $profileUrl = url('/admin_edit_lecturer_profile', $row->id);
                        $supervisorProfile = SupervisorProfile::where('user_id', $row->id)->first();

                    // Conditional button for PDF report
                    $reportButton = $supervisorProfile
                        ? '<a href="' . route('supervisee.report', $supervisorProfile->id) . '"
                            class="btn btn-danger btn-sm w-10" title="Generate Supervisor Report">
                                <i class="bi bi-file-earmark-pdf"></i>
                        </a>'
                        : '<button class="btn btn-secondary btn-sm w-10" title="Generate Supervisor Report"
                            onclick="return confirm(\'This user needs a profile first.\')">
                                <i class="bi bi-file-earmark-pdf"></i>
                        </button>';

                    return '
                        <div class="border-0 p-2">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="'.$profileUrl.'" class="btn btn-primary btn-sm w-10" title="Update User Profile">
                                    <i class="bi bi-person"></i>
                                </a>

                                '.$reportButton.'

                                <a href="'.url('/edit_user', $row->id).'"
                                    title="Update User Data" class="btn btn-secondary btn-sm w-10">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a href="'.url('/delete_user', $row->id).'" class="btn btn-outline-danger btn-sm w-10"
                                    title="Delete User" onclick="return confirm(\'Are you sure to delete this user?\')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    ';
                })


                ->rawColumns(['action']) // allow HTML buttons
                ->make(true);
        }

        // For normal page load (non-AJAX)
        return view('admin.view_admins');
    }

    public function view_lecturers(Request $request)
    {
    // Handle AJAX request from DataTables
        if ($request->ajax()) {
            $data = User::select(['id', 'name', 'email', 'userId'])->where('role', '=', 'lecturer');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {

                    $profileUrl = url('/admin_edit_lecturer_profile', $row->id);
                    $supervisorProfile = SupervisorProfile::where('user_id', $row->id)->first();

                    // Conditional button for PDF report
                    $reportButton = $supervisorProfile
                        ? '<a href="' . route('supervisee.report', $supervisorProfile->id) . '"
                            class="btn btn-danger btn-sm w-10" title="Generate Supervisor Report">
                                <i class="bi bi-file-earmark-pdf"></i>
                        </a>'
                        : '<button class="btn btn-secondary btn-sm w-10" title="Generate Supervisor Report"
                            onclick="return confirm(\'This user needs a profile first.\')">
                                <i class="bi bi-file-earmark-pdf"></i>
                        </button>';

                    return '
                        <div class="border-0 p-2">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="'.$profileUrl.'" class="btn btn-primary btn-sm w-10" title="Update User Profile">
                                    <i class="bi bi-person"></i>
                                </a>

                                '.$reportButton.'

                                <a href="'.url('/edit_user', $row->id).'"
                                    title="Update User Data" class="btn btn-secondary btn-sm w-10">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a href="'.url('/delete_user', $row->id).'" class="btn btn-outline-danger btn-sm w-10"
                                    title="Delete User" onclick="return confirm(\'Are you sure to delete this user?\')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    ';
                })


                ->rawColumns(['action']) // allow HTML buttons
                ->make(true);
        }

        // For normal page load (non-AJAX)
        return view('admin.view_lecturers');
    }

    public function view_students(Request $request)
    {
    // Handle AJAX request from DataTables
        if ($request->ajax()) {
            $data = User::select(['id', 'name', 'email', 'userId'])->where('role', '=', 'student');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $profileUrl = url('/admin_edit_student_profile', $row->id);
                    $studentProfile = StudentProfile::where('user_id', $row->id)->first();

                    $reportButton = $studentProfile
                        ? '<a href="' . route('student.report', $studentProfile->id) . '"
                            class="btn btn-danger btn-sm w-10" title="Generate Student Report">
                                <i class="bi bi-file-earmark-pdf"></i>
                        </a>'
                        : '<button class="btn btn-secondary btn-sm w-10"
                            title="Generate Student Report" onclick="return confirm(\'This user needs a profile first.\')">
                                <i class="bi bi-file-earmark-pdf"></i>
                        </button>';

                    return '
                        <div class="border-0 p-2">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="'.$profileUrl.'" class="btn btn-primary btn-sm w-10" title="Update User Profile">
                                    <i class="bi bi-person"></i>
                                </a>

                                '.$reportButton.'

                                <a href="'.url('/edit_user', $row->id).'"
                                    title="Update User Data" class="btn btn-secondary btn-sm w-10">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a href="'.url('/delete_user', $row->id).'" class="btn btn-outline-danger btn-sm w-10"
                                    title="Delete User" onclick="return confirm(\'Are you sure to delete this user?\')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    ';
                })


                ->rawColumns(['action']) // allow HTML buttons
                ->make(true);
        }

        // For normal page load (non-AJAX)
        return view('admin.view_students');
    }

    public function edit_user($id) {
        $user = User::find($id);
        return view('admin.edit_user', compact('user'));
    }

    public function update_user(Request $request, $id) {
        $user = User::find($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'userId' => 'required|string|max:15|unique:users,userId,' . $user->id,
            'role' => 'string',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->userId = $validated['userId'];
        $user->role = $validated['role'];

        $user->save();

        if ($user->role == 'student') {
            return redirect('/view_students')->with('success', 'User updated successfully.');
        } elseif ($user->role == 'lecturer') {
            return redirect('/view_lecturers')->with('success', 'User updated successfully.');
        } elseif ($user->role == 'admin') {
            return redirect('/view_admins')->with('success', 'User updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Invalid user role.');
        }
    }

    public function delete_user($id) {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $student_profile = StudentProfile::where('user_id', $id)->first();
        $profile = SupervisorProfile::where('user_id', $id)->first();

        if ($profile) {
            $profile->delete();
        }

        if ($student_profile) {
            $student_profile->delete();
        }

        $user->delete();

        return redirect()->back();
    }

    public function search_users(Request $request)
    {
        $query = $request->input('query');
        $results = User::search($query)->get();
        return view('admin.search_result', compact('results', 'query'));
    }

    public function student_session() {
        $sessions = StudentSession::select("*")->paginate(5);
        return view('admin.student_session', compact('sessions'));
    }

    public function store_session(Request $request)
    {
        $validated = $request->validate([
            'session_name' => 'required|string|max:255|unique:student_sessions',
        ]);

        $session = new StudentSession();
        $session->session_name = $validated['session_name'];
        $session->save();

        return redirect()->back()->with('success', 'Student session created successfully.');
    }

    public function edit_session($id) {
        $session = StudentSession::find($id);
        return view('admin.edit_session', compact('session'));
    }

    public function update_session(Request $request, $id) {
        $session = StudentSession::find($id);

        $validated = $request->validate([
            'session_name' => 'required|string|max:255|unique:student_sessions,session_name,' . $session->id,
        ]);

        $session->session_name = $validated['session_name'];
        $session->save();

        return redirect('/student_session')->with('success', 'Student session updated successfully.');
    }

    public function delete_session($id) {
        $session = StudentSession::find($id);
        $session->delete();

        return redirect()->back()->with('success', 'Student session deleted successfully.');
    }

    public function search_session(Request $request){
        $query = $request->input('query');
        $results = StudentSession::search($query)->paginate(5);
        return view('admin.search_session_result', compact('results', 'query'));
    }

    public function manage_request() {
        $supervision_requests = SupervisionRequest::select("*")->paginate(10);
        $students_profile = StudentProfile::all();
        $supervisors_profile = SupervisorProfile::all();
        return view('admin.manage_request', compact('supervision_requests', 'students_profile', 'supervisors_profile'));
    }

    public function delete_request($id) {
        $request = SupervisionRequest::find($id);
        $request->delete();

        return redirect()->back()->with('success', 'Request deleted!');
    }

    public function update_student_request($id) {
        $request = SupervisionRequest::find($id);
        $students_profile = StudentProfile::all();
        $supervisors_profile = SupervisorProfile::all();
        return view('admin.update_student_request', compact('request', 'students_profile', 'supervisors_profile'));
    }

    public function updated_student_request(Request $request, $id) {

        $supervision_request = SupervisionRequest::find($id);

        $validated = $request->validate([
            'project_title' => 'required',
            'request_message' => 'required',
            'status' => 'required',
        ]);

        $supervision_request->project_title = $validated['project_title'];
        $supervision_request->request_message = $validated['request_message'];
        $supervision_request->status = $validated['status'];
        $supervision_request->save();

        return redirect('/manage_request')->with('success', 'Request data updated successfully.');
    }

    public function change_request_supervisor(Request $request, $id) {
        $requestModel = SupervisionRequest::find($id);
        $query = $request->input('query');

        if ($query) {
            // Meilisearch using Scout
            $supervisors_profile = SupervisorProfile::search($query)->paginate(5);
        } else {
            // Default
            $supervisors_profile = SupervisorProfile::paginate(5);
        }

        $user = User::all();
        $student_profile = StudentProfile::all();

        return view('admin.change_request_supervisor', compact(
            'requestModel',
            'supervisors_profile',
            'user',
            'student_profile',
            'query'
        ));
    }

    public function update_requested_supervisor($request_id, $supervisor_id) {
        // Find the student's supervision request
        $supervision_request = SupervisionRequest::find($request_id);

        if (!$supervision_request) {
            return redirect()->back()->with('error', 'Supervision request not found.');
        }

        // Update lecturer_id with the selected supervisor id
        $supervision_request->lecturer_id = $supervisor_id;
        $supervision_request->save();

        return redirect('/manage_request')->with('success', 'Supervisor updated successfully.');
    }

    public function search_request(Request $request)
    {
        $query = $request->input('query');

        // Search each model separately using MeiliSearch
        $supervisorMatches = SupervisorProfile::search($query)->get();
        $studentMatches = StudentProfile::search($query)->get();
        $requestMatches = SupervisionRequest::search($query)->get();

        // Collect related SupervisionRequests from supervisor matches
        $requestsFromSupervisors = SupervisionRequest::whereIn(
            'lecturer_id',
            $supervisorMatches->pluck('id')
        )->get();

        // Collect related SupervisionRequests from student matches
        $requestsFromStudents = SupervisionRequest::whereIn(
            'student_id',
            $studentMatches->pluck('id')
        )->get();

        // Merge and remove duplicates
        $allResults = $requestMatches
            ->merge($requestsFromSupervisors)
            ->merge($requestsFromStudents)
            ->unique('id');

        return view('admin.search_request_result', [
            'results' => $allResults,
            'query' => $query,
        ]);
    }

    public function search_supervisor(Request $request, $id)
    {
        $requestModel = SupervisionRequest::find($id);
        $query = $request->input('query');

        if ($query) {
            // Meilisearch using Scout
            $supervisors_profile = SupervisorProfile::search($query)->paginate(5);
        } else {
            // Default
            $supervisors_profile = SupervisorProfile::paginate(5);
        }

        $user = User::all();
        $student_profile = StudentProfile::all();

        return view('admin.search_supervisor_result', compact(
            'requestModel',
            'supervisors_profile',
            'user',
            'student_profile',
            'query'
        ));
    }

    public function create_supervision(Request $request) {
        // Get selected supervisor name if passed
        $supervisorName = $request->input('supervisor_name');

        return view('admin.create_supervision', [
            'supervisorName' => $supervisorName,
        ]);
    }

    public function select_request_supervisor(Request $request) {
        $users = User::all();
        $supervisors = SupervisorProfile::select('*')->paginate(10); // or paginate(10)
        $returnUrl = $request->query('return'); // get the return URL
        return view('admin.select_supervisor', compact('supervisors', 'returnUrl', 'users'));
    }

    public function select_request_student(Request $request) {
        $users = User::all();
        $students = StudentProfile::select('*')->paginate(10); // or paginate(10)
        $returnUrl = $request->query('return'); // get the return URL
        return view('admin.select_student', compact('students', 'returnUrl', 'users'));
    }

    public function search_supervisor_inRequest(Request $request) {
        $query = $request->input('query');
        $returnUrl = $request->input('return', url('/create_supervision'));

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
        $supervisors = $supervisorMatches
            ->merge($supervisorsFromUsers)
            ->unique('id');

        return view('admin.search_supervisor_inRequest_result', [
            'supervisors' => $supervisors,
            'returnUrl' => $returnUrl,
            'query' => $query,
        ]);
    }

    public function search_student_inRequest(Request $request) {
        $query = $request->input('query');
        $returnUrl = $request->input('return', url('/create_supervision'));

        // Search SupervisorProfile using Meilisearch
        $studentMatches = StudentProfile::search($query)->get();

        // Search User model using Meilisearch
        $userMatches = User::search($query)->get();

        // Get supervisors linked to matched users
        $supervisorsFromUsers = StudentProfile::whereIn(
            'user_id',
            $userMatches->pluck('id')
        )->get();

        // Merge all supervisor results & remove duplicates
        $students = $studentMatches
            ->merge($supervisorsFromUsers)
            ->unique('id');

        return view('admin.search_student_inRequest_result', [
            'students' => $students,
            'returnUrl' => $returnUrl,
            'query' => $query,
        ]);
    }

    public function create_student_request(Request $request) {

        if ($request->input('student_id') == null || $request->input('supervisor_id') == null) {
            return redirect()->back()->with('error', 'Please select both a student and a supervisor.');
        };

        SupervisionRequest::create([
            'student_id' => $request->input('student_id') ?: 'Not provided',
            'lecturer_id' => $request->input('supervisor_id') ?: 'Not provided',
            'project_title' => $request->input('project_title') ?: 'Not provided',
            'request_message' => $request->input('request_message') ?: 'Not provided',
            'status' => $request->input('status') ?: 'Not provided',
            'request_date' => now(),
        ]);

        return redirect('create_supervision')->with('success', 'Supervision Created!');
    }

    public function manage_expertise() {
        $expertiseTags = Expertise::select("*")->paginate(5);
        return view('admin.manage_expertise', compact('expertiseTags'));
    }

    public function add_expertise(Request $request) {
        $validated = $request->validate([
            'expertise_tag' => 'required|string|max:255|unique:expertises,expertise_tag',
        ]);

        Expertise::create([
            'expertise_tag' => trim($validated['expertise_tag']),
        ]);

        return redirect()->back()->with('success', 'Expertise tag added successfully.');
    }

    public function delete_expertise($id) {
        $expertise = Expertise::find($id);

        if (!$expertise) {
            return redirect()->back()->with('error', 'Expertise tag not found.');
        }

        $expertise->delete();

        return redirect()->back()->with('success', 'Expertise tag deleted successfully.');
    }

    public function search_expertise(Request $request){
        $query = $request->input('query');
        $results = Expertise::search($query)->paginate(5);
        return view('admin.search_expertise_result', compact('results', 'query'));
    }

}
