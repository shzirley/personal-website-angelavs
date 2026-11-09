{{-- Blade sections are global, so this single include themes every AdminLTE page. --}}
@section('css')
    @include('admin.partials.head')
@endsection

@section('content_top_nav_left')
    <li class="nav-item">
        <a class="brand" href="{{ route('admin.dashboard') }}"><span class="brand-mark" aria-hidden="true">✿</span> Angela<span class="brand-os">OS</span></a>
    </li>
    <li class="system-tab">back office <span aria-hidden="true">♡</span></li>
    <li class="nav-item">
        <button class="theme-toggle" type="button" data-theme-toggle aria-pressed="false" aria-label="Switch to midnight terminal"><span data-theme-icon aria-hidden="true">&gt;_</span><span data-theme-label>Midnight</span></button>
    </li>
@endsection

@section('footer')
    @include('admin.partials.boot')
    <div class="site-footer">
        <a class="footer-signature" href="{{ route('home') }}">Angela <span aria-hidden="true">✿</span></a>
        <span>© {{ date('Y') }} {{ $profile['short_name'] }} · Back office, made with a curious mind.</span>
    </div>
@endsection
