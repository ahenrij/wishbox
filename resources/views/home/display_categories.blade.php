<ul class="tabs clearfix filters-button-group">
    <li>
        <a href="#" class="active" data-filter="*">
            <div class="tm-tab-icon"></div>
            Toutes les catégories
        </a>
    </li>
    @foreach ($categories as $category)
        <li>
            <a href="#" class="" data-filter="{{ '.category-' . $category->id }}">
                <div class="tm-tab-icon"></div>
                {{ $category->title }}
            </a>
        </li>
    @endforeach
</ul>