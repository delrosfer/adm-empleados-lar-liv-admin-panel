<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{
    public $search='';
    public $username, $firstName, $lastName, $email, $password;
    public $userId;
    public $editMode = false;

    protected $rules = [
        'username' => 'required',
        'firstName' => 'required',
        'lastName' => 'required',
        'password' => 'required',
        'email' => 'required|email',
    ];

    public function storeUser()
    {
        $this->validate();

        User::create([
            'username' => $this->username,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal');

        session()->flash('user-message', 'Usuario creado exitosamente');
    }

    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode = true;

        $this->userId = $id;

        $this->loadUser();

        $this->dispatchBrowserEvent('showModal');
    }

    public function loadUser()
    {
        $user = User::find($this->userId);

        $this->username = $user->username;
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->email = $user->email;
    }

    public function updateUser()
    {
        $validated = $this->validate([
        'username' => 'required',
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required|email',
        ]);
        $user = User::find($this->userId);
        $user->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal');

        session()->flash('user-message', 'Usuario actualizado exitosamente');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        session()->flash('user-message', 'Usuario eliminado exitosamente');
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
        $this->reset();
    }

    public function render()
    {
        $users = User::all();
        if(strlen($this->search) > 2) {
            $users = User::where('username', 'like', "%{$this->search}%")->get();
        }

        return view('livewire.users.user-index', [
            'users' => $users
            ])
            ->layout('layouts.main');
    }
}
