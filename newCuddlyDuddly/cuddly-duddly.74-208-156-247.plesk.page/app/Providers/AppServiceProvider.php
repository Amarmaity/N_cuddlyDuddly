<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::if('canAccess', function ($permission) {
            // $user = Auth::guard('admin')->user() ?? Auth::guard('seller')->user();
            $user = Auth::guard('admin')->user();
            if (!$user) return false;

            if (method_exists($user, 'hasPermission') && $user->hasPermission($permission)) {
                return true;
            }

            return false;
        });
    }
}
