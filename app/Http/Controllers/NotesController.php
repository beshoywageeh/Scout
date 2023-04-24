<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Flasher\Noty\Prime\NotyFactory;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function create(Request $request, NotyFactory $flasher)
    {
        try {
            $note = new Notes();
            $note->user_code = $request->user_code;
            $note->note = $request->notes;
            $note->save();
            $flasher->addSuccess('تم الحفظ بنجاح');

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
