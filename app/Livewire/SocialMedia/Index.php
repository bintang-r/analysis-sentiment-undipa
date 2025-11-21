<?php

namespace App\Livewire\SocialMedia;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\SocialMedia;
use Exception;
use Illuminate\Support\Facades\DB;
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

    public $socialMediaId;
    public $socialMedia;

    public $namaSosialMedia;
    public $isActive = true;

    public function deleteSelected()
    {
        $socialMedias = SocialMedia::whereIn('id_232187', $this->selected)->get();
        $deleteCount = $socialMedias->count();

        foreach ($socialMedias as $data) {
            $data->delete();
        }

        $this->reset();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menghapus $deleteCount data sosial media.",
        ]);

        return redirect()->back();
    }

    public function changeStatus($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->is_active = !$socialMedia->is_active;
        $socialMedia->save();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil mengubah status sosial media.",
        ]);

        return redirect()->back();
    }

    public function openModal($id)
    {
        $this->socialMedia = SocialMedia::find($id);
        $this->socialMediaId = $id;

        $this->namaSosialMedia = $this->socialMedia->name_232187;
        $this->isActive = $this->socialMedia->is_active_232187 == 1 ? true : false;
    }

    public function closeModal()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'socialMedia',
            'socialMediaId',
            'namaSosialMedia',
            'isActive',
        ]);
    }

    public function saveCategoryProduct()
    {
        $this->validate([
            'namaSosialMedia' => ['required', 'string', 'min:2', 'max:255'],
            'isActive'        => ['required', 'boolean'],
        ]);

        try {
            DB::beginTransaction();

            if ($this->socialMedia) {
                $this->socialMedia->update([
                    'name_232187'      => $this->namaSosialMedia,
                    'is_active_232187' => $this->isActive,
                ]);
            } else {
                SocialMedia::create([
                    'name_232187'      => $this->namaSosialMedia,
                    'is_active_232187' => $this->isActive,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            logger()->error(
                '[sosial media] ' .
                    auth()->user()->username_232187 .
                    ' gagal menambahkan sosial media',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal.',
                'detail' => "data komentar sosial media gagal ditambah.",
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil.',
            'detail' => "data komentar sosial media berhasil ditambah.",
        ]);

        $this->reset();
        return redirect()->back();
    }

    #[On('muat-ulang')]
    #[Computed()]
    public function rows()
    {
        $query = SocialMedia::query()
            ->when(!$this->sorts, fn($query) => $query->first())
            ->when($this->filters['search'], function ($query, $search) {
                $query->where('name_232187', 'LIKE', "%$search%");
            })
            ->latest();

        return $this->applyPagination($query);
    }

    #[Computed()]
    public function allData()
    {
        return SocialMedia::all();
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
        return view('livewire.social-media.index');
    }
}
