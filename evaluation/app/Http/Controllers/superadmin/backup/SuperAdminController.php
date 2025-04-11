<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\AdminReviewTable;
use App\Models\ApprisalTable;
use App\Models\ClientReviewTable;
use App\Models\evaluationTable;
use App\Models\HrReviewTable;
use App\Models\ManagerReviewTable;
use App\Models\SuperAddUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\SuperUserTable;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;



class SuperAdminController extends Controller
{
    public function index()
    {
        return view("admin/loginForm");
    }

    // Login authentication and OTP generation



    public function testPageShow()
    {
        return view("test");
    }

    public function insertData(Request $request)
    {

        $data = [
            'email' => $request->input('email'),
            'user_type' => $request->input('user_type'),
            'password' => Hash::make($request->input('password')),
        ];

        $request = SuperUserTable::insert($data);
    }


    // public function testEmail()
    // {
    //     $otp = rand(100000, 999999);  // Generate a random OTP for testing

    //     try {
    //         // Sending the email
    //         Mail::to('amar.maity@delostylestudio.com')->send(new OtpMail($otp));
    //         return 'Test email sent!';
    //     } catch (\Exception $e) {
    //         return 'Failed to send email: ' . $e->getMessage();
    //     }
    // }    



    public function loginAutenticacao(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|email',
            'user_type' => 'required|string',
            'password' => 'required|string|min:4'
        ]);

        // Check if the user exists by email
        $userLogin = SuperUserTable::where('email', $validated['email'])->first();

        if (!$userLogin) {
            return response("Failed to send OTP:\nEmail does not match!", 401)
                ->header('Content-Type', 'text/plain');
        }

        // Check if the user type matches
        if ($userLogin->user_type !== $validated['user_type']) {
            return response("Failed to send OTP:\nIncorrect User Type!", 401)
                ->header('Content-Type', 'text/plain');
        }

        // Check if the password is correct
        if (!Hash::check($validated['password'], $userLogin->password)) {
            return response("Failed to send OTP:\nPassword is incorrect!", 401)
                ->header('Content-Type', 'text/plain');
        }
        // OTP Generation
        $otp = random_int(100000, 999999);
        Session::put('otp', $otp);
        Session::put('otp_sent_time', now());
        Session::put('user_type', $userLogin->user_type);
        Session::put('otp_email', $validated['email']);

        try {
            Mail::to($validated['email'])->send(new OtpMail($otp));

            return response()->json([
                'status' => 'success',
                'message' => 'OTP has been sent to your email!',
            ]);
        } catch (\Exception $e) {
            Log::error('OTP Email sending failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send OTP email. Please try again later.',
                'debug' => env('APP_DEBUG') ? $e->getMessage() : null,
            ]);
        }
    }

    // OTP verification
    public function verifyOtp(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|integer',
        ]);

        // Check if OTP exists in session
        $otpSession = Session::get('otp');
        $otpEmail = Session::get('otp_email');
        $otpSentTime = Session::get('otp_sent_time');

        // Check if the OTP is expired (valid for 5 minutes)
        if ($otpSentTime && now()->diffInMinutes($otpSentTime) > 10) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new one.',
                'redirect' => route('super-admin-view')
            ]);
        }

        // Verify OTP and email match
        if ($validated['otp'] == $otpSession && $validated['email'] == $otpEmail) {
            // Remove OTP from session after verification
            Session::forget('otp');
            Session::forget('otp_email');
            Session::forget('otp_sent_time');

            // Retrieve the user from database
            $user = SuperUserTable::where('email', $validated['email'])->first();

            if ($user) {
                // Set user_type in session for logged-in user
                Session::put('user_type', $user->id);
                Session::put('user_email', $user->email);

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP verified successfully. You are now logged in!',
                    'redirect' => route('super-admin-dashboard')
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP. Please try again.',
            ]);
        }
    }


    //Super Admin Dash Board view
    public function indexSuperAdminDashBoard()
    {
        return view('admin/SuperAdminDashbord');
    }


    // Retrieve the logged-in user's email from the session
    public function showDashboard()
    {

        $userEmail = Session::get('user_email');


        if ($userEmail) {
            return view('admin.SuperAdminDashbord', compact('userEmail'));
        } else {
            return redirect()->route('super-admin-view');  // Redirect to login if no session data
        }
    }

    //view All Review's 
    public function searchUser()
    {
        Paginator::useBootstrap();
        $employees = SuperAddUser::get()->all();
        return view('admin.superView', compact('employees'));
    }

    //View details of view all reviews
    public function showEvaluationReview($id)
    {
        $employee = evaluationTable::where('emp_id', $id)->first(); // Fetch employee details

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        return view('review.evaluationDetails', compact('employee')); // Pass employee data to view
    }


    //Fetching Data form mention table 
    public function superAdminSearchUser(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $employeeName = $request->input('employee_name');

        Log::info('Received Employee Search Request', [
            'employee_id' => $employeeId,
            'employee_name' => $employeeName
        ]);

        $query = SuperAddUser::query();

        // Search by Employee ID (Exact match)
        if (!empty($employeeId)) {
            $query->where('employee_id', $employeeId);
        }

        // Search by First Name or Last Name
        if (!empty($employeeName)) {
            $query->where(function ($q) use ($employeeName) {
                $q->where('fname', 'LIKE', "%$employeeName%")
                    ->orWhere('lname', 'LIKE', "%$employeeName%");
            });
        }

        $users = $query->get(); // Fetch all matching users


        Log::info('Search Result', ['users' => $users]);

        if ($users->count() > 0) {
            return response()->json([
                'success' => true,
                'users' => $users->map(function ($user) {
                    return [
                        'full_name' => $user->fname . ' ' . $user->lname,
                        'email' => $user->email,
                        'employee_id' => $user->employee_id,
                        'designation' => $user->designation,
                    ];
                })
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        // $user = $query->first();

        if ($user) {
            Log::info('User Found:', ['user' => $user]);

            // Fetching evaluation, HR, manager, and admin reviews
            $evaluationData = evaluationTable::where('emp_id', $user->employee_id)->first();
            $hrReviewTable = HrReviewTable::where('emp_id', $user->employee_id)->first();
            $managerReviewTable = ManagerReviewTable::where('emp_id', $user->employee_id)->first();
            $adminReviewTable = AdminReviewTable::where('emp_id', $user->employee_id)->first();
            $clientReviewTable = ClientReviewTable::where('emp_id', $user->employee_id)->first();

            return response()->json([
                'success' => true,
                'user' => [
                    'full_name' => $user->fname . ' ' . $user->lname,
                    'fname' => $user->fanme,
                    'lname' => $user->lname,
                    'email' => $user->email,
                    'employee_id' => $user->employee_id,
                    'designation' => $user->designation,
                ],
                'evaluation' => $evaluationData ? 'Completed' : 'Pending for Review',
                'hr_review' => $hrReviewTable ? 'Completed' : 'Pending for Review',
                'manager_review' => $managerReviewTable ? 'Completed' : 'Pending for Review',
                'admin_review' => $adminReviewTable ? 'Completed' : 'Pending for Review',
                'client_review' => $clientReviewTable ? 'Completed' : 'Pending for Review',

            ]);
        } else {
            Log::warning('User Not Found', [
                'employee_id' => $employeeId,
                'employee_name' => $employeeName
            ]);

            return response()->json([
                'success' => false,
                'message' => 'User not found!'
            ]);
        }
    }


    //Apprisal View
    public function appraisalView()
    {
        $users = SuperAddUser::all();

        return view('admin.apprisal', compact('users')); // Looks for resources/views/apprisal.blade.php
    }

    public function getAppraisalData(Request $request)
    {
        // Retrieve query parameters safely
        $employeeId = trim($request->query('employee_id', ''));
        $employeeName = trim($request->query('employee_name', ''));
    
        // Log incoming request data for debugging
        Log::info('Received Appraisal Data Request', [
            'employee_id' => $employeeId,
            'employee_name' => $employeeName
        ]);
    
        // Ensure at least one identifier is provided
        if (empty($employeeId) && empty($employeeName)) {
            return response()->json(['error' => 'Employee ID or Name is required'], 400);
        }
    
        // Fetch Employee Data using LIKE for Partial Matching
        $query = SuperAddUser::query();
    
        if (!empty($employeeId)) {
            $query->whereRaw("LOWER(TRIM(employee_id)) LIKE LOWER(?)", ["%{$employeeId}%"]);
        }
    
        if (!empty($employeeName)) {
            $query->where(function ($q) use ($employeeName) {
                $q->whereRaw("LOWER(TRIM(fname)) LIKE LOWER(?)", ["%{$employeeName}%"])
                  ->orWhereRaw("LOWER(TRIM(lname)) LIKE LOWER(?)", ["%{$employeeName}%"])
                  ->orWhereRaw("LOWER(CONCAT(TRIM(fname), ' ', TRIM(lname))) LIKE LOWER(?)", ["%{$employeeName}%"]);
            });
        }
    
        $superAddUser = $query->first();
    
        // Log query results
       // Log::info('Fetched Employee Data', ['employee' => $superAddUser]);
    
        if (!$superAddUser) {
            return response()->json(['error' => 'No data found'], 404);
        }
    
        // Extract salary and user roles
        $salary = $superAddUser->salary ?? 0;
        $userRoles = json_decode($superAddUser->user_roles, true) ?? [];
    
        // Fetch Company Increment Percentage
        $companyIncrementPercent = 20;
        $incrementAmount = ($salary * $companyIncrementPercent) / 100;
    
        // Initialize Review Data
        $adminReviewData = [];
        $hrReviewData = [];
        $managerReviewData = [];
        $clientReviewData = [];
    
        // Fetch review scores based on available roles
        if (in_array('admin', $userRoles)) {
            $adminReviewData = AdminReviewTable::where('emp_id', $superAddUser->employee_id)
                ->pluck('AdminTotalReview')->toArray();
        }
        if (in_array('hr', $userRoles)) {
            $hrReviewData = HrReviewTable::where('emp_id', $superAddUser->employee_id)
                ->pluck('HrTotalReview')->toArray();
        }
        if (in_array('manager', $userRoles)) {
            $managerReviewData = ManagerReviewTable::where('emp_id', $superAddUser->employee_id)
                ->pluck('ManagerTotalReview')->toArray();
        }
        if (in_array('client', $userRoles)) {
            $clientReviewData = ClientReviewTable::where('emp_id', $superAddUser->employee_id)
                ->pluck('ClientTotalReview')->toArray();
        }
    
        // Normalize Review Scores to Percentage
        $adminReviewData = array_map(fn($score) => min(($score / 45) * 100, 100), $adminReviewData);
        $hrReviewData = array_map(fn($score) => min(($score / 30) * 100, 100), $hrReviewData);
        $managerReviewData = array_map(fn($score) => min(($score / 35) * 100, 100), $managerReviewData);
        $clientReviewData = array_map(fn($score) => min(($score / 100) * 100, 100), $clientReviewData);
    
        // Calculate Final Salary Based on Available Reviews
        $finalSalaries = [];
    
        // Ensure we only count non-empty review sets
        $reviewArrays = array_filter([
            'admin' => $adminReviewData,
            'hr' => $hrReviewData,
            'manager' => $managerReviewData
        ]);
    
        // Only include client review if available
        if (!empty($clientReviewData)) {
            $reviewArrays['client'] = $clientReviewData;
        }
    
        Log::info('Review Scores for Appraisal Calculation', [
            'admin' => $adminReviewData,
            'hr' => $hrReviewData,
            'manager' => $managerReviewData,
            'client' => $clientReviewData
        ]);
    
        // Get the minimum review count from available review types
        $reviewCount = count($reviewArrays) > 0 ? min(array_map('count', $reviewArrays)) : 0;
    
        for ($i = 0; $i < $reviewCount; $i++) {
            $scores = [];
    
            if (isset($adminReviewData[$i])) $scores[] = $adminReviewData[$i];
            if (isset($hrReviewData[$i])) $scores[] = $hrReviewData[$i];
            if (isset($managerReviewData[$i])) $scores[] = $managerReviewData[$i];
    
            // Include client review if available
            if (!empty($clientReviewData) && isset($clientReviewData[$i])) {
                $scores[] = $clientReviewData[$i];
            }
    
            // Avoid dividing by zero if no reviews are available
            $avgScore = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
    
            // Apply appraisal percentage on increment amount
            $appraisalAmount = ($incrementAmount * $avgScore) / 100;
            $finalSalary = round($salary + $appraisalAmount, 2);
    
            $finalSalaries[] = $finalSalary;
        }
    
        // Return Response
        return response()->json([
            'employee_name' => "{$superAddUser->fname} {$superAddUser->lname}",
            'adminReviewData' => $adminReviewData ?: [],
            'hrReviewData' => $hrReviewData ?: [],
            'managerReviewData' => $managerReviewData ?: [],
            'clientReviewData' => $clientReviewData ?: [],
            'salary' => $salary,
            'incrementAmount' => $incrementAmount,
            'finalSalaries' => $finalSalaries,
            'status' => 'success'
        ]);
    }

    


    //Action Column
    public function toggleStatus($id)
    {
        $user = SuperAddUser::where('employee_id', $id)->first();

        if (!$user) {
            Log::error("User not found: ID $id");
            return response()->json(['success' => false, 'error' => 'User not found'], 404);
        }

        // Toggle status
        $user->status = !$user->status;
        $user->save();

        Log::info("User status updated", [
            'user_id' => $id,
            'new_status' => $user->status
        ]);

        return response()->json([
            'success' => true,
            'new_status' => $user->status
        ]);
    }

    // Fetch only active users for the main table
    public function getActiveUsers()
{
    try {
        $users = SuperAddUser::where('status', 1)->get();
        return response()->json($users);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    // Search users by Employee ID or Name (Show active/inactive when searching)
    public function searchEmployee(Request $request)
    {
        try {
            $query = trim($request->input('query'));
            $type = $request->input('type');

            if (!$query) {
                return response()->json(['message' => 'Query is required']);
            }

            $usersQuery = SuperAddUser::query();

            if ($type === "id") {
                $usersQuery->where('employee_id', 'like', "%$query%");
            } elseif ($type === "name") {
                $usersQuery->where(function ($q) use ($query) {
                    $q->where('fname', 'like', "%$query%")
                        ->orWhere('lname', 'like', "%$query%");
                });
            }


            $users = $usersQuery->get(['employee_id', 'fname', 'lname', 'designation', 'salary', 'mobno', 'email', 'status']);

            Log::info("Search Results:", $users->toArray()); // Debugging log

            if ($users->isEmpty()) {
                return response()->json(['message' => 'User not found']);
            }

            return response()->json($users);
        } catch (\Exception $e) {
            Log::error("Search Error: " . $e->getMessage());
            return response()->json(['error' => 'Server error', 'details' => $e->getMessage()], 500);
        }
    }


    //Financial View
    public function financialView()
    {
        return view('admin.financial');
    }

    

    public function getFinancialData(Request $request)
    {
        try {
            $employeeId = trim($request->employee_id);
            $employeeName = trim($request->employee_name);
    
            Log::info("Fetching financial data for:", ['employee_id' => $employeeId, 'employee_name' => $employeeName]);
    
            // Search employee by ID or concatenated name
            $employee = SuperAddUser::when($employeeId, function ($query, $id) {
                return $query->where('employee_id', $id);
            })
                ->when($employeeName, function ($query, $name) {
                    return $query->whereRaw("CONCAT(fname, ' ', lname) LIKE ?", ["%{$name}%"]);
                })
                ->first();
    
            if (!$employee) {
                Log::error("Employee not found with employee_id: $employeeId");
                return response()->json(['status' => 'error', 'message' => 'No employee found.'], 404);
            }
    
            Log::info("Employee Found:", ['employee_id' => $employee->employee_id, 'emp_id' => $employee->emp_id]);
    
            // Ensure we are using the correct employee identifier
            $employeeIdentifier = $employee->emp_id ?? $employee->employee_id;
    
            // Fetch Review Scores from 4 Tables
            $adminReviewScores = AdminReviewTable::where('emp_id', $employeeIdentifier)->pluck('AdminTotalReview')->toArray();
            $hrReviewScores = HrReviewTable::where('emp_id', $employeeIdentifier)->pluck('HrTotalReview')->toArray();
            $managerReviewScores = ManagerReviewTable::where('emp_id', $employeeIdentifier)->pluck('ManagerTotalReview')->toArray();
            $clientReviewScores = ClientReviewTable::where('emp_id', $employeeIdentifier)->pluck('ClientTotalReview')->toArray();
    
            // Convert Scores to Percentage
            $adminReviewData = array_map(fn($score) => min(($score / 45) * 100, 100), $adminReviewScores);
            $hrReviewData = array_map(fn($score) => min(($score / 30) * 100, 100), $hrReviewScores);
            $managerReviewData = array_map(fn($score) => min(($score / 35) * 100, 100), $managerReviewScores);
            $clientReviewData = array_map(fn($score) => min(($score / 100) * 100, 100), $clientReviewScores);
    
            // Calculate Average Review Percentage
            $totalReviewScores = array_merge($adminReviewData, $hrReviewData, $managerReviewData, $clientReviewData);
            $avgReviewPercentage = !empty($totalReviewScores) ? array_sum($totalReviewScores) / count($totalReviewScores) : 0;
    
            // Base Salary
            $baseSalary = (float) $employee->salary;
            $companyPercentage = 5; // Change this as needed
    
            // Step 1: Calculate Increment Amount
            $updatedSalary = ($baseSalary * ($companyPercentage / 100));
    
            // Step 2: Correct Calculation of Appraisal Amount
            $appraisalAmount = $updatedSalary * ($avgReviewPercentage / 100);
    
            // Step 3: Correct Final Salary Calculation (Base Salary + Updated Salary + Appraisal)
            $finalSalary = $baseSalary + $updatedSalary + $appraisalAmount;
    
            // Step 4: Apply Rounding
            $finalSalary = $this->roundSalary($finalSalary);
    
            // Update Final Salary in Database
            $employee->update(['final_salary' => $finalSalary]);
    
            return response()->json([
                'employee_name'   => "{$employee->fname} {$employee->lname}",
                'employee_id' => $employee->id,
                'hrReviewData'    => $hrReviewData,
                'adminReviewData' => $adminReviewData,
                'managerReviewData' => $managerReviewData,
                'clientReviewData' => $clientReviewData,  // Ensure this key is returned
                'salary'          => $baseSalary,
                'updatedSalary'   => $updatedSalary,
                'appraisalAmount' => $appraisalAmount,
                'finalSalary'     => $finalSalary,
                'appraisalDate'   => now()->toDateString()
            ]);
        } catch (\Exception $e) {
            Log::error("Error fetching financial data:", ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }
    





































    // Round salary to nearest 0.05
    private function roundSalary($amount)
    {
        return round($amount * 20) / 20; // Rounds to nearest 0.05
    }
    //show userkist 
    public function userListView()
    {

        Paginator::useBootstrap();
        // $users = SuperAddUser::paginate(10)->appends(request()->query());
        $users = SuperAddUser::get()->all();
        return view('admin.userList', compact('users')); 
    }

    public function viewDetailsAll($emp_id)
    {
        $users = [
            'evaluation' => DB::table('evaluation_tables')->where('emp_id', $emp_id)->first(),
            'managerReview' => DB::table('manager_review_tables')->where('emp_id', $emp_id)->first(),
            'adminReview' => DB::table('admin_review_tables')->where('emp_id', $emp_id)->first(),
            'hrReview' => DB::table('hr_review_tables')->where('emp_id', $emp_id)->first(),
            'clientReview' => DB::table('client_review_tables')->where('emp_id', $emp_id)->first(),
        ];

        // Check if all values in $users are null
        if (!array_filter($users)) {
            return redirect()->back()->with('error', 'No review data found for this employee.');
        }

        return view('review/viewDetails', compact('users', 'emp_id'));
    }
}
