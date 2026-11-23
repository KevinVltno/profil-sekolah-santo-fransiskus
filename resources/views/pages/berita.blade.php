@extends('layouts.app')
@section('title', 'Berita | SD Santo Fransiskus Sragen')

@section('content')
  @include('partials.page-header', [
    'crumb' => 'Berita',
    'title' => 'Berita & Kegiatan',
    'desc'  => 'Informasi kegiatan, prestasi, dan pengumuman sekolah.',
    'showImage' => false,
  ])
  <section>
    <div class="inner">
      <div class="news-grid">
        @forelse ($berita as $b)
          @include('partials.news-card', ['b' => $b])
        @empty
          <div class="news-card">
            <img src="{{ asset('img/sekolah-placeholder.webp') }}" alt="" />
            <div class="news-body"><p>Belum ada berita yang diterbitkan.</p></div>
          </div>
        @endforelse
      </div>
    </div>
  </section>
@endsection
