<?php

namespace App\Livewire\Admin;

use App\Models\StaffSection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Home extends Component
{
    /*
    staff_section
    staff_section_evaluator_1
    staff_section_evaluator_2
    staff_unit
    staff
    activiies
    */
    public $model_context = 'staff_section';
    public $model_id = -1;
    public $is_creating = false;

    #[Computed]
    public function staff_sections() {
        return StaffSection::query()->select('id', 'name')->get();
    }

    public function render()
    {
        return view('livewire.admin.home');
    }
}
