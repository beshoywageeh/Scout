<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageTrait;
use App\Models\attendance;
use App\Models\department;
use App\Models\Image;
use App\Models\User;
use Exception;
use Flasher\Noty\Prime\NotyFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض القطاعات|اضافة قطاع|تعديل قطاع|حذف قطاع|تفاصيل قطاع', ['only' => ['index', 'store', 'details']]);
        $this->middleware('permission:اضافة قطاع', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل قطاع', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف فطاع', ['only' => ['destroy']]);
        $this->middleware('permission:تفاصيل فطاع', ['only' => ['details']]);
    }

    public function index()
    {
        $data = [''];
        $data['departments'] = department::withCount('users')->get();

        return view('backend.departments.index', ['data' => $data]);
    }

    public function store(Request $request, NotyFactory $flasher)
    {
        DB::beginTransaction();
        try {
            $department = new department();
            $department->name = $request->name;
            $department->save();
            if ($request->hasfile('logo')) {
                $this->uploadImage('attachments/departments', $request->logo, $request->name);
                $image = new Image();
                $image->filename = $this->uploadImage('attachments/departments', $request->logo, $request->name);
                $image->imageable_id = $department->id;
                $image->imageable_type = 'App\Models\department';
                $image->save();
            }
            DB::commit();
            $flasher->addSuccess('تم الحفظ بنجاح');

            return redirect()->route('department.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete(Request $request, NotyFactory $flasher)
    {
        try {
            $id = $request->id;
            $this->deleteImage('upload_attachments', 'attachments/departments/'.$request->filename);
            department::destroy($id);
            Image::where('imageable_id', $id)->where('filename', $request->filename)->delete();
            $flasher->addError('تم الحذف بنجاح');

            return redirect()->route('department.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function profile($id)
    {
        $data = [''];
        $data['department'] = department::where('id', $id)->first();
        $date = attendance::max('attendance_date');
        $data['attendance'] = attendance::with('users')->where('department_id', $id)->where('attendance_date', $date)->get();
        $users = User::onlyTrashed()->where('department_id', $id)->where('black_list', '!=', '1')->get();

        return view('backend.departments.profile', ['data' => $data], compact('users'));
    }

    public function edit(Request $request, NotyFactory $flasher)
    {
        DB::beginTransaction();
        try {
            $department = department::findorfail($request->id);
            //  return $request;

            $department->update([
                'name' => $request->name,
            ]);
            if ($request->hasFile('logo')) {
                $this->uploadImage('attachments/departments', $request->logo, $request->name);
                $image = new Image();
                $image->filename = $this->uploadImage('attachments/departments', $request->logo, $request->name);
                $image->imageable_id = $department->id;
                $image->imageable_type = 'App\Models\department';
                $image->save();
            }
            DB::commit();
            $flasher->addSuccess('تم التعديل');

            return redirect()->route('department.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
