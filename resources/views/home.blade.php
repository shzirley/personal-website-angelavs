@extends('layouts.app')
@section('title', 'Home')
@section('content')
<section class="hero bubble-zone">
    <span class="float-bubble bubble-one" aria-hidden="true"></span><span class="float-bubble bubble-two" aria-hidden="true"></span><span class="float-spark spark-one" aria-hidden="true">✦</span>
    <div class="hero-copy">
        <p class="eyebrow intro-label"><span aria-hidden="true">✳</span> INFORMATICS STUDENT @ ITS</p>
        <h1>Hi, I’m<br><span class="name-highlight">Angela<span class="pixel-star" aria-hidden="true">✳</span></span><span class="hero-period">.</span></h1>
        <p class="hero-subtitle">A curious mind.<br>A little bit of <em>everything.</em></p>
        <p class="hero-description">Welcome to my tiny corner of the internet. {{ $profile['intro'] }}</p>
        <div class="button-row"><a class="button primary" href="{{ route('mahasiswa.show', $profile['nrp']) }}">Get to know me <span aria-hidden="true">↗</span></a><a class="text-link" href="{{ route('projects.index') }}">Explore my projects <span aria-hidden="true">→</span></a></div>
        <a class="scroll-hint" href="#little-about"><span aria-hidden="true">↓</span> SCROLL TO EXPLORE</a>
    </div>
    <div class="hero-media">
        <span class="floating-label"><span class="typed-line" data-typewriter="hello, world!">hello, world!</span><span aria-hidden="true"> ♡</span></span>
        <div class="flip-scene" data-flip-card>
            <div class="flip-card">
                <div class="window portrait-window flip-face flip-front">
                    <div class="window-bar"><span>angela.exe</span><span class="window-controls"><button type="button" data-window-minimize aria-label="Minimize profile window">−</button><button type="button" data-flip-trigger aria-label="Flip profile card">□</button><button type="button" data-flip-trigger aria-label="Flip profile card">×</button></span></div>
                    <div class="portrait-wrap"><img src="{{ asset('images/profile/profile_photo.png') }}" alt="Angela Vania Sugiyono wearing an ITS jacket" width="467" height="545" fetchpriority="high"><span class="photo-caption">a face behind the pixels :)</span></div>
                    <div class="portrait-status"><span>✿ learning, creating, growing</span><span aria-hidden="true">▰▰▰</span></div>
                </div>
                <div class="window portrait-window flip-face flip-back" aria-hidden="true">
                    <div class="window-bar"><span>quick-facts.txt</span><span class="window-controls"><button type="button" data-flip-trigger aria-label="Return to profile photo">↶</button><button type="button" data-flip-trigger aria-label="Return to profile photo">×</button></span></div>
                    <div class="flip-notes"><p class="eyebrow">A FEW PIXELS ABOUT ME</p><h2>Research brain.<br><em>Playlist heart.</em></h2><ul><li>Teaching OS & networks</li><li>Building CLARITAS as COO</li><li>Always collecting new questions</li></ul><button type="button" class="button secondary" data-flip-trigger>Back to photo ↶</button></div>
                </div>
            </div>
        </div>
        <div class="sticky-note"><span class="eyebrow">CURRENTLY INTO</span><span>AI, thoughtful design<br>& figuring things out.</span><span class="note-heart" aria-hidden="true">♡</span></div>
        <span class="media-star" aria-hidden="true">✧</span>
    </div>
</section>
<div class="interest-strip" aria-label="Areas of interest"><span>RESEARCH</span><b aria-hidden="true">✳</b><span>UI / UX DESIGN</span><b aria-hidden="true">✳</b><span>AI & MACHINE LEARNING</span><b aria-hidden="true">✳</b><span>OPERATING SYSTEMS</span></div>

<section class="pet-lane" aria-label="AngelaOS desktop pet">
    <div class="cat-speech" data-cat-speech aria-live="polite">pspsps... click me!</div>
    <button class="pixel-cat" type="button" data-pixel-cat aria-label="Pet the walking robot cat"><img src="{{ asset('images/mascot/pixel-cat.png') }}" alt="" width="1254" height="1254"></button>
    <span class="pet-lane-label">ANGELAOS DESKTOP PET · ONLINE</span>
</section>

<nav class="desktop-shortcuts" aria-label="Desktop shortcuts">
    <a href="{{ route('mahasiswa.show', $profile['nrp']) }}"><span>@include('partials.icon', ['icon' => 'notepad'])</span><strong>profile.txt</strong><small>ABOUT ME</small></a>
    <a href="{{ route('projects.index') }}"><span>@include('partials.icon', ['icon' => 'folder'])</span><strong>projects/</strong><small>MY WORK</small></a>
    <a href="{{ route('collection') }}"><span>@include('partials.icon', ['icon' => 'award'])</span><strong>little-wins/</strong><small>ACHIEVEMENTS</small></a>
    <a href="#off-duty"><span>@include('partials.icon', ['icon' => 'youtube'])</span><strong>ros.player</strong><small>NOW PLAYING</small></a>
</nav>

<section class="bubble-game" aria-labelledby="bubble-game-title">
    <div class="bubble-game-copy reveal">
        <p class="eyebrow">A TINY CLICK BREAK</p>
        <h2 id="bubble-game-title">Pop a little<br><em>digital joy.</em></h2>
        <p>Catch the floating balloons before they wander off. The desktop cat is absolutely keeping score.</p>
        <div class="bubble-game-status"><span><strong data-bubble-count>0</strong> / 8 POPPED</span><button type="button" data-bubble-reset hidden>Play again ↻</button></div>
        <p class="bubble-message" data-bubble-message aria-live="polite">Choose a balloon to begin.</p>
    </div>
    <div class="balloon-field reveal" data-balloon-field aria-label="Interactive floating balloons">
        @foreach([
            ['12%', '-.8s', '.86'], ['26%', '-3.2s', '1.08'], ['39%', '-1.7s', '.72'], ['52%', '-4.8s', '1'],
            ['65%', '-2.5s', '.82'], ['76%', '-5.6s', '1.13'], ['86%', '-1.1s', '.76'], ['94%', '-4s', '.92'],
        ] as [$x, $delay, $scale])
            <button class="play-balloon balloon-tone-{{ ($loop->index % 4) + 1 }}" type="button" data-pop-balloon aria-label="Pop balloon {{ $loop->iteration }}" style="--balloon-x:{{ $x }};--balloon-delay:{{ $delay }};--balloon-scale:{{ $scale }}"><span aria-hidden="true">♡</span></button>
        @endforeach
    </div>
</section>

<section class="section about-preview" id="little-about">
    <div class="section-heading reveal"><p class="eyebrow">01 / THE PERSON BEHIND THE SCREEN</p><h2>More than<br>a <em>profile picture.</em></h2></div>
    <div class="about-preview-copy reveal"><p>I’m happiest when I can take something complicated, understand it properly, and make it feel a little more useful.</p><p class="muted">Right now, that means studying Informatics at ITS, teaching systems labs, exploring AI, and designing digital experiences that make sense.</p><a class="text-link" href="{{ route('mahasiswa.show', $profile['nrp']) }}">Open profile.txt <span aria-hidden="true">↗</span></a></div>
</section>

<section class="section projects-section">
    <div class="section-heading heading-row reveal"><div><p class="eyebrow">02 / THINGS I’VE HELPED BRING TO LIFE</p><h2>From loose ideas<br>to <em>real little things.</em></h2></div><a class="button secondary" href="{{ route('projects.index') }}">All projects ↗</a></div>
    @include('partials.projects')
</section>

<section class="section music-section bubble-zone" id="off-duty">
    <span class="float-bubble music-bubble" aria-hidden="true"></span>
    <div class="music-visuals reveal">
        <div class="record-player" data-music-player>
            <div class="turntable"><div class="vinyl"><div class="vinyl-label">ROS<span>MAC MILLER</span></div></div><div class="tonearm" aria-hidden="true"></div><button class="record-play" type="button" data-music-toggle aria-expanded="false"><span data-music-icon>▶</span><span data-music-label>Play</span></button></div>
            <div class="music-embed" data-music-embed hidden><button class="music-close" type="button" data-music-close aria-label="Stop music and close player">×</button><iframe title="ROS by Mac Miller on YouTube" width="560" height="315" loading="lazy" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen data-src="https://www.youtube-nocookie.com/embed/{{ $profile['music']['youtube_id'] }}?autoplay=1&playsinline=1"></iframe></div>
        </div>
        <div class="album-sleeve" aria-label="Decorative listening card for {{ $profile['music']['album'] }} by {{ $profile['music']['artist'] }}">
            <div class="album-sleeve-art"><span class="album-clock">GO:OD<br>AM</span><span class="album-orbit" aria-hidden="true">✦</span><span class="album-track">TRACK 11 · ROS</span></div>
            <div class="album-sleeve-caption"><strong>{{ $profile['music']['album'] }}</strong><span>{{ $profile['music']['artist'] }}</span></div>
        </div>
    </div>
    <div class="music-copy reveal"><p class="eyebrow">03 / OFF-DUTY MODE</p><h2>My brain has<br>a <em>soundtrack.</em></h2><p class="music-lead"><strong>{{ number_format($profile['music']['minutes']) }} minutes</strong> on Spotify in {{ $profile['music']['year'] }}. Apparently, silence was never part of the plan. Let’s see if this year can beat it.</p><div class="now-playing"><span class="equalizer" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span><span><small data-player-status>CURRENT FAVOURITE</small><strong>{{ $profile['music']['title'] }} · {{ $profile['music']['artist'] }}</strong><em>{{ $profile['music']['album'] }}</em></span></div><p class="muted">Press play on the record for the official track. Lyrics stay with the licensed music page, where they belong.</p><div class="music-links"><a class="text-link" href="{{ $profile['music']['lyrics_url'] }}" target="_blank" rel="noopener noreferrer">Open lyrics ↗</a><a class="text-link" href="{{ $profile['music']['spotify_url'] }}" target="_blank" rel="noopener noreferrer">Spotify ↗</a></div></div>
</section>

<section class="section achievements-preview">
    <div class="heading-row reveal"><div><p class="eyebrow">04 / LITTLE WINS, BIG MEMORIES</p><h2>Proof that curiosity<br><em>goes places.</em></h2></div><a class="button secondary" href="{{ route('collection') }}">See all achievements ↗</a></div>
    <div class="achievement-ticker" aria-label="Recent achievements">@foreach(array_slice($profile['achievements'], 0, 4) as $achievement)<span><b>{{ $achievement['year'] }}</b> {{ $achievement['title'] }} · {{ $achievement['event'] }}</span>@endforeach</div>
</section>

<section class="calculator-strip reveal"><div><p class="eyebrow">A SMALL TOOL FOR YOUR SEMESTER</p><h2>Count the progress.</h2><p>Two semesters, one quick average, zero spreadsheet drama.</p></div><a class="button secondary" href="{{ route('calculator.index') }}">Open calculator <span aria-hidden="true">↗</span></a></section>
@endsection
