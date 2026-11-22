@extends('layouts.app')
@section('title', 'Profil Guru & Staff | SD Santo Fransiskus Sragen')

@section('content')
  @include('partials.page-header', [
    'crumb' => 'Profil Sekolah / Guru & Staff',
    'title' => 'Profil Guru & Staff',
    'desc'  => 'Tenaga pendidik berpengalaman dan berdedikasi untuk mendampingi siswa belajar dan bertumbuh.',
  ])

  <section class="guru-section">
    <div class="inner">
      @if ($bersama?->gambar)
      <figure class="guru-bersama reveal">
        <img src="{{ asset($bersama->gambar) }}" alt="{{ $bersama->judul }}" loading="lazy" />
        <figcaption><b>{{ $bersama->judul }}</b><span>{{ $bersama->teks2 }}</span></figcaption>
      </figure>
      @endif

      <div class="guru-grid">
        @forelse ($staf as $g)
        <div class="guru-card reveal">
          <img src="{{ asset($g->gambar ?: 'img/guru-placeholder.webp') }}"
               alt="{{ $g->gambar ? $g->judul : '' }}" width="480" height="480" loading="lazy" decoding="async" />
          <div class="guru-info">
            <h3>{{ $g->judul }}</h3>
            <span class="role">{{ $g->teks2 }}</span>
            @if (trim((string) $g->teks))<p>{{ $g->teks }}</p>@endif
          </div>
        </div>
        @empty
          <div class="guru-empty">
            <img src="{{ asset('img/guru-placeholder.webp') }}" alt="" width="96" height="96" />
            <p>Profil guru dan staf belum tersedia.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>
@endsection
