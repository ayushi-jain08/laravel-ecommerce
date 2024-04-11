@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="products.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form id="productForm" name="productForm">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" value="{{ $product->title }}"
                                                id="title" class="form-control" placeholder="Title">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" value="{{ $product->slug }}" name="slug" id="slug"
                                                readonly class="form-control" placeholder="Slug">
                                            <p class="error"></p>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Short Description</label>
                                            <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote"
                                                placeholder="Short_description"></textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                placeholder="Description">{{ $product->description }}</textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_return">Shipping and Returns</label>
                                            <textarea name="shipping_return" id="shipping_return" cols="30" rows="10" class="summernote"
                                                placeholder="shipping & returns"></textarea>
                                            <p class="error"></p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" width="50"
                                    alt="Product Image">
                            @endif
                            <p></p>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" value="{{ $product->price }}"
                                                id="price" class="form-control" placeholder="Price">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input value="{{ $product->compare_price }}" type="text" name="compare_price"
                                                id="compare_price" class="form-control" placeholder="Compare Price">
                                            <p class="error"></p>
                                            <span class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare
                                                at
                                                price. Enter a lower value into Price.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" value="{{ $product->sku }}"
                                                id="sku" class="form-control" placeholder="sku">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" value="{{ $product->barcode }}"
                                                id="barcode" class="form-control" placeholder="Barcode">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" value="No" name="track_qty">
                                                <input value="Yes" class="custom-control-input" type="checkbox"
                                                    id="track_qty" name="track_qty"
                                                    {{ $product->tract_qty == 'Yes' ? 'checked' : '' }}>

                                                <label for="track_qty" class="custom-control-label">Track
                                                    Quantity</label>
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty"
                                                value="{{ $product->qty }}" id="qty" class="form-control"
                                                placeholder="Qty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 card">
                            <div class="card-body">
                                <label class="h5 mb-3">Related product</label>
                                <div class="mb-3">
                                    <select multiple name="related_products[]" id="related_products"
                                        class="related-product w-100 text-black">
                                        @if (!empty($relatedProducts))
                                            @foreach ($relatedProducts as $relatedProduct)
                                                <option selected value="{{ $relatedProduct->id }}">
                                                    {{ $relatedProduct->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $product->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $product->status == 0 ? 'selected' : '' }} value="0">Block
                                        </option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{ $product->category_id == $category->id ? 'selected' : '' }}
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select a Sub Category</option>
                                        @foreach ($subCategories as $subCategory)
                                            <option {{ $product->sub_category_id == $subCategory->id ? 'selected' : '' }}
                                                value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select a Brand</option>
                                        @if ($brand->isNotEmpty())
                                            @foreach ($brand as $brands)
                                                <option {{ $product->brand_id == $brands->id ? 'selected' : '' }}
                                                    value="{{ $brands->id }}">{{ $brands->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="feature" id="feature" class="form-control">
                                        <option {{ $product->is_featured == 'Yes' ? 'selected' : '' }} value="Yes">Yes
                                        </option>
                                        <option {{ $product->is_featured == 'No' ? 'selected' : '' }} value="No">No
                                        </option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Create</button>
                    <a href="{{ route('product.get') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
@section('customJs')
    <script>
        $('.related-product').select2({
            ajax: {
                url: '{{ route('get.product') }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function(data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });
        $(document).ready(function() {
            $('#title').change(function() {
                var element = $(this)
                $.ajax({
                    url: "{{ route('getSlug') }}",
                    type: "get",
                    data: {
                        title: element.val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response['status'] == true) {
                            $('#slug').val(response['slug'])
                        }
                        console.log(response)
                    },
                });
            });
            $('#productForm').submit(function(e) {
                e.preventDefault();
                $("button[type=submit]").prop('disabled', true)
                var formData = new FormData(this);
                console.log(formData);
                $.ajax({
                    url: "{{ route('product.update', $product->id) }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // window.location.href = "{{ route('product.get') }}"

                    },
                    error: function(jqXHR, exception) {
                        if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                            var errors = jqXHR.responseJSON.errors;
                            $('.error').removeClass('is-invalid').html("")
                            $("input[type=text], select").removeClass('is-invalid')
                            $.each(errors, function(key, value) {
                                $(`#${key}`).addClass('is-invalid').closest('.mb-3')
                                    .find('p')
                                    .addClass('invalid-feedback').html(value);
                            })
                        }
                    }
                })

            })
            $('#category').change(function() {
                var category_id = $(this).val();
                $.ajax({
                    url: "{{ route('product-subcategories.get') }}",
                    type: "GET",
                    data: {
                        category_id: category_id
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#sub_category').find('option').not(":first").remove();

                        $.each(response['subCategories'], function(key, item) {
                            $("#sub_category").append(
                                `<option value='${item.id}'>${item.name}</option>`)
                        })

                    },
                    error: function() {
                        console.log('Something Went Wrong')
                    }

                })
            })

        })
    </script>
@endsection
