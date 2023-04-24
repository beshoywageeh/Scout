<?php

namespace App\Http\Controllers;

use App\Models\badge;
use App\Models\department;
use Flasher\Noty\Prime\NotyFactory;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = badge::all();

        return view('backend.badges.index', compact('badges'));
    }

    public function create()
    {
        $departments = department::all();

        return view('backend.badges.create', compact('departments'));
    }

    public function store(Request $request, NotyFactory $flasher)
    {
        //return $request;
        $List_badges = $request->List_badges;
        try {
            foreach ($List_badges as $List_badge) {
                if (isset($List_badge['active'])) {
                    $active = 1;
                } else {
                    $active = 0;
                }
                $badges = new badge();
                $badges->name = $List_badge['name'];
                $badges->department_id = $List_badge['department'];
                $badges->active = $active;
                $badges->save();
            }
            $flasher->addSuccess('تم الحفظ بنجاح');

            return redirect()->route('badge.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id, NotyFactory $flasher)
    {
        try {
            badge::destroy($id);
            $flasher->addError('تم الحذف بنجاح');

            return redirect()->route('badge.index');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
