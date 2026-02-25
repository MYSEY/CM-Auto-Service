<div class="product-card product_items">
    <article class="single_product">
        <figure>
            {{--  <div class="product-image-wrapper product_thumb">
                <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                    <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name ?? '' }}">
                </a>
                <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                    <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name ?? '' }}">
                </a>
            </div>  --}}

            <div class="product-image-wrapper product_thumb">
                <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                    {{-- កែត្រង់ src នេះ --}}
                    <img src="https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/{{ $item->product_photo }}" alt="{{ $item->category->name ?? '' }}">
                </a>
                <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                    <img src="https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/{{ $item->product_photo }}" alt="{{ $item->category->name ?? '' }}">
                </a>
            </div>
            <div class="product_content">
                <div class="product_content_inner">
                    <div class="category"><a href="#">Parts</a></div>
                    <div class="category"><a href="#">{{ $item->productType->name ?? '' }}</a></div>
                    <h4 class="product-name">
                        <a href="{{ url('frontend/product/detail',$item->id) }}">
                            {{ $item->category->name ?? '' }} {{ $item->subCategory->name ?? '' }} {{$item->year}} {{ $item->proEngine?->name ?? '' }} {{ $item->proEngine?->part_number ?? ''}}
                        </a>
                    </h4>
                    <div class="price_box">
                        <span class="current_price price-original">${{ number_format($item->price,2) }} {{$item->number}}</span>
                    </div>
                </div>
                <div class="action_links">
                    <ul>
                        <li class="add_to_cart addToCart" data-id="{{ $item->id }}">
                            <a href="javascript:void(0)" title="Add to cart">Add to cart</a>
                        </li>
                    </ul>
                </div>
            </div>
        </figure>
    </article>
</div>

{{-- @foreach($product as $key => $item)
    <div class="product-card product_items">
        <article class="single_product">
            <figure>
                <div class="product-image-wrapper product_thumb">
                    <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                        <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name ?? '' }}">
                    </a>
                    <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                        <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name ?? '' }}">
                    </a>
                </div>
                <div class="product_content">
                    <div class="product_content_inner">
                        <div class="category"><a href="#">Parts</a></div>
                        <div class="category"><a href="#">{{$item->productType->name ?? ''}}</a></div>
                        <h4 class="product-name"><a href="{{ url('frontend/product/detail',$item->id) }}">{{ $item->category->name ?? '' }} {{ $item->subCategory->name ?? '' }} ​{{$item->year}}  {{ $item->proEngine?->name ?? '' }}  {{ $item->proEngine?->part_number ?? ''}} </a></h4>
                        <div class="product_rating">
                        </div>

                        <div class="price_box">
                            <span class="current_price price-original"> ${{ number_format($item->price,2) }} {{$item->number}}</span>
                        </div>
                    </div>
                    <div class="action_links">
                        <ul>
                            <li class="add_to_cart addToCart" data-id="{{ $item->id }}">
                                <a href="javascript:void(0)" title="Add to cart">Add to cart</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </figure>
        </article>
    </div>
@endforeach --}}


{{-- @foreach($productType as $key => $type)
    <div class="tab-pane fade" id="{{ Str::slug($type->name) }}" role="tabpanel">
        <div class="row">
            <div class="product-grid-container">
                @foreach($productsByType[$type->id] as $item)
                    <div>
                        <div class="product-card product_items">
                            <article class="single_product">
                                <figure>
                                    <div class="product-image-wrapper product_thumb">
                                        <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                                            <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name ?? '' }}">
                                        </a>
                                        <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                                            <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name ?? '' }}">
                                        </a>
                                    </div>
                                    <div class="product_content">
                                        <div class="product_content_inner">
                                            <p class="category"><a href="#">Parts</a></p>
                                            <p class="category"><a href="#">{{ $item->productType->name }}</a></p>
                                            <h4 class="product-name">
                                                <a href="{{ url('frontend/product/detail',$item->id) }}">
                                                    {{ $item->category->name ?? '' }}
                                                    {{ $item->subCategory->name ?? '' }}
                                                    {{ $item->year }}
                                                    {{ $item->proEngine?->name ?? '' }}
                                                    {{ $item->proEngine?->part_number ?? '' }}
                                                </a>
                                            </h4>
                                            <div class="product_rating"></div>
                                            <div class="price_box">
                                                <span class="current_price price-original">
                                                    ${{ number_format($item->price,2) }} {{ $item->number }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="action_links">
                                            <ul>
                                                <li class="add_to_cart addToCart" data-id="{{ $item->id }}">
                                                    <a href="javascript:void(0)" title="Add to cart">Add to cart</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </figure>
                            </article>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="shop_toolbar t_bottom">
            <div class="pagination">
                <ul>
                    @if ($productsByType[$type->id]->onFirstPage())
                        <li class="disabled"><span><<</span></li>
                    @else
                        <li><a href="{{ $productsByType[$type->id]->previousPageUrl() }}"><</a></li>
                    @endif

                    @foreach ($productsByType[$type->id]->getUrlRange(1, $productsByType[$type->id]->lastPage()) as $page => $url)
                        @if ($page == $productsByType[$type->id]->currentPage())
                            <li class="current">{{ $page }}</li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($productsByType[$type->id]->hasMorePages())
                        <li class="next"><a href="{{ $productsByType[$type->id]->nextPageUrl() }}">next</a></li>
                        <li><a href="{{ $productsByType[$type->id]->url($productsByType[$type->id]->lastPage()) }}">>></a></li>
                    @else
                        <li class="disabled"><span>next</span></li>
                        <li class="disabled"><span>>></span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endforeach --}}
