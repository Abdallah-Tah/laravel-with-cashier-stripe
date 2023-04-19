<?php

namespace App\Http\Livewire\User;

use App\Models\Company;
use Livewire\Component;

class UserComponent extends Component
{
    public $users;
    public $company;

    public function mount()
    {
        $this->users = Company::getAuthenticatedUserCompany();
        dd($this->users);
    }

    public function render()
    {
        return view('livewire.user.user-component')->layout('layouts.master');
    }
}
