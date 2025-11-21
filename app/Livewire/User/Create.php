<?php

namespace App\Livewire\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $username;
    public $email;
    public $kataSandi;
    public $avatar;
    public $role = 'admin';
    public $konfirmasiKataSandi;

    public function validateData()
    {
        $this->validate([
            'username'      => ['required', 'string', 'min:2', 'max:255'],
            'role'          => ['required', 'string', 'min:2', 'max:255', Rule::in(config('const.roles'))],
            'email'         => ['required', 'string', 'min:2', 'unique:users_232187,email_232187'],
            'kataSandi'     => ['required', 'string', 'same:konfirmasiKataSandi', Password::default()],
            'avatar'        => ['nullable', 'image', 'max:2048'],
        ]);
    }

    public function save()
    {
        $this->validateData();

        try {
            DB::beginTransaction();

            $user = User::create([
                'username_232187'          => $this->username,
                'email_232187'             => strtolower($this->email),
                'password_232187'          => bcrypt($this->kataSandi),
                'role_232187'              => $this->role,
                'email_verified_at_232187' => now(),
            ]);

            if ($this->avatar) {
                $user->update([
                    'avatar_232187' => $this->avatar->store('avatars', 'public'),
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            logger()->error(
                '[pengguna] ' .
                    auth()->user()->username_232187 .
                    ' gagal menambahkan pengguna',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => "Gagal menambahkan data pengguna.",
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menambahkan data pengguna.",
        ]);

        return redirect()->route('user.index');
    }

    public function render()
    {
        return view('livewire.user.create');
    }
}
