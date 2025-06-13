<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // This corresponds to resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }

    public function products()
    {
        return view('admin.products');
    }

    public function notifications()
    {
        return view('admin.notifications');
    }

    public function analytics()
    {
        return view('admin.analytics');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}