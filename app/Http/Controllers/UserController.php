<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Traits\ImageTrait;
use App\Imports\UsersImport;
use App\Models\attendance;
use App\Models\badge;
use App\Models\department;
use App\Models\Image;
use App\Models\User;
use App\Models\user_badges;
use Flasher\Noty\Prime\NotyFactory;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ImageTrait;

    public function index(Request $request)
    {
        $data = User::withTrashed()->with(['department'])->orderby('code', 'asc')->get();

        return view('backend.users.index', compact('data'));
    }

    public function create()
    {
        $roles = Role::all();
        $departments = department::all();
        $badges = badge::where('active', '1')->get();

        return view('backend.users.create', compact('roles', 'departments', 'badges'));
    }

    public function store(UserCreateRequest $request, NotyFactory $flasher)
    {

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $latest_code = User::withTrashed()->Latest()->first()->code;
            $user = new User();
            $user->first_name = $request->first_name;
            $user->second_name = $request->second_name;
            $user->third_name = $request->third_name;
            $user->fourth_name = $request->foruth_name;
            $user->phone_number = $request->phone_number;
            $user->address = $request->adress;
            $user->birth_date = $request->birth_date;
            $user->join_date = $request->join_date;
            $user->home_number = $request->home_number;
            $user->email = $request->email;
            $user->church_father = $request->chruch_father;
            $user->department_id = $request->department_id;
            $user->code = $latest_code + 1;
            if ($request->has('password') && !empty($request->has('password'))) {
                $user->password = Hash::make($request->password);
            }
            if ($request->active) {
                $status = 1;
            } else {
                $status = 0;
            }
            $user->login_allow = $status;
            $user->save();
            if ($request->hasfile('logo')) {
                $this->uploadImage('attachments/users/'.$request->first_name.' '.$request->second_name, $request->logo, $request->first_name);
                $image = new Image();
                $image->filename = $this->uploadImage('attachments/users/'.$request->first_name.' '.$request->second_name, $request->logo, $request->first_name);
                $image->imageable_id = $user->id;
                $image->imageable_type = 'App\Models\User';
                $image->save();
            }
            $user->assignRole($request->input('roles'));
            $id = User::latest()->first();
            $badges = new user_badges();
            $badges->user_id = $id->id;
            $user->badges()->attach($request->badges);
            $badges->save();
            DB::commit();
            $flasher->addSuccess('تم الحفظ بنجاح');

            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user = User::findorfail($id);

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $data = [''];
        $data['user'] = User::with('image', 'badges')->findorfail($id);
        $data['department'] = department::all();
        $data['roles'] = Role::all();
        //$data['userrole'] = $data['user']->roles->pluck('name', 'name')->get();
        //return $data;
        // return Hash::make(01201026745);

        return view('backend.users.update', ['data' => $data]);
    }

    public function update(Request $request, NotyFactory $flasher)
    {
        DB::beginTransaction();
        $id = $request->id;
        // return $id;
        $user = User::findorfail($id);
        try {
            if ($request->hasFile('logo')) {
                $this->deleteImage('upload_attachments', 'attachments/users/'.$request->first_name.' '.$request->second_name);
                $this->uploadImage('attachments/users/'.$request->first_name.' '.$request->second_name, $request->logo, $request->first_name);
                $image = new Image();

                $image->filename = $this->uploadImage('attachments/users/'.$request->first_name.' '.$request->second_name, $request->logo, $request->first_name);
                $image->imageable_id = $user->id;
                $image->imageable_type = 'App\Models\user';
                $image->save();
            }
            if ($request->active) {
                $status = 1;
            } else {
                $status = 0;
            }
            $user->badges()->attach($request->badges);

            //return $input;
            $user->update([
                'first_name' => $request->first_name,
                'second_name' => $request->second_name,
                'third_name' => $request->third_name,
                'fourth_name' => $request->foruth_name,
                'email' => $request->email,
                'password' => ($request->has('password') ? Hash::make($request->password) : $user->password),
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'home_number' => $request->home_phone,
                'church_father' => $request->church_father,
                'join_date' => $request->join_date,
                'birth_date' => $request->birth_date,
                'department_id' => $request->department_id,
                'login_allow' => $status,
            ]);

            $user->assignRole($request->input('roles'));
            DB::commit();
            $flasher->addSuccess('تم التعديل بنجاح');

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, NotyFactory $flasher)
    {
        $id = $request->id;
        //return $id;
        DB::beginTransaction();
        try {
            User::where('code', $id)->delete();
            attendance::where('user_id', $id)->delete();
            user_badges::where('user_id', $id)->delete();
            DB::commit();
            $flasher->addSuccess('تم الارشفة بنجاح');

            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function force_delete(Request $request, NotyFactory $flasher)
    {
        $id = $request->code;
        //return $id;
        DB::beginTransaction();
        try {
            attendance::where('user_id', $id)->forcedelete();
            user_badges::where('user_id', $id)->forcedelete();
            User::where('code', $id)->forcedelete();
            DB::commit();
            $flasher->addSuccess('تم الحذف بنجاح');

            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function upload_data(Request $request)
    {
        $path = $request->file('data')->getRealPath();
        Excel::import(new UsersImport, $path);

        return redirect()->route('user.index');
    }

    public function getbadges_ajax($id)
    {
        if (\request()->ajax()) {
            $badges = badge::where('department_id', $id)->where('active', '1')->pluck('name', 'id');

            return $badges;
        }
    }

    public function profile($id)
    {
        $data = [''];
        $data['user'] = User::where('code', $id)->withTrashed()->with(['attendance', 'badges', 'image', 'notes'])->withcount('badges')->first();
        $data['attendance'] = attendance::where('user_id', $id)->get();
        //return $data;
        return view('backend.users.profile', ['data' => $data]);
    }

    public function birth_day(Request $request)
    {
        if ($request->month && $request->department) {
            $month = $request->month;
            $department = $request->department;
            $data['users'] = DB::select(
                DB::raw("Select * from `users` where Month(birth_date)=$month and department_id = $department"),
            );

            return view('backend.reports.birthday', ['data' => $data]);
        } else {
            return view('backend.reports.birthday');
        }
    }

    public function restore(Request $request, NotyFactory $flasher)
    {
        $id = $request->id;
        attendance::where('user_id', $id)->restore();
        user_badges::where('user_id', $id)->restore();
        User::where('code', $id)->restore();
        $flasher->addSuccess('تم الارجاع بنجاح');

        return redirect()->route('user.index');
    }

    public function black_list(Request $request, $id, NotyFactory $flasher)
    {
        DB::beginTransaction();
        try {
            $code = $request->id;
            $user = User::where('code', $code)->first();
            $user->update([
                'black_list' => '1',
            ]);

            User::where('code', $code)->delete();
            attendance::where('user_id', $code)->delete();
            user_badges::where('user_id', $code)->delete();
            DB::commit();
            $flasher->addInfo('تم الاضافة للقائمة السوداء بنجاح');

            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function black_list_restore($id, NotyFactory $flasher)
    {
        DB::beginTransaction();
        try {
            User::where('code', $id)->restore();
            attendance::where('user_id', $id)->restore();
            user_badges::where('user_id', $id)->restore();
            $user = User::where('code', $id)->first();
            $user->update([
                'black_list' => '0',
            ]);
            DB::commit();
            $flasher->addInfo('تم الازالة من للقائمة السوداء بنجاح');

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
