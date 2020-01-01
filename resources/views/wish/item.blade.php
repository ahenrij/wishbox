<div class="tm-gallery-item category-{{ $wish->category_id }}" onclick="location.href='{{ route('wish.show', $wish->id) }}'">
    <figure class="effect-bubba">
        <img src="{{ asset('img/default_wish_image.png') }}" alt="{{ $wish->filename }}" class="img-fluid"/>
        <figcaption>
            <h4>{{ $wish->title }}</h4>
            <p style="font-size: 12px">{{ \Illuminate\Support\Str::limit($wish->description, 30, $end='...') }}</p>
            <span><span uk-icon="icon: @if($wish->user_id != null) check @else close @endif; ratio: .7"></span></span>
            {{--<a href="@if ($wish->link != null) {{ $wish->link }} @else {{ "#" }} @endif">Lien associé</a>--}}
        </figcaption>
    </figure>
</div>