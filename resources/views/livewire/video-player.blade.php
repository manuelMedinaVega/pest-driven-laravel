<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    {{-- The whole world belongs to you. --}}
    <h3>{{ $video?->title }} ({{ $video->duration }}min)</h3>
    <p>{{ $video->description }}</p>
</div>
