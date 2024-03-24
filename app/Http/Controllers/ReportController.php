<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\department;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function black_list_report(Request $request)
    {
        try {
            $data = User::onlyTrashed()->where('black_list', 1)->get();

            return view('backend.reports.black_list', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function report_view()
    {
        $departments = department::all();

        return view('backend.reports.attendance', compact('departments'));
    }

    public function report_view_data(Request $request)
    {
        $request->validate([
            'department' => 'required',
        ], [
            'department.required' => 'من فضلك اختار القطاع',
        ]);
        if ($request->from && $request->to) {
            $request->validate([
                'from' => 'required|date|date_format:Y-m-d',
                'to' => 'required|date|date_format:Y-m-d|after_or_equal:from',
            ], [
                'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
                'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
                'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            ]);
            $data['attendance'] = attendance::with('users')->where('department_id', $request->department)->whereBetween('attendance_date', [$request->from, $request->to])->orderby('attendance_date', 'asc')->get()->groupBy('user_id');
            $data['dates'] = attendance::select('attendance_date')->whereBetween('attendance_date', [$request->from, $request->to])->distinct()->get();
            $data['came'] = attendance::where('department_id', $request->department)->whereBetween('attendance_date', [$request->from, $request->to])->where('status', '1')->count();
            $data['absent'] = attendance::where('department_id', $request->department)->whereBetween('attendance_date', [$request->from, $request->to])->where('status', '2')->count();
            $data['else'] = attendance::where('department_id', $request->department)->whereBetween('attendance_date', [$request->from, $request->to])->where('status', '3')->count();
        } else {
            $data['came'] = attendance::where('department_id', $request->department)->where('status', '1')->count();
            $data['absent'] = attendance::where('department_id', $request->department)->where('status', '2')->count();
            $data['else'] = attendance::where('department_id', $request->department)->where('status', '3')->count();
            $data['attendance'] = attendance::with('users')->where('department_id', $request->department)->orderby('attendance_date', 'asc')->get()->groupBy('user_id');
            $data['dates'] = attendance::select('attendance_date')->distinct()->get();
        }
        $departments = department::all();
        $dep = $request->department;
        $data['from'] = $request->from;
        $data['to'] = $request->to;
        //return $data['attendance'];
        return view('backend.reports.attendance', ['data' => $data], compact('departments', 'dep'));
    }

    public function report_view_absent()
    {
        $departments = department::all();

        return view('backend.reports.absent_report', compact('departments'));
    }

    public function report_view_absent_data(Request $request)
    {
        $request->validate([
            'department' => 'required',
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from',
        ], [
            'department.required' => 'من فضلك اختار القطاع',
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',

        ]);
        $data = [''];
        $data['attendance'] = attendance::where('department_id', $request->department)->where('status', '>=', '2')->whereBetween('attendance_date', [$request->from, $request->to])->with(['users'])->get();
        $data['absent'] = attendance::where('department_id', $request->department)->where('status', '2')->whereBetween('attendance_date', [$request->from, $request->to])->count();
        $data['e3tezar'] = attendance::where('department_id', $request->department)->where('status', '3')->whereBetween('attendance_date', [$request->from, $request->to])->count();
        $data['department'] = department::where('id', $request->department)->first();
        $departments = department::all();
        $data['from'] = $request->from;
        $data['to'] = $request->to;
        //return $data;
        return view('backend.reports.absent_report', compact('departments'), ['data' => $data]);
    }

    public function total()
    {
        $data['departments'] = department::all();

        return view('backend.reports.totals', ['data' => $data]);
    }

    public function total_report_data(Request $request)
    {
        // return $request;
        try {
            $data['from'] = $request->from;
            $data['to'] = $request->to;
            $data['department'] = department::with('image')->where('id', $request->department)->first();
            $data['user'] = user::where('department_id', $request->department)->get();
            $data['departments'] = department::all();
            if (is_null($data['department']->image)) {
                $image = asset('images/login-banner.jpg');
            } else {
                $image = asset('storage/attachments/departments/'.$data['department']->image->filename);
            }

            return view('backend.reports.totals', ['data' => $data]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
