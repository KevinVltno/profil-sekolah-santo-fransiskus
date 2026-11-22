<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Konten;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private const BULAN = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    public function index()
    {
        $user   = auth('admin')->user();
        $jumlah = Konten::selectRaw('seksi, COUNT(*) as total')->groupBy('seksi')->pluck('total', 'seksi');

        // Hanya seksi yang boleh dikelola peran ini (admin: semua, guru: seksi_guru)
        $seksi = collect(config('admin_menu.seksi'))->filter(fn ($m, $k) => $user->bolehKonten($k));

        /* Grafik 1: jumlah data per menu (batang) */
        $perMenu = [
            'label' => $seksi->map(fn ($m) => $m['halaman'] . ' · ' . $m['judul'])->values()->all(),
            'data'  => $seksi->map(fn ($m, $k) => (int) ($jumlah[$k] ?? 0))->values()->all(),
        ];

        /* Grafik 2: komposisi data per halaman website (donat) */
        $perHalaman = [];
        foreach ($seksi as $k => $m) {
            $perHalaman[$m['halaman']] = ($perHalaman[$m['halaman']] ?? 0) + (int) ($jumlah[$k] ?? 0);
        }

        /* Grafik 3: berita per bulan, 6 bulan terakhir (garis) */
        $beritaBulanan = null;
        if ($user->bolehKonten('berita')) {
            $hitung = Konten::where('seksi', 'berita')->whereNotNull('tanggal')->get(['tanggal'])
                ->groupBy(fn ($r) => $r->tanggal->format('Y-m'))
                ->map->count();

            $label = $data = [];
            for ($i = 5; $i >= 0; $i--) {
                $b       = Carbon::now()->startOfMonth()->subMonths($i);
                $label[] = self::BULAN[$b->month - 1] . ' ' . $b->format('y');
                $data[]  = (int) ($hitung[$b->format('Y-m')] ?? 0);
            }
            $beritaBulanan = compact('label', 'data');
        }

        /* Grafik 4 (khusus admin): jumlah akun admin dan guru */
        $akun = null;
        if ($user->isAdmin()) {
            $r    = Admin::selectRaw('role, COUNT(*) as total')->groupBy('role')->pluck('total', 'role');
            $akun = ['label' => ['Admin', 'Guru'], 'data' => [(int) ($r['admin'] ?? 0), (int) ($r['guru'] ?? 0)]];
        }

        return view('admin.dashboard', [
            'jumlah'        => $jumlah,
            'terbaru'       => Konten::seksi('berita')->limit(3)->get(),
            'perMenu'       => $perMenu,
            'perHalaman'    => ['label' => array_keys($perHalaman), 'data' => array_values($perHalaman)],
            'beritaBulanan' => $beritaBulanan,
            'akun'          => $akun,
            'pageKey'       => 'dashboard',
            'pageTitle'     => 'Dashboard',
            'pageDesc'      => 'Ringkasan konten website sekolah.',
        ]);
    }
}
