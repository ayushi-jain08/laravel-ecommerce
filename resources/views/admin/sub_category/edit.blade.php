@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('sub-category.get') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" id="subCategoryForm" name="subCategoryForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{ $subcategory->category_id == $category->id ? 'selected' : '' }}
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{ $subcategory->name }}" id="name"
                                        class="form-control" placeholder="Name">
                                    <p></p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" value="{{ $subcategory->slug }}" id="slug"
                                        class="form-control" placeholder="Slug">
                                    <p></p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $subcategory->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $subcategory->status == 0 ? 'selected' : '' }} value="0">Block
                                        </option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Show on Home</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option {{ $subcategory->showHome == 'Yes' ? 'selected' : '' }} value="Yes">Yes
                                        </option>
                                        <option {{ $subcategory->showHome == 'No' ? 'selected' : '' }} value="No">No
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="subcategory.html" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
@section('customJs')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#subCategoryForm').submit(function(e) {
                e.preventDefault();
                $("button[type=submit]").prop('disabled', true)
                var element = $(this)
                $.ajax({
                    url: "{{ route('sub-category.update', $subcategory->id) }}",
                    type: "PUT",
                    data: element.serializeArray(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        window.location.href = "{{ route('sub-category.get') }}"
                        element.trigger('reset');

                    },
                    error: function(jqXHR, exception) {
                        if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                            var errors = jqXHR.responseJSON.errors;
                            console.log('something went wrong')
                            if (errors['name']) {
                                $("#name").addClass('is-invalid').closest('.mb-3').find('p')
                                    .addClass('invalid-feedback').html(errors['name'][0]);
                                console.log(errors['name'][0])
                            } else {
                                $("#name").removeClass('is-invalid').closest('.mb-3').find('p')
                                    .removeClass('invalid-feedback').html("");
                            }

                            if (errors['slug']) {
                                $("#slug").addClass('is-invalid').closest('.mb-3').find('p')
                                    .addClass('invalid-feedback').html(errors['slug'][0]);
                            } else {
                                $("#slug").removeClass('is-invalid').closest('.mb-3').find('p')
                                    .removeClass('invalid-feedback').html("");
                            }
                        }
                    }
                })

            })
            $('#name').change(function() {
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
        });
    </script>
@endsection
