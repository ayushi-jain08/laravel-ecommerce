@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $key => $category)
                                            @if ($category->sub_category->isNotEmpty())
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne-{{ $key }}"
                                                        aria-expanded="false" aria-controls="collapseOne">
                                                        {{ $category->name }}
                                                    </button>
                                                </h2>
                                            @else
                                                <a href="{{ route('front.shop', $category->slug) }}"
                                                    class="nav-item nav-link {{ $categorySelected == $category->id ? 'text-primary' : '' }}">{{ $category->name }}</a>
                                            @endif
                                            @if ($category->sub_category->isNotEmpty())
                                                <div id="collapseOne-{{ $key }}"
                                                    class="accordion-collapse collapse {{ $categorySelected == $category->id ? 'show' : '' }}"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample"
                                                    style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach ($category->sub_category as $subCategory)
                                                                <a href="{{ route('front.shop', [$category->slug, $subCategory->slug]) }}"
                                                                    class="nav-item nav-link {{ $subCategorySelected == $subCategory->id ? 'text-primary' : '' }}">{{ $subCategory->name }}</a>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if ($brands->isNotEmpty())
                                @foreach ($brands as $brand)
                                    <div class="form-check mb-2">
                                        <input {{ in_array($brand->id, $brandsArray) ? 'checked' : '' }}
                                            class="form-check-input brand-label" type="checkbox"
                                            value="{{ $brand->id }}" name="brand[]" id="brand-{{ $brand->id }}">
                                        <label class="form-check-label" for="brand-{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                                        <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Price High
                                        </option>
                                        <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Price Low
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if ($products->isNotEmpty())
                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            <a href="{{ route('front.product', $product->slug) }}" class="product-img"><img
                                                    class="card-img-top" src="{{ asset('storage/' . $product->image) }}"
                                                    alt="img"></a>
                                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                            <div class="product-action">
                                                <button class="btn btn-dark"
                                                    onclick="AddToCartProduct({{ $product->id }})">
                                                    <i class="fa fa-shopping-cart"></i> ppAdd To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body text-center mt-3">
                                            <a class="h6 link" href="product.php">{{ $product->title }}</a>
                                            <div class="price mt-2">
                                                <span class="h5"><strong>{{ $product->price }}</strong></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="col-md-12 pt-5">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        function AddToCartProduct(id) {

            var quantity = 1;
            $.ajax({
                url: "{{ route('add.cart') }}",
                type: "Post",
                data: {
                    product_id: id,
                    quantity: 1,
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Check if the response has a 'status' key
                    if (response && response.status) {

                        alert(response.message);
                    } else {
                        // Handle unexpected success response
                        console.log('Unexpected success response:', response);
                    }
                },
                error: function(jqXHR, exception) {
                    // Handle error response
                    console.log('Something went wrong:', jqXHR.responseText);
                }
            })
        }
        rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: 'double',
            min: 0,
            max: 1000,
            from: {{ $priceMin }},
            step: 10,
            to: {{ $priceMax }},
            skin: 'round',
            max_postfix: "+",
            prefix: "$",
            onFinish: function() {
                apply_filters()
            }
        })

        var slider = $(".js-range-slider").data("ionRangeSlider");
        $('.brand-label').change(function() {
            apply_filters()
        })
        $('#sort').change(function() {
            apply_filters()
        })

        function apply_filters() {
            var brands = [];
            $('.brand-label').each(function() {
                if ($(this).is(':checked') == true) {
                    brands.push($(this).val())
                }
            })
            var url = '{{ url()->current() }}?';
            // BRAND FILTER
            if (brands.length > 0) {
                url += '&brand=' + brands.toString()
            }
            // PRICE RANGE FILTER
            url += '&price_min=' + slider.result.from + '&price_max=' + slider.result.to;

            // SORTING FILTER
            url += '&sort=' + $("#sort").val()
            window.location.href = url;

        }
    </script>
@endsection
