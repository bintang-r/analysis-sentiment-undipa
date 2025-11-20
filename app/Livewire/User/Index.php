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
        $users = User::whereIn('id_232187', $this->selected)->get();
        $deleteCount = $users->count();

        foreach ($users as $data) {
            if ($data->avatar_232187) {
                File::delete(public_path('storage/' . $data->avatar_232187));
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
        $user->email_verified_at_232187 = $user->email_verified_at_232187 ? null : now();
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
                $query->where('username_232187', 'LIKE', "%$search%")
                    ->orWhere('email_232187', 'LIKE', "%$search%");
            })->latest();

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
