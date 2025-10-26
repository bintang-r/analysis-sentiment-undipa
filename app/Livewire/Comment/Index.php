<?php

namespace App\Livewire\Comment;

use App\Livewire\Traits\DataTable\WithBulkActions;
use App\Livewire\Traits\DataTable\WithCachedRows;
use App\Livewire\Traits\DataTable\WithPerPagePagination;
use App\Livewire\Traits\DataTable\WithSorting;
use App\Models\Comment;
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
        'status' => '',
        'social_media' => '',
    ];

    public $commentId;
    public $comment;

    public $komentarSentiment;
    public $sosialMedia;
    public $status = 'async';

    public function deleteSelected()
    {
        $comment = Comment::whereIn('id', $this->selected)->get();
        $deleteCount = $comment->count();

        foreach ($comment as $data) {
            $data->delete();
        }

        $this->reset();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil!',
            'detail' => "Berhasil menghapus $deleteCount data komentar sentimen.",
        ]);

        return redirect()->back();
    }

    public function openModal($id)
    {
        $this->comment = Comment::find($id);
        $this->commentId = $id;

        $this->komentarSentiment = $this->comment->comment;
        $this->status = $this->comment->status;
        $this->sosialMedia = $this->comment->social_media_id;
    }

    #[Computed()]
    public function social_medias()
    {
        return SocialMedia::all();
    }

    public function closeModal()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'komentarSentiment',
            'commentId',
            'comment',
            'status',
            'sosialMedia',
        ]);
    }

    public function saveCategoryProduct()
    {
        $this->validate([
            'komentarSentiment' => ['required', 'string'],
        ]);

        try {
            DB::beginTransaction();

            if ($this->comment) {
                $this->comment->update([
                    'user_id'         => auth()->id(),
                    'social_media_id' => $this->sosialMedia,
                    'status'          => $this->status,
                    'comment'         => $this->komentarSentiment,
                ]);
            } else {
                Comment::create([
                    'user_id'         => auth()->id(),
                    'social_media_id' => $this->sosialMedia,
                    'status'          => $this->status,
                    'comment'         => $this->komentarSentiment,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            logger()->error(
                '[komentar sentimen] ' .
                    auth()->user()->username .
                    ' gagal menambahkan komentar sentimen',
                [$e->getMessage()]
            );

            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal.',
                'detail' => "data komentar sentimen gagal ditambah.",
            ]);

            return redirect()->back();
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil.',
            'detail' => "data komentar sentiment berhasil ditambah.",
        ]);

        $this->reset();
        return redirect()->back();
    }

    #[On('muat-ulang')]
    #[Computed()]
    public function rows()
    {
        $query = Comment::query()
            ->when(!$this->sorts, fn($query) => $query->first())
            ->when($this->filters['search'], function ($query, $search) {
                $query->where('comment', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%");
            })
            ->when($this->filters['status'], function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($this->filters['social_media'], function ($query, $sosmed) {
                $query->where('social_media_id', $sosmed);
            })
            ->latest();

        return $this->applyPagination($query);
    }

    #[Computed()]
    public function allData()
    {
        return Comment::all();
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
        return view('livewire.comment.index');
    }
}
