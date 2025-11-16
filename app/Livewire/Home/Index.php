<?php

namespace App\Livewire\Home;

use App\Helpers\HomeChart;
use App\Models\Comment;
use App\Models\SocialMedia;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $totalSocialMedia = 0;
    public $totalComment = 0;
    public $totalUser = 0;

    public $totalNetralChart;
    public $totalPositifChart;
    public $totalNegatifChart;

    public $netralPercent;
    public $positifPercent;
    public $negatifPercent;

    public $period = 'daily';

    public function getDataCount()
    {
        $this->totalSocialMedia = SocialMedia::count();
        $this->totalComment = Comment::count();
        $this->totalUser = User::count();
    }

    public function getDataChart()
    {
        $this->totalNetralChart = HomeChart::CHART_DATA(Comment::query()->where('status_232187', 'netral'), $this->period);
        $this->totalNegatifChart = HomeChart::CHART_DATA(Comment::query()->where('status_232187', 'negatif'), $this->period);
        $this->totalPositifChart = HomeChart::CHART_DATA(Comment::query()->where('status_232187', 'positif'), $this->period);

        // Hitung total untuk persen
        $totalPositif = array_sum($this->totalPositifChart['data']);
        $totalNegatif = array_sum($this->totalNegatifChart['data']);
        $totalNetral  = array_sum($this->totalNetralChart['data']);

        $totalSemua = $totalPositif + $totalNegatif + $totalNetral;

        if ($totalSemua > 0) {
            $this->positifPercent = round(($totalPositif / $totalSemua) * 100, 1);
            $this->negatifPercent = round(($totalNegatif / $totalSemua) * 100, 1);
            $this->netralPercent  = round(($totalNetral / $totalSemua) * 100, 1);
        } else {
            $this->positifPercent = 0;
            $this->negatifPercent = 0;
            $this->netralPercent = 0;
        }
    }

    public function getLoginHistories()
    {
        $user = User::query();

        $query = $user->whereNotNull('last_login_time_232187')
            ->orderBy('last_login_time_232187', 'DESC');

        return $query->limit(20)->get();
    }

    public function mount()
    {
        $this->getDataCount();
        $this->getDataChart();
    }

    public function updatedPeriod()
    {
        $this->getDataChart();

        $date = $this->totalNetralChart['date'];
        $totalNegatif = $this->totalNegatifChart['data'];
        $totalPositif = $this->totalPositifChart['data'];
        $totalNetral = $this->totalNetralChart['data'];

        $this->dispatch('updateChart', [
            'total_negatif' => $totalNegatif,
            'total_positif' => $totalPositif,
            'total_netral' => $totalNetral,
            'date' => $date,
            'percent' => [
                'positif' => $this->positifPercent,
                'negatif' => $this->negatifPercent,
                'netral'  => $this->netralPercent,
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.home.index', [
            'login_history' => $this->getLoginHistories(),
        ]);
    }
}
