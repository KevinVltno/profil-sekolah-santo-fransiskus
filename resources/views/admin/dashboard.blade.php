@extends('admin.layout')

@section('content')
<section class="card" id="panduan-data-dummy" aria-labelledby="judul-panduan-data-dummy">
  <div class="card-header">
    <h2 id="judul-panduan-data-dummy">Panduan Menambahkan Data Dummy</h2>
    <a class="btn-ghost" href="{{ asset('img/sekolah-placeholder.webp') }}" download>Unduh gambar contoh</a>
  </div>
  <div class="card-body dummy-guide">
    <ol>
      <li>Pilih menu konten di sidebar, misalnya <a href="{{ route('admin.konten.index', 'berita') }}">Berita</a> atau <a href="{{ route('admin.konten.index', 'beranda_galeri') }}">Galeri</a>, lalu klik <strong>+ Tambah</strong>.</li>
      <li>Isi kolom bertanda bintang. Jika formulir meminta foto, unggah gambar contoh di atas atau gunakan file JPG, PNG, WebP, atau GIF berukuran maksimal 3 MB.</li>
      <li>Klik <strong>Simpan</strong>, lalu buka halaman publik terkait untuk memeriksa hasilnya. Data contoh yang disimpan dapat dilihat oleh pengunjung situs.</li>
      <li>Setelah selesai, gunakan <strong>Edit</strong> untuk mengganti data contoh dengan konten resmi, atau <strong>Hapus</strong> untuk menghilangkannya.</li>
    </ol>
    <p><strong>Contoh berita.</strong> Gunakan judul “Contoh – Kegiatan Membaca Bersama”, pilih tanggal, dan isi berita dengan “Ini contoh isi berita untuk melihat tampilan kartu dan halaman detail.” Unggah gambar contoh pada kolom Foto.</p>
  </div>
</section>

<div class="stat-grid">
  @foreach (config('admin_menu.seksi') as $k => $m)
    @if (auth('admin')->user()->bolehKonten($k))
    <a class="stat-card" href="{{ route('admin.konten.index', $k) }}">
      <span class="ic">{{ ikon($m['ikon']) }}</span>
      <b>{{ (int) ($jumlah[$k] ?? 0) }}</b>
      <span>{{ $m['halaman'] }} · {{ $m['judul'] }}</span>
    </a>
    @endif
  @endforeach
</div>

<div class="grid-2 chart-grid">
  <div class="card">
    <div class="card-header"><h2>Jumlah Data per Menu</h2></div>
    <div class="card-body"><div class="chart-box tall"><canvas id="chMenu"></canvas></div></div>
  </div>
  <div class="card">
    <div class="card-header"><h2>Komposisi Data per Halaman</h2></div>
    <div class="card-body"><div class="chart-box"><canvas id="chHalaman"></canvas></div></div>
  </div>
  @if ($beritaBulanan)
  <div class="card">
    <div class="card-header"><h2>Berita per Bulan (6 Bulan Terakhir)</h2></div>
    <div class="card-body"><div class="chart-box"><canvas id="chBerita"></canvas></div></div>
  </div>
  @endif
  @if ($akun)
  <div class="card">
    <div class="card-header"><h2>Akun Admin dan Guru</h2></div>
    <div class="card-body"><div class="chart-box"><canvas id="chAkun"></canvas></div></div>
  </div>
  @endif
</div>

<div class="card" style="margin-top:20px">
  <div class="card-header"><h2>Berita Terkini di Beranda (otomatis dari menu Berita)</h2></div>
  <div class="card-body">
    @forelse ($terbaru as $b)
      <p style="font-size:.9rem;margin-bottom:6px"><strong>{{ $b->judul }}</strong> <span class="item-meta">· {{ $b->tanggal?->format('d-m-Y') }}</span></p>
    @empty
      <p class="empty-state">Belum ada berita. <a href="{{ route('admin.konten.index', 'berita') }}">Tambah berita →</a></p>
    @endforelse
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {
  const warna = ['#2563eb', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899'];
  Chart.defaults.font.family = "'Plus Jakarta Sans', system-ui, sans-serif";
  Chart.defaults.color = '#64748b';
  const bulat = { ticks: { precision: 0 }, beginAtZero: true };

  const perMenu = @json($perMenu);
  new Chart(document.getElementById('chMenu'), {
    type: 'bar',
    data: { labels: perMenu.label, datasets: [{ label: 'Jumlah data', data: perMenu.data, backgroundColor: '#2563eb', borderRadius: 6 }] },
    options: { indexAxis: 'y', maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: bulat } }
  });

  const perHalaman = @json($perHalaman);
  new Chart(document.getElementById('chHalaman'), {
    type: 'doughnut',
    data: { labels: perHalaman.label, datasets: [{ data: perHalaman.data, backgroundColor: warna, borderWidth: 2 }] },
    options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
  });

  @if ($beritaBulanan)
  const berita = @json($beritaBulanan);
  new Chart(document.getElementById('chBerita'), {
    type: 'line',
    data: { labels: berita.label, datasets: [{ label: 'Berita', data: berita.data, borderColor: '#10b981', backgroundColor: '#10b98126', fill: true, tension: .3, pointRadius: 4 }] },
    options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: bulat } }
  });
  @endif

  @if ($akun)
  const akun = @json($akun);
  new Chart(document.getElementById('chAkun'), {
    type: 'doughnut',
    data: { labels: akun.label, datasets: [{ data: akun.data, backgroundColor: ['#2563eb', '#f59e0b'], borderWidth: 2 }] },
    options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
  });
  @endif
})();
</script>
@endpush
