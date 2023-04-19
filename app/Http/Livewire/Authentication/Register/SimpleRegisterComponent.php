<?php

namespace App\Http\Livewire\Authentication\Register;

use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SimpleRegisterComponent extends Component
{

    public $firstName, $lastName;
    public $email;
    public $password;
    public $password_confirmation;
    public $rememberMe = false;
    public $companyName;
    public $address;
    public $phone;
    public $companyEmail;
    public $logo;
    public $companyPhone;


    protected $rules = [
        'firstName' => ['required', 'string', 'max:255'],
        'lastName' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'min:4', 'confirmed'],
        'password_confirmation' => ['required'],
        'companyName' => ['required', 'string', 'max:255'],
        'companyEmail' => ['required', 'email', 'unique:companies,company_email'],
        'companyPhone' => ['required', 'string', 'max:255'],
    ];


    protected $messages = [
        'email.unique' => 'The email already exists in our record',
    ];

    public function updated($propertyName)
    {

        $this->validateOnly($propertyName);
    }




    public function mount()
    {

        // if (!app()->environment('production')) {
        //     $this->fullName = '';
        //     $this->email = '';
        //     $this->password = '';
        //     $this->password_confirmation = '';
        // }
    }


    public function register()
    {

        $this->validate();

        $user = User::create([
            "name" => $this->firstName . ' ' . $this->lastName,
            "email" => $this->email,
            "password" => Hash::make($this->password),
        ]);
        Auth::login($user, $this->rememberMe);
        
        if ($user) {
            $company = new Company();
            $company->company_name = $this->companyName;
            $company->company_email = $this->companyEmail;
            $company->company_phone = $this->companyPhone;
            $company->user_id = $user->id;
            $company->save();
        }

        if($company){
            $user->company_id = $company->id;
            $user->save();
        }

        $user->assignRole('admin');
                
        return redirect()->route('app.home');
    }


    public function render()
    {
        return view('livewire.authentication.register.simple-register-component')
            ->extends('layouts.auth')
            ->section('content');
    }
}
