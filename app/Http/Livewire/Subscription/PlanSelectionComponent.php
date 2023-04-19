<?php

namespace App\Http\Livewire\Subscription;

use App\Models\Plan;
use Livewire\Component;

class PlanSelectionComponent extends Component
{
    public $plans;

    public function mount()
    {
        $this->plans = Plan::all();
    }

    public function render()
    {
        return view('livewire.subscription.plan-selection-component');
    }
}
