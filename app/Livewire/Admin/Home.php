<?php

namespace App\Livewire\Admin;

use App\Models\StaffSection;
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
    public $staff_sections;

    public function render()
    {
        $this->staff_sections = StaffSection::query()->select('id', 'name')->get();
        return view('livewire.admin.home');
    }
}
