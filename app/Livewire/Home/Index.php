<?php

namespace App\Livewire\Home;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function getLoginHistories()
    {
        $user = User::query();

        $query = $user->whereNotNull('last_login_time_232187')
            ->orderBy('last_login_time_232187', 'DESC');

        return $query->limit(20)->get();
    }

    public function render()
    {
        return view('livewire.home.index', [
            'login_history' => $this->getLoginHistories(),
        ]);
    }
}
