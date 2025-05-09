<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    /**
     * Display a listing of user activities.
     */
    public function index()
    {
        $this->middleware('admin');
        
        $activities = \App\Models\UserActivity::with('user')
            ->latest()
            ->paginate(20);
            
        return view('user-activities.index', compact('activities'));
    }
}
