<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RoundingCalculator extends Component
{
    public $amount;

    public function mount() {
        // Amount.
        if (old('amount')) {
            $this->amount = old('amount');
        }
    }

    public function render()
    {
        // Check if the amount value is either null or not a numeric value.
        if ($this->amount == null || !is_numeric($this->amount)) {
            // The entered value is either null or not a numeric value.
            // Set the data variable to an empty array.
            $data = [];
        } else {
            // Make the data variable.
            $data = [
                'net' => '$' . number_format(($this->amount / 11) * 10, 2, '.', ','),
                'gst' => '$' . number_format(($this->amount / 11), 2, '.', ','),
                'gross' => '$' . number_format(($this->amount), 2, '.', ',')
            ];
        }
        // Return the view.
        return view('livewire.rounding-calculator', [
            'data' => $data
        ]);
    }
}
