<?php

namespace App\Livewire;

use Livewire\Component;

class ModeOfProcurementSelect extends Component
{
    public $mode_of_procurement = '';
    public $custom_mode = '';

    public function updatedModeOfProcurement($value)
    {
        if ($value !== 'others') {
            $this->custom_mode = '';
        }
    }
    
    public function render()
    {
        return view('livewire.mode-of-procurement-select');
    }
}
