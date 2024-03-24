<?php

namespace App\Http\Livewire;

use App\Models\payment as pay;
use Flasher\Noty\Prime\NotyFactory;
use Livewire\Component;

class payment extends Component
{
    public $note;

    public $type;

    public $amount;

    public $date;

    public function savepayment(NotyFactory $flasher)
    {
        if ($this->type == '1') {
            $in = $this->amount;
            $out = 0.00;
        } else {
            $out = $this->amount;
            $in = 0.00;
        }

        pay::create([
            'note' => $this->note,
            'at' => $this->date,
            'in' => $in,
            'out' => $out,
        ]);
        $flasher->addSuccess('تم الحفظ بنجاح');
    }

    public function render()
    {
        $data['payments'] = pay::all();

        return view('livewire.Payment', ['data' => $data]);
    }
}
