<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\SuperAddUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class addUserController extends Controller

{
    //

    public function indexAddUser()
    {
        return view("admin/superAddUserDashBoard");
    }


    public function addUser(Request $request)
    {
        try {
            // Validate request
            // $validatedData = $request->validate([
            //     'salary' => 'required|numeric',
            //     'email' => [
            //         'required',
            //         'email',
            //         'unique:super_add_users,email',
            //         function ($attribute, $value, $fail) {
            //             // Ensure email follows "fname.lname@delostylestudio.com"
            //             if (!preg_match('/^[a-zA-Z]+\.[a-zA-Z]+@delostylestudio\.com$/', trim($value))) {
            //                 $fail('Email must be in the format @delostylestudio.com.');
            //             }
            //         }
            //     ],
            //     'password' => 'required|string|min:4'
            // ], [
            //     'email.unique' => 'This email is already registered.',
            // ]);

            // Insert user data
            SuperAddUser::create([
                'fname' => $request->input('fname'),
                'lname' => $request->input('lname'),
                'dob' => $request->input('dob'),
                'gender' => $request->input('gender'),
                'mobno' => $request->input('mobno'),
                'employee_id' => $request->input('employee_id'),
                'designation' => $request->input('designation'),
                'user_type' => $request->input('user_type'),
                'user_roles' => json_encode($request->input('user_roles')),
                'salary' => $request->input('salary'),
                'email' => trim($request->input('email')), // Trim spaces
                'password' => Hash::make($request->input('password')),
                'status' => 1
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User saved successfully!',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(), // Returns validation errors
            ], 422);
        }
    }

   
}
