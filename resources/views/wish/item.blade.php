<div class="tm-gallery-item category-{{ $wish->category_id }}">
    <figure class="effect-bubba">
        <img src="{{ asset('img/default_wish_image.png') }}" alt="{{ $wish->filename }}" class="img-fluid"/>
        <figcaption>
            <h4>{{ '' }}</h4>
            <p style="font-size: 12px">{{ \Illuminate\Support\Str::limit($wish->description, 30, $end='...') }}</p>
            <span><i class="fa fa-calendar"></i> : {{ $wish->deadline }} </span>
            {{--<a href="@if ($wish->link != null) {{ $wish->link }} @else {{ "#" }} @endif">Lien associé</a>--}}
        </figcaption>
    </figure>
</div>