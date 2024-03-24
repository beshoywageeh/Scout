<?php

namespace App\Http\Controllers;

use App\Models\payment;
use Flasher\Noty\Prime\NotyFactory;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['payments'] = payment::orderby('at', 'desc')->get();
        $data['in'] = payment::sum('in');
        $data['out'] = payment::sum('out');
        $data['payments_total'] = $data['in'] - $data['out'];

        return view('backend.payment.index', ['data' => $data]);
    }

    public function store(Request $request, NotyFactory $flasher)
    {
        try {
            $payment = new payment();
            if ($request->type == '1') {
                $payment->note = $request->note;
                $payment->at = $request->date;
                $payment->in = $request->amount;
                $payment->out = 0.00;
            } else {
                $payment->note = $request->note;
                $payment->at = $request->date;
                $payment->in = 0.00;
                $payment->out = $request->amount;
            }
            $payment->save();
            $flasher->addSuccess('تم الحفظ بنجاح');

            return redirect()->route('payment.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, payment $payment)
    {
        //
    }

    public function destroy(payment $payment)
    {
        //
    }
}
