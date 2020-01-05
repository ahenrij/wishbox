<ul class="tabs clearfix filters-button-group">
    <li>
        <a href="#" class="active text-secondary" data-filter="*">
            <div class="tm-tab-icon"></div>
            Toutes les catégories
        </a>
    </li>
    @foreach ($categories as $category)
        <li>
            <a href="#" class="text-secondary" data-filter="{{ '.category-' . $category->id }}">
                <div class="tm-tab-icon"></div>
                {{ substr($category->title, 0, 20) }}
            </a>
        </li>
    @endforeach
</ul>