<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\department;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Database\Query\Builder;
use PDF;
use Symfony\Component\HttpFoundation\Request;
use Intervention\Image\Facades\Image;

class PdfController extends Controller
{
    public function absent_pdf($id, $date_from, $date_to)
    {
        $data = [''];
        $data['attendance'] = attendance::where('department_id', $id)->where('status', '>=', '2')->whereBetween('attendance_date', [$date_from, $date_to])->with(['users'])->get();
        $data['absent'] = attendance::where('department_id', $id)->where('status', '2')->whereBetween('attendance_date', [$date_from, $date_to])->count();
        $data['e3tezar'] = attendance::where('department_id', $id)->where('status', '3')->whereBetween('attendance_date', [$date_from, $date_to])->count();
        $data['department'] = department::where('id', $id)->first();
        $data['department'] = department::with('users', 'image')->where('id', $id)->first();
        // return $data;
        if (is_null($data['department']->image)) {
            $image = asset('images/login-banner.jpg');
        } else {
            $image = asset('storage/attachments/departments/' . $data['department']->image->filename);
        }
        $pdf = PDF::loadView('pdf.absent', ['data' => $data], [], [
            'format' => 'A4',
            'margin_left' => 4,
            'margin_right' => 4,
            'margin_top' => 4,
            'margin_bottom' => 4,
            'margin_header' => 0,
            'margin_footer' => 0,
            'orientation' => 'L',
            'watermark' => $data['department']->name,
            'show_watermark' => true,
            'show_watermark_image' => true,
            'watermark_font' => 'sans-serif',
            'display_mode' => 'fullpage',
            'watermark_text_alpha' => 0.2,
            'watermark_image_path' => $image,
            'watermark_image_alpha' => 0.2,
            'watermark_image_size' => 'D',
            'watermark_image_position' => 'P',
        ]);
        return $pdf->download($data['department']->name . ' - افتقاد.pdf');
    }

    public function department_data_pdf($id)
    {
        $data = [''];
        $data['department'] = department::with('users', 'image')->where('id', $id)->first();
        $pdf = PDF::loadView('pdf.data', ['data' => $data], [], [
            'format' => 'A4',
            'margin_left' => 4,
            'margin_right' => 4,
            'margin_top' => 4,
            'margin_bottom' => 4,
            'margin_header' => 0,
            'margin_footer' => 0,
            'orientation' => 'L',
            'watermark' => is_null($data['department']->image) ? $data['department']->name : '',
            'show_watermark' => true,
            'show_watermark_image' => true,
            'watermark_font' => 'sans-serif',
            'display_mode' => 'fullpage',
            'watermark_text_alpha' => 0.2,
            'watermark_image_path' => is_null($data['department']->image) ? '' : asset('storage/attachments/departments/' . $data['department']->image->filename),
            'watermark_image_alpha' => 0.2,
            'watermark_image_size' => 'D',
            'watermark_image_position' => 'P',
        ]);

        return $pdf->stream($data['department']->name . '.pdf');
    }

    public function blacklist_pdf()
    {
        $data = [''];
        $data['user'] = User::onlyTrashed()->where('black_list', 1)->get();
        $pdf = PDF::loadView('pdf.blacklist', ['data' => $data], [], [
            'format' => 'A4',
            'margin_left' => 4,
            'margin_right' => 4,
            'margin_top' => 4,
            'margin_bottom' => 4,
            'margin_header' => 0,
            'margin_footer' => 0,
            'orientation' => 'L',
            'watermark_image_path' => asset('images/login-banner.jpg'),
            'show_watermark' => true,
            'show_watermark_image' => true,
            'watermark_font' => 'sans-serif',
            'display_mode' => 'fullpage',
            'watermark_text_alpha' => 0.2,
            'watermark_image_alpha' => 0.2,
            'watermark_image_size' => 'D',
            'watermark_image_position' => 'P',
        ]);
        return $pdf->stream('القائمة السوداء.pdf');
    }

    public function export_personal_info($code)
    {
        $data = [''];
        $data['user'] = User::withTrashed()->where('code', $code)->first();
        $data['attendance'] = attendance::withTrashed()->where('user_id', $code)->where('status', '1')->count();
        $doc_name = $data['user']->first_name . ' ' . $data['user']->second_name;
        $pdf = PDF::loadview('pdf.data_card', ['data' => $data], [], [
            'format' => 'custom',
            'orientation' => 'L',
            'margin_left' => 1,
            'margin_right' => 1,
            'margin_top' => 1,
            'margin_bottom' => 1,
            'margin_header' => 0,
            'margin_footer' => 0,
            'watermark_image_path' => asset('images/login-banner.jpg'),
            'show_watermark' => true,
            'show_watermark_image' => true,
            'watermark_font' => 'sans-serif',
            'display_mode' => 'fullpage',
            'watermark_text_alpha' => 0.2,
            'watermark_image_alpha' => 0.2,
            'watermark_image_size' => 'D',
            'watermark_image_position' => 'P',
        ]);
        return $pdf->stream($doc_name . '.pdf');

    }

    public function attendance_pdf($id, $date_from = null, $date_to = null)
    {
        try {
            $data['from'] = $date_from;
            $data['to'] = $date_to;
            $data['department'] = department::with('image')->where('id', $id)->first();
            if (is_null($data['department']->image)) {
                $image = asset('images/login-banner.jpg');
            } else {
                $image = asset('storage/attachments/departments/' . $data['department']->image->filename);
            }


            if (!is_null($date_from) && !is_null($date_from)) {
                $data['absent'] = attendance::where('department_id', $data['department']->id)->whereBetween('attendance_date', [$date_from, $date_to])
                    ->where('status', 2)
                    ->count();
                $data['came'] = attendance::where('department_id', $data['department']->id)
                ->whereBetween('attendance_date', [$date_from, $date_to])
                    ->where('status', 1)
                    ->count();
                $data['e3tezar'] = attendance::where('department_id', $data['department']->id)->whereBetween('attendance_date', [$date_from, $date_to])
                    ->where('status', 3)
                    ->count();
                $data['attendance'] = attendance::with('users')
                    ->where('department_id', $data['department']->id)
                    ->whereBetween('attendance_date', [$date_from, $date_to])
                    ->distinct()->get();
                $data['dates'] = attendance::select('attendance_date')
                ->whereBetween('attendance_date', [$date_from, $date_to])
                    ->distinct()
                    ->get();
            } else {
                $data['came'] = attendance::where('department_id', $data['department']->id)
                    ->where('status', '1')
                    ->count();
                $data['absent'] = attendance::where('department_id', $data['department']->id)
                    ->where('status', '2')
                    ->count();
                $data['e3tezar'] = attendance::where('department_id', $data['department']->id)
                    ->where('status', '3')
                    ->count();
                $data['attendance'] = User::with(['attendance as came'
                => function (Builder $query) {
                    $query->where('status', '1')->count();
                }])
                    ->where('department_id', $data['department']->id)
                    ->orderby('attendance_date', 'asc')
                    ->get();
                $data['dates'] = attendance::select('attendance_date')
                    ->distinct()
                    ->get();
            }
            $pdf = PDF::loadView('pdf.attendance', ['data' => $data], [], [
                'format' => 'A4',
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'watermark' => $data['department']->name,
                'show_watermark' => true,
                'show_watermark_image' => true,
                'watermark_font' => 'sans-serif',
                'display_mode' => 'fullpage',
                'watermark_text_alpha' => 0.2,
                'watermark_image_path' => $image,
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
            ]);
            return $pdf->stream($data['department']->name . ' - حضور.pdf');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function export_all(){
        $data['dates'] = attendance::latest('attendance_date')
            ->pluck('attendance_date')
            ->unique();
        $data['department']=department::get(['id','name']);
      // return $data['dates'];
        $pdf = PDF::loadview('pdf.export_all', ['data' => $data], [], [
            'format' => 'A4',
            'orientation' => 'L',
            'margin_left' => 1,
            'margin_right' => 1,
            'margin_top' => 1,
            'margin_bottom' => 1,
            'margin_header' => 0,
            'margin_footer' => 0,
            'show_watermark' => true,
            'show_watermark_image' => true,
            'watermark_font' => 'sans-serif',
            'display_mode' => 'fullpage',
            'watermark_text_alpha' => 0.2,
            'watermark_image_alpha' => 0.2,
            'watermark_image_size' => 'D',
            'watermark_image_position' => 'P',
        ]);
        return $pdf->stream('الاجمالي.pdf');
    }

}
