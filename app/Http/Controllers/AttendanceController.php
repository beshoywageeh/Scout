<?php

namespace App\Http\Controllers;

use App\Imports\attendanceImport;
use App\Models\attendance;
use App\Models\department;
use App\Models\User;
use Flasher\Noty\Prime\NotyFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index()
    {
        $departments = department::all();

        return view('backend.attendance.index', compact('departments'));
    }

    public function create($id)
    {
        $users = User::with('attendance')->where('department_id', $id)->get();
        $department = department::findorfail($id);

        return view('backend.attendance.create', compact('users', 'department'));
    }

    public function store(Request $request, NotyFactory $flasher)
    {
        //dd($request->all());
        try {
            $attendace_date = $request->att_date;
            $department_id = $request->department_id;

            foreach ($request->attendance as $studentid => $attendance) {
                if ($attendance == 'attendance') {
                    $attendance_status = '1';
                } elseif ($attendance == 'absent') {
                    $attendance_status = '2';
                } else {
                    $attendance_status = '3';
                }
                attendance::updateorCreate(['user_id' => $studentid, 'attendance_date' => $attendace_date], [
                    'user_id' => $studentid,
                    'department_id' => $department_id,
                    'admin_id' => Auth::id(),
                    'attendance_date' => $attendace_date,
                    'status' => $attendance_status,
                ]);
            }
            $flasher->addSuccess('تم الحفظ بنجاح');

            return redirect()->route('attendance.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function upload_data(Request $request, NotyFactory $flasher)
    {
        $path = $request->file('data')->getRealPath();
        Excel::queueImport(new AttendanceImport, $path);
        $flasher->addSuccess('تم الحفظ بنجاح');

        return redirect()->back();
    }
}
