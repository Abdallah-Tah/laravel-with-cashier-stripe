<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;

class SubUserManagement extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $subUserId;
    public string $sortColumn = 'created_at';

    public string $sortDirection = 'asc';

    public $showModal = false;

    public function sortByColumn($column): void
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function showModal()
    {
        $this->showModal = true;
    }

    public function createSubUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $parentUser = auth()->user();
        $company = $parentUser->company;

        $subUser = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'company_id' => $company->id,
        ]);

        // Add any additional logic for the subuser, such as attaching roles or permissions

        session()->flash('message', 'Subuser created successfully.');
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function render()
    {
        $users = auth()->user()->company->users()->orderBy($this->sortColumn, $this->sortDirection)->get();

        return view('livewire.user.sub-user-management', ['users' => $users]);
    }
}
