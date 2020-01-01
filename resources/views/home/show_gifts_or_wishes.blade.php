<div class="tm-gallery" id="tmGallery">
    @foreach($elements as $element)
        <div class="tm-gallery-item category-1">
            <figure class="effect-bubba">
                <img
                        {{--TODO changer le contenu après les essais et mise en place d'ajout de souhait--}}
                        src="@if ($element->filename != null)
                        {{ ('img/default_wish_image.png') }}
                        @else
                        {{ ($element->filename) }}
                        @endif"
                        alt="Gallery item"
                        class="img-fluid"
                />
                <figcaption>
                    <h2>{{ $element->wishBoxTitle }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit($element->description, 30, $end=' (...)') }}</p>
                    <span><i class="fa fa-calendar"> Délai : </i> {{ $element->deadline }} </span>
                    {{--<a href="@if ($element->link != null) {{ $element->link }} @else {{ "#" }} @endif">Lien associé</a>--}}
                </figcaption>
            </figure>
        </div>
    @endforeach
</div>