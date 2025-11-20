<?php

namespace App\Livewire\Setting\Account;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $userId;
    public $username;
    public $surel;
    public $nomorPonsel;
    public $kataSandi;
    public $konfirmasiKataSandi;
    public $statusAkun;
    public $avatar;
    public $avatarUrl;

    public function rules()
    {
        return [
            'username' => [
                'required',
                'unique:users_232187,username_232187,' . $this->userId,
                'min:3',
                'max:20',
                'regex:/\w*$/',
            ],
            'surel' => [
                'required',
                'email',
                'unique:users_232187,email_232187,' . $this->userId,
            ],
            'kataSandi' => ['nullable', 'min:6', 'same:konfirmasiKataSandi'],
            'avatar' => ['nullable', 'file', 'image', 'max:1024'],
        ];
    }

    public function updatedUsername()
    {
        $this->validateOnly('username');
    }

    public function updatedSurel()
    {
        $this->validateOnly('surel');
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
    }

    public function edit()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        try {
            $user->update([
                'username_232187' => $this->username_232187,
                'email_232187' => $this->surel_232187,
            ]);

            if ($this->avatar) {
                if ($user->avatar_232187) {
                    File::delete(public_path('storage/' . $this->avatar_232187));
                }

                $user->update([
                    'avatar_232187' => $this->avatar_232187->store('avatar', 'public'),
                ]);
            }

            if ($this->kataSandi) {
                $user->update([
                    'password_232187' => bcrypt($this->kataSandi),
                ]);
            }
        } catch (Exception $e) {
            logger()->error(
                '[setting] ' .
                    auth()->user()->username_232187 .
                    ' gagal menyunting akun',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal!',
                'detail' => 'Akun gagal disunting.',
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => 'Akun berhasil disunting.',
        ]);

        return redirect()->back();
    }

    public function mount()
    {
        $user = User::findOrFail(auth()->user()->id_232187);

        $this->userId = $user->id_232187;
        $this->username = $user->username_232187;
        $this->surel = $user->email_232187;

        $this->avatarUrl = $user->avatarUrl();
    }

    public function render()
    {
        return view('livewire.setting.account.index');
    }
}
