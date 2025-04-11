<?php

namespace App\Http\Controllers\userController;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\AdminReviewTable;
use App\Models\ClientReviewTable;
use App\Models\evaluationTable;
use App\Models\HrReviewTable;
use App\Models\ManagerReviewTable;
use App\Models\SuperAddUser;
use App\Models\SuperUserTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class allUserController extends Controller
{
    //

    public function indexUserLogin()
    {
        $superUser = null;
        return view("loginusers/userlogin", compact('superUser'));
    }


    // Handle user login and send OTP
    public function loginUserAutenticacaon(Request $request)
    {
        // Validate the input fields
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4',
            'user_type' => 'required|string',
        ]);
        // Check if the user exists by email
        $userslogin = SuperAddUser::where('email', $validated['email'])->first();
        $superUsersLogin = SuperUserTable::where('email', $validated['email'])->first();

        if ((isset($userslogin) && $userslogin->email !== $validated['email'])  || (isset($superUsersLogin) && $superUsersLogin->email !== $validated['email'])) {

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email address!',
            ]);
        } elseif ((isset($userslogin) && $userslogin->user_type !== $validated['user_type'])  || (isset($superUsersLogin) && $superUsersLogin->user_type !== $validated['user_type'])) {
            # code...
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect user type!',
            ]);
        } elseif ((isset($superUsersLogin) && !Hash::check($validated['password'], $superUsersLogin->password)) ||
            (isset($userslogin) && !Hash::check($validated['password'], $userslogin->password))
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect password!',
            ]);
        }

        // Generate OTP and store it in the session
        $otp = random_int(100000, 999999);

        $userEmail = isset($userslogin) ? $userslogin->email : (isset($superUsersLogin) ? $superUsersLogin->email : null);
        $userType = isset($userslogin) ? $userslogin->user_type : (isset($superUsersLogin) ? $superUsersLogin->email : null);
        $empId = isset($userslogin) ? $userslogin->employee_id  : (isset($superUsersLogin) ? $superUsersLogin->employee_id : null);
        Session::put('user_email', $userEmail);
        Session::put('user_type', $userType);
        Session::put('employee_id', $empId);
        Session::put('otp', $otp);
        Session::put('otp_email', $validated['email']);
        Session::put('otp_sent_time', now());

        try {
            Mail::to($validated['email'])->send(new OtpMail($otp));

            return response()->json([
                'status' => 'success',
                'message' => 'OTP has been sent to your email!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send OTP email. Please try again later.',
                'debug' => env('APP_DEBUG') ? $e->getMessage() : null,
            ]);
        }
    }

    // OTP Verification and User Login
    public function loginUserverifyOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|integer',
        ]);

        // Retrieve the OTP and email from the session
        $otpSession = Session::get('otp');
        $otpEmail = Session::get('otp_email');
        $otpSentTime = Session::get('otp_sent_time');

        // Check if OTP is expired (e.g., valid for 10 minutes)
        if ($otpSentTime && now()->diffInMinutes($otpSentTime) > 10) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new one.',
            ]);
        }

        // Validate the OTP and email
        if ($validated['otp'] == $otpSession && $validated['email'] == $otpEmail) {

            // Find the user based on email
            $user = SuperAddUser::where('email', $validated['email'])->first();
            $superUser = SuperUserTable::where('email', $validated['email'])->first();
            if ($user || $superUser) {
                $userEmail = isset($user) ? $user->email : $superUser->email;
                $userType = isset($user) ? $user->user_type : $superUser->user_type;

                // Store user data in session
                // Session::put('user_id', $user->id);
                Session::put('user_email', $userEmail);
                Session::put('user_type', $userType);
                if ($userType == 'Super User') {
                    $redirectRoute = match ($userType) {
                        'Super User' => route('super-admin-view'),
                        'Super User' => route('appraisal-view'),
                        'Super User' => route('logged-Out'),
                        default => route('all-user-login'),
                    };
                } else {
                    // Redirect based on user type
                    $redirectRoute = match ($userType) {
                        'admin' => route('admin-dashboard'),
                        'hr' => route('hr-dashboard'),
                        'users' => route('users-dashboard'),
                        'manager' => route('manager-dashboard'),
                        'client' => route('client-dashboard'),
                        default => route('login'),
                    };
                }


                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP verified successfully!',
                    'redirect' => $redirectRoute
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid OTP. Please try again.',
        ]);
    }


    public function userLogOut(Request $request)
    {

        Session::flush();
        $request->session()->invalidate();
        
        // Regenerate the CSRF token to prevent reusing the previous token after logout
        session()->regenerateToken();

        // Redirect to login page
        return redirect('/');
    }

    //All Users view dashboard

    public function admin()
    {
        return view('delostyleUsers/admin-dashboard');  
    }

    public function adminReviewSection()
    {
        return view('delostyleUsers/admin-review-section');
    }

    public function clientReviewSection()
    {

        return view('delostyleUsers.client-review-section');
    }
    public function searchUser(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $name = $request->input('name');

        $query = SuperAddUser::query();

        if (!empty($employeeId)) {
            $query->where('employee_id', $employeeId);
        } elseif (!empty($name)) {
            $query->whereRaw("CONCAT(fname, ' ', lname) LIKE ?", ["%$name%"]);
        }

        $users = $query->get();

        if ($users->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No users found!'
            ]);
        }
    }


    public function adminReviewStore(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|string',
            'demonstrated_attendance' => 'required|string',
            'comments_demonstrated_attendance' => 'required|string|max:255',
            'employee_manage_shift' => 'required|string',
            'comments_employee_manage_shift' => 'required|string|max:255',
            'documentation_neatness' => 'required|string',
            'comments_documentation_neatness' => 'required|string|max:255',
            'followed_instructions' => 'required|string',
            'comments_followed_instructions' => 'required|string|max:255',
            'productive' => 'required|string',
            'comments_productive' => 'required|string|max:255',
            'changes_schedules' => 'required|string',
            'comments_changes_schedules' => 'required|string|max:255',
            'leave_policy' => 'required|string',
            'comments_leave_policy' => 'required|string|max:255',
            'salary_deduction' => 'required|string',
            'comments_salary_deduction' => 'required|string|max:255',
            'interact_housekeeping' => 'required|string',
            'comments_interact_housekeeping' => 'required|string|max:255',
            'AdminTotalReview' => 'required|numeric|max:200'
        ]);

        // Prepare data for insertion
        $data = [
            'emp_id' => $request->input('emp_id'),
            'demonstrated_attendance' => $request->input('demonstrated_attendance'),
            'comments_demonstrated_attendance' => $request->input('comments_demonstrated_attendance'),
            'employee_manage_shift' => $request->input('employee_manage_shift'),
            'comments_employee_manage_shift' => $request->input('comments_employee_manage_shift'),
            'documentation_neatness' => $request->input('documentation_neatness'),
            'comments_documentation_neatness' => $request->input('comments_documentation_neatness'),
            'followed_instructions' => $request->input('followed_instructions'),
            'comments_followed_instructions' => $request->input('comments_followed_instructions'),
            'productive' => $request->input('productive'),
            'comments_productive' => $request->input('comments_productive'),
            'changes_schedules' => $request->input('changes_schedules'),
            'comments_changes_schedules' => $request->input('comments_changes_schedules'),
            'leave_policy' => $request->input('leave_policy'),
            'comments_leave_policy' => $request->input('comments_leave_policy'),
            'salary_deduction' => $request->input('salary_deduction'),
            'comments_salary_deduction' => $request->input('comments_salary_deduction'),
            'interact_housekeeping' => $request->input('interact_housekeeping'),
            'comments_interact_housekeeping' => $request->input('comments_interact_housekeeping'),
            'AdminTotalReview' => $request->input('AdminTotalReview'),
        ];
        AdminReviewTable::create($data);
        return response()->json(['message' => 'Review submitted successfully!']);
    }



    public function hr()
    {
        return view('delostyleUsers/hr-dashboard'); 
    }

    public function hrReviewSection()
    {
        return view('delostyleUsers/hr-review-section');
    }

    public function hrReviewStore(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|string',
            'adherence_hr' => 'required|string',
            'comments_adherence_hr' => 'required|string|max:255',
            'professionalism_positive' => 'required|string',
            'comments_professionalism' => 'required|string|max:255',
            'respond_feedback' => 'required|string',
            'comments_respond_feedback' => 'required|string|max:255',
            'initiative' => 'required|string',
            'comments_initiative' => 'required|string|max:255',
            'interest_learning' => 'required|string',
            'comments_interest_learning' => 'required|string|max:255',
            'company_leave_policy' => 'required|string',
            'comments_company_leave_policy' => 'required|string|max:255',
            // 'HrTotalReview' => 'required|string',
        ]);

        $data = $request->only([
            'emp_id',
            'adherence_hr',
            'comments_adherence_hr',
            'professionalism_positive',
            'comments_professionalism',
            'respond_feedback',
            'comments_respond_feedback',
            'initiative',
            'comments_initiative',
            'interest_learning',
            'comments_interest_learning',
            'company_leave_policy',
            'comments_company_leave_policy',
            'HrTotalReview'
        ]);
        HrReviewTable::create($data);
        return response()->json(['message' => 'Review submitted successfully!']);
    }

    public function user()
    {
        return view('delostyleUsers/users-dashboard');  
    }

    public function manager()
    {
        return view('delostyleUsers/manager-dashboard');
    }

    public function managerReviewSection()
    {

        return view('delostyleUsers/manager-review-section');
    }

    public function managerReviewStore(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|string',
            'rate_employee_quality' => 'required|string',
            'comments_rate_employee_quality' => 'required|string|max:255',
            'organizational_goals' => 'required|string',
            'comments_organizational_goals' => 'required|string|max:255',
            'collaborate_colleagues' => 'required|string',
            'comments_collaborate_colleagues' => 'required|string|max:255',
            'demonstrated' => 'required|string',
            'comments_demonstrated' => 'required|string|max:255',
            'leadership_responsibilities' => 'required|string',
            'comments_leadership_responsibilities' => 'required|string|max:255',
            'thinking_contribution' => 'required|string',
            'comments_thinking_contribution' => 'required|string|max:255',
            'informed_progress' => 'required|string',
            'comments_comments_informed_progress' => 'required|string|max:255',
            'ManagerTotalReview' => 'required|numeric|max:200'

        ]);

           $data = $request->only([
            'emp_id',
            'rate_employee_quality',
            'comments_rate_employee_quality',
            'organizational_goals',
            'comments_organizational_goals',
            'collaborate_colleagues',
            'comments_collaborate_colleagues',
            'demonstrated',
            'comments_demonstrated',
            'leadership_responsibilities',
            'comments_leadership_responsibilities',
            'thinking_contribution',
            'comments_thinking_contribution',
            'informed_progress',
            'comments_comments_informed_progress',
            'ManagerTotalReview'
        ]);
        ManagerReviewTable::create($data);
        return response()->json(['message' => 'Review submitted successfully!']);
    }

    public function client()
    {
        return view('delostyleUsers/client-dashboard'); 
    }



    public function viewClientDashBoard()
    {

        return view('delostyleUsers.client-dashboard');
    }

    // client data store
    public function clientReviewStore(Request $request)
    {

        try {
            // Validate request input
            $validatedData = $request->validate([
                'emp_id' => 'required|string|max:255',
                'understand_requirements' => 'nullable|string|max:20',
                'comment_understand_requirements' => 'nullable|string|max:255',
                'business_needs' => 'nullable|string|max:20',
                'comments_business_needs' => 'nullable|string|max:255',
                'detailed_project_scope' => 'nullable|string|max:20',
                'comments_detailed_project_scope' => 'nullable|string|max:255',
                'responsive_reach_project' => 'nullable|string|max:20',
                'comments_responsive_reach_project' => 'nullable|string|max:255',
                'comfortable_discussing' => 'nullable|string|max:20',
                'comments_comfortable_discussing' => 'nullable|string|max:255',
                'regular_updates' => 'nullable|string|max:20',
                'comments_regular_updates' => 'nullable|string|max:255',
                'concerns_addressed' => 'nullable|string|max:20',
                'comments_concerns_addressed' => 'nullable|string|max:255',
                'technical_expertise' => 'nullable|string|max:20',
                'comments_technical_expertise' => 'nullable|string|max:255',
                'best_practices' => 'nullable|string|max:20',
                'comments_best_practices' => 'nullable|string|max:255',
                'suggest_innovative' => 'nullable|string|max:20',
                'comments_suggest_innovative' => 'nullable|string|max:255',
                'quality_code' => 'nullable|string|max:20',
                'comments_quality_code' => 'nullable|string|max:255',
                'encounter_issues' => 'nullable|string|max:20',
                'comments_encounter_issues' => 'nullable|string|max:255',
                'code_scalable' => 'nullable|string|max:20',
                'comments_code_scalable' => 'nullable|string|max:255',
                'solution_perform' => 'nullable|string|max:20',
                'comments_solution_perform' => 'nullable|string|max:255',
                'project_delivered' => 'nullable|string|max:20',
                'comments_project_delivered' => 'nullable|string|max:255',
                'communicated_handled' => 'nullable|string|max:20',
                'comments_communicated_handled' => 'nullable|string|max:255',
                'development_process' => 'nullable|string|max:20',
                'comments_development_process' => 'nullable|string|max:255',
                'unexpected_challenges' => 'nullable|string|max:20',
                'comments_unexpected_challenges' => 'nullable|string|max:255',
                'effective_workarounds' => 'nullable|string|max:20',
                'comments_effective_workarounds' => 'nullable|string|max:255',
                'bugs_issues' => 'nullable|string|max:20',
                'comments_bugs_issues' => 'nullable|string|max:255',
                'ClientTotalReview' => 'required|numeric|max:200'

            ]);

            $user = SuperAddUser::where('employee_id', $validatedData['emp_id'])->first();
            if ($user) {
                $roles = json_decode($user->user_roles, true); 

                if (is_array($roles) && in_array('client', $roles)) {
                    ClientReviewTable::create($validatedData);
                    return response()->json(['message' => 'Review submitted successfully!'], 200);
                }
            }
            return response()->json(['error' => 'You are not authorized to submit this review.'], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong! Check logs.'], 500);
        }
    }

    public function reviewUserReport($emp_id)
    {
        // Fetch review data
        $userData = [
            'superadduser' => DB::table('super_add_users')->where('employee_id', $emp_id)->first(),
            'managerReview' => DB::table('manager_review_tables')->where('emp_id', $emp_id)->first(),
            'adminReview' => DB::table('admin_review_tables')->where('emp_id', $emp_id)->first(),
            'hrReview' => DB::table('hr_review_tables')->where('emp_id', $emp_id)->first(),
            'clientReview' => DB::table('client_review_tables')->where('emp_id', $emp_id)->first(),
            'evaluation' => DB::table('evaluation_tables')->where('emp_id', $emp_id)->first(),
        ];

        // Debugging: Check if $userData is being retrieved
        if (collect($userData)->filter()->isEmpty()) {
            return redirect()->back()->with('error', 'No review data found for this employee.');
        }

        return view('delostyleUsers.user-review-report', compact('userData', 'emp_id'));
    }



    //View Reports
    public function evaluationDetails($emp_id)
    {
        $user = evaluationTable::where('emp_id', $emp_id)->firstOrFail();
        // Return the view as a partial for AJAX response
        return view('reports.evaluationReport', compact('user'));
    }

    public function managerReport($emp_id)
    {
        $user = ManagerReviewTable::where('emp_id', $emp_id)->firstOrFail();
        return view('reports.managerReport', compact('user'));
    }

    public function adminReport($emp_id)
    {
        $user = AdminReviewTable::where('emp_id', $emp_id)->firstOrFail();
        return view('reports.adminReport', compact('user'));
    }

    public function hrReport($emp_id)
    {
        $user = HrReviewTable::where('emp_id', $emp_id)->firstOrFail();
        return view('reports.hrReport', compact('user'));
    }

    public function clientReport($emp_id)
    {
        $user = ClientReviewTable::where('emp_id', $emp_id)->firstOrFail();
        return view('reports.clientReport', compact('user'));
    }

    public function loadReport($reportType, $emp_id)
    {
        // Check the report type and fetch the corresponding data
        switch ($reportType) {
            case 'evaluation':
                $user = evaluationTable::where('emp_id', $emp_id)->firstOrFail();
                return view('reports.evaluation', compact('user'));
            case 'managerReport':
                $user = ManagerReviewTable::where('emp_id', $emp_id)->firstOrFail();
                return view('reports.managerReport', compact('user'));
            case 'adminReport':
                $user = AdminReviewTable::where('emp_id', $emp_id)->firstOrFail();
                return view('reports.adminReport', compact('user'));
            case 'hrReport':
                $user = HrReviewTable::where('emp_id', $emp_id)->firstOrFail();
                return view('reports.hrReport', compact('user'));
            case 'clientReport':
                $user = ClientReviewTable::where('emp_id', $emp_id)->firstOrFail();
                return view('reports.clientReport', compact('user'));
            default:
                return response()->json(['error' => 'Invalid report type'], 400);
        }
    }

    public function getHrReviewsList(Request $request)
    {
        $validEmployeeIds = HrReviewTable::pluck('emp_id')
            ->merge(EvaluationTable::pluck('emp_id'))
            ->unique()
            ->toArray();


        $superAddUser = SuperAddUser::where('status', 1)
            ->whereIn('employee_id', $validEmployeeIds)
            ->get();


        $hrReviewTable = HrReviewTable::whereIn('emp_id', $validEmployeeIds)->get();


        $evaluation = EvaluationTable::whereIn('emp_id', $validEmployeeIds)->get();

        return view('reports.hrReportView', compact('superAddUser', 'hrReviewTable', 'evaluation'));
    }



    public function showDetailsHr($employee_id)
    {

        $employee = SuperAddUser::where('employee_id', $employee_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found');
        }
        $reviews = HrReviewTable::where('emp_id', $employee_id)->get();

        return view('reports.userDetailsHrView', compact('employee', 'reviews'));
    }

    public function showEvaluationDetails($employee_id)
    {

        $employee = SuperAddUser::where('employee_id', $employee_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found');
        }
        $eval = evaluationTable::where('emp_id', $employee_id)->first();
        return view('reports.userEvaluationDetails', compact('employee', 'eval'));
    }

    public function getAdminReviewList(Request $request)
    {
        $validEmployeeIds = AdminReviewTable::pluck('emp_id')
            ->merge(EvaluationTable::pluck('emp_id'))
            ->unique()
            ->toArray();


        $superAddUser = SuperAddUser::where('status', 1)
            ->whereIn('employee_id', $validEmployeeIds)
            ->get();


        $adminReviewTable = AdminReviewTable::whereIn('emp_id', $validEmployeeIds)->get();
        $evaluation = EvaluationTable::whereIn('emp_id', $validEmployeeIds)->get();

        return view('reports.adminReportView', compact('superAddUser', 'adminReviewTable', 'evaluation'));
    }

    //Admin Review Show Details
    public function showDetails($employee_id)
    {
        $employee = SuperAddUser::where('employee_id', $employee_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found');
        }
        $reviews = AdminReviewTable::where('emp_id', $employee_id)->get();
        return view('reports.userDetailsAdminView', compact('employee', 'reviews'));
    }

    public function getManagerReviewList(Request $request)
    {
        $validEmployeeIds = ManagerReviewTable::pluck('emp_id')
            ->merge(EvaluationTable::pluck('emp_id'))
            ->unique()
            ->toArray();

        $superAddUser = SuperAddUser::where('status', 1)
            ->whereIn('employee_id', $validEmployeeIds)
            ->get();


        $managerReviewTable = ManagerReviewTable::whereIn('emp_id', $validEmployeeIds)->get();


        $evaluation = EvaluationTable::whereIn('emp_id', $validEmployeeIds)->get();

        return view('reports.managerReportView', compact('superAddUser', 'managerReviewTable', 'evaluation'));
    }


    public function showDetailsManager($employee_id)
    {

        $employee = SuperAddUser::where('employee_id', $employee_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        $reviews = ManagerReviewTable::where('emp_id', $employee_id)->get();
        return view('reports.userDetailsManagerView', compact('employee', 'reviews'));
    }

    public function getClientReviewList(Request $request)
    {

        $validEmployeeIds = ClientReviewTable::pluck('emp_id')
            ->unique()
            ->toArray();

        $superAddUser = SuperAddUser::where('status', 1)
            ->whereIn('employee_id', $validEmployeeIds)
            ->get();

        $clientReviewTable = ClientReviewTable::whereIn('emp_id', $validEmployeeIds)->get();

        return view('reports.clientReportView', compact('superAddUser', 'clientReviewTable'));
    }



    public function showDetailsClient($employee_id)
    {

        $employee = SuperAddUser::where('employee_id', $employee_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }
        $reviews = ClientReviewTable::where('emp_id', $employee_id)->get();
        return view('reports.userDetailsClientView', compact('employee', 'reviews'));
    }
}
