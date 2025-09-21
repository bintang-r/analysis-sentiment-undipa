<?php

namespace App\Livewire\User;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;

    public $filters = [
        'search' => '',
    ];

    public function deleteSelected()
    {
        $users = User::whereIn('id', $this->selected)->get();
        $deleteCount = $users->count();

        foreach ($users as $data) {
            if ($data->avatar) {
                File::delete(public_path('storage/' . $data->avatar));
            }
            $data->delete();
        }

        $this->reset();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menghapus $deleteCount data pengguna aplikasi.",
        ]);

        return redirect()->back();
    }

    public function changeStatus($id)
    {
        $user = User::find($id);
        $user->email_verified_at = $user->email_verified_at ? null : now();
        $user->save();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil mengubah status pengguna.",
        ]);
    }

    #[On('muat-ulang')]
    #[Computed()]
    public function rows()
    {
        $query = User::query()
            ->when(!$this->sorts, fn($query) => $query->first())
            ->when($this->filters['search'], function ($query, $search) {
                $query->where('username', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            })->latest();

        $query = secret_user($query);

        return $this->applyPagination($query);
    }

    #[Computed()]
    public function allData()
    {
        return User::all();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function muatUlang()
    {
        $this->dispatch('muat-ulang');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.user.index');
    }
}
