<div class="page-header">
  <div class="inner {{ ($showImage ?? true) ? 'page-header-with-image' : '' }}">
    <div>
      <div class="crumb"><a href="{{ route('beranda') }}">Beranda</a> / {{ $crumb }}</div>
      <h1>{{ $title }}</h1>
      <p>{{ $desc }}</p>
    </div>
    @if ($showImage ?? true)
      <img class="page-header-image" src="{{ asset('img/sekolah-placeholder.webp') }}" alt="" />
    @endif
  </div>
</div>
