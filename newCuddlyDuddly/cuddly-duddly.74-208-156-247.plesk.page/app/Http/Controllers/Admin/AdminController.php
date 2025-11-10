<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Sellers;

class AdminController extends Controller
{

    public function showAdminLoginForm()
    {
        // redirect if already logged in
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function showSellerLoginForm()
    {
        // redirect if already logged in
        if (Auth::guard('seller')->check()) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.login');
    }


    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email_or_phone' => 'required|string',
    //         'password' => 'required|string',
    //         'user_type' => 'required|string',
    //     ]);

    //     $emailOrPhone = $request->email_or_phone;
    //     $password = $request->password;
    //     $role = $request->user_type;

    //     $admin = AdminUser::where('email', $emailOrPhone)
    //         ->orWhere('phone', $emailOrPhone)
    //         ->first();

    //     if (!$admin) {
    //         return back()
    //             ->withErrors(['email_or_phone' => 'No account found with this email or phone.'])
    //             ->withInput();
    //     }

    //     if (!Hash::check($password, $admin->password)) {
    //         return back()
    //             ->withErrors(['password' => 'Incorrect password.'])
    //             ->withInput();
    //     }

    //     if ($admin->role !== $role) {
    //         return back()
    //             ->withErrors(['user_type' => 'User type does not match your account.'])
    //             ->withInput();
    //     }

    //     if (!$admin->is_active) {
    //         return back()
    //             ->withErrors(['status' => 'Your account is inactive. Please contact the administrator.'])
    //             ->withInput();
    //     }

    //     Auth::guard('admin')->login($admin);
    //     $request->session()->regenerate();

    //     return redirect()->route('admin.dashboard')
    //         ->with('success', 'Welcome back, ' . $admin->name . '!');
    // }

    public function login(Request $request)
    {
        // Prevent mismatch portal access
        if ($request->is('admin/*') && $request->user_type === 'seller') {
            return back()->withErrors(['user_type' => 'You are not allowed to login from the admin portal.']);
        }

        if ($request->is('seller/*') && $request->user_type !== 'seller') {
            return back()->withErrors(['user_type' => 'You are not allowed to login from the seller portal.']);
        }

        $request->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
            'user_type' => 'required|string',
        ]);

        $emailOrPhone = $request->email_or_phone;
        $password = $request->password;
        $userType = $request->user_type;

        /**
         * 🔹 SELLER LOGIN HANDLING
         */
        if ($userType === 'seller') {
            $seller = Sellers::where('email', $emailOrPhone)
                ->orWhere('phone', $emailOrPhone)
                ->first();

            if (!$seller) {
                return back()->withErrors(['email_or_phone' => 'No seller account found.'])->withInput();
            }

            if (!Hash::check($password, $seller->password)) {
                return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
            }

            if (!$seller->is_active || $seller->compliance_status !== 'verified') {
                return back()->withErrors(['status' => 'Your seller account is not active or not verified.'])->withInput();
            }

            Auth::guard('seller')->login($seller);
            $request->session()->regenerate();

            return redirect()->route('seller.dashboard')->with('success', 'Welcome Seller ' . $seller->name . '!');
        }

        /**
         * 🔹 ADMIN LOGIN HANDLING (AdminUser + Roles)
         */
        $user = AdminUser::where('email', $emailOrPhone)
            ->orWhere('phone', $emailOrPhone)
            ->first();

        if (!$user) {
            return back()->withErrors(['email_or_phone' => 'No admin user found.'])->withInput();
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
        }

        if (!$user->isActive()) {
            return back()->withErrors(['status' => 'Your admin account is inactive.'])->withInput();
        }

        // Ensure the user has a role assigned
        if (!$user->role_id || !$user->role) {
            return back()->withErrors(['status' => 'No role assigned to your account. Please contact Super Admin.'])->withInput();
        }

        // 🧩 Match user-selected type with the assigned role slug
        if (!in_array($user->role->slug, [$userType, 'admin', 'super-admin'])) {
            return back()->withErrors(['user_type' => 'You don’t have access to this role.'])->withInput();
        }


        Auth::guard('admin')->login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
    }


    // public function logout(Request $request)
    // {
    //     Auth::guard('admin')->logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('admin.login');
    // }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $redirect = 'admin.login';
        } elseif (Auth::guard('seller')->check()) {
            Auth::guard('seller')->logout();
            $redirect = 'seller.login';
        } else {
            $redirect = 'login';
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($redirect)->with('success', 'Logged out successfully.');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admin_users,email',
            'password' => 'required|string|min:6',
            'phone'    => 'nullable|string|max:20',
            'role_id'  => 'nullable|exists:roles,id',
        ]);

        AdminUser::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?? null,
            'password'  => Hash::make($validated['password']),
            'role_id'   => $validated['role_id'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Admin user created successfully.');
    }

    public function update(Request $request, AdminUser $user)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:admin_users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'role_id'  => $validated['role_id'] ?? null,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Admin user updated successfully.');
    }

    public function destroy(AdminUser $user)
    {
        $user->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Admin user deleted.');
    }
}
