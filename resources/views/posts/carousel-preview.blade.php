<div class="gallery-photos"  data-masonry='{"itemSelector": ".grid-item","columnWidth":464}'>
    @foreach ($post->photos->take(4) as $photo)
        <figure class="grid-item grid-item--height2">
            @if ($loop->iteration === 4)
                <div class="overlay">{{ $post->photos->count() }} Fotos</div>
            @endif
            <img class="img-responsive" src="{{ url($photo->url) }}" alt="">
        </figure>
    @endforeach
</div>