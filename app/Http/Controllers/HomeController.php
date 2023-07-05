<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\department;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [''];
        $data['department'] = department::withcount('users')->get();
        $data['latest_date'] = attendance::latest('attendance_date')->pluck('attendance_date')->first();
        $data['users'] = User::latest()->take(10)->get();
        $data['attendance'] = attendance::latest()->take(10)->get();
        $data['dates'] = attendance::latest('attendance_date')
            ->pluck('attendance_date')
        ->unique();
      //  return $data['dates'];
        return view('dashboard', ['data' => $data]);
    }
}
