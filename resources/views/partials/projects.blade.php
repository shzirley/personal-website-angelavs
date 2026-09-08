<div class="project-grid">
    @foreach($profile['projects'] as $slug => $project)
        <a class="project-card reveal" href="{{ route('projects.show', $slug) }}">
            <div class="project-cover">
                <span class="file-tag">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }} / PROJECT FILE</span>
                @if($project['image'])
                    <img src="{{ asset('images/projects/'.$project['image']) }}" alt="Preview of {{ $project['title'] }}" loading="lazy" width="600" height="400">
                @else
                    <div class="project-file-art" aria-hidden="true"><span class="giant-folder">▰</span><span>{{ strtolower(str_replace(' ', '-', $project['title'])) }}.app</span></div>
                @endif
            </div>
            <div class="project-info">
                <span class="eyebrow">{{ $project['category'] }}</span>
                <h3>{{ $project['title'] }} <span aria-hidden="true">↗</span></h3>
                <p>{{ $project['summary'] }}</p>
                <span class="project-role">{{ $project['role'] }}</span>
            </div>
        </a>
    @endforeach
</div>
