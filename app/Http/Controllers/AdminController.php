<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Documento;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $inicio = now()->subMonth()->startOfDay();
        $fim    = now()->addMonth()->endOfDay();

        $cursos = Curso::whereBetween('data_inicio', [$inicio, $fim])
            ->orderBy('data_inicio')
            ->get();

        $documentos = Documento::where('ativo', true)
            ->where(function ($q) {
                $q->whereNull('data_vencimento')->orWhere('data_vencimento', '>=', now()->toDateString());
            })
            ->orderBy('ordem')->orderBy('id')->limit(8)->get();

        $analytics = $this->analyticsData();

        return view('admin.dashboard', compact('cursos', 'documentos', 'analytics'));
    }

    private function analyticsData(): array
    {
        $today = now()->startOfDay();
        $week  = now()->subDays(6)->startOfDay();
        $month = now()->subDays(29)->startOfDay();

        $pv = fn($from) => PageView::where('created_at', '>=', $from)->count();
        $uv = fn($from) => PageView::where('created_at', '>=', $from)->distinct('ip')->count('ip');

        $topPages = PageView::where('created_at', '>=', $month)
            ->select('url', DB::raw('count(*) as total'))
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'url');

        $topReferrers = PageView::where('created_at', '>=', $month)
            ->whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->select(DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(referrer,'/',3),'://',-1),'/',1) as host"),
                     DB::raw('count(*) as total'))
            ->groupBy('host')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'host');

        $devices = PageView::where('created_at', '>=', $month)
            ->select('device', DB::raw('count(*) as total'))
            ->groupBy('device')
            ->pluck('total', 'device');

        return [
            'pv_hoje'       => $pv($today),
            'pv_7d'         => $pv($week),
            'pv_30d'        => $pv($month),
            'uv_hoje'       => $uv($today),
            'uv_7d'         => $uv($week),
            'uv_30d'        => $uv($month),
            'top_pages'     => $topPages,
            'top_referrers' => $topReferrers,
            'devices'       => $devices,
        ];
    }
}
