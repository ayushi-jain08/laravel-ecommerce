@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="brands.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form name="brandForm" id="brandForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button class="btn btn-primary">Create</button>
                            <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
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
            $('#brandForm').submit(function(e) {
                e.preventDefault();
                $("button[type=submit]").prop('disabled', true)
                var element = $(this)
                $.ajax({
                    url: "{{ route('brand.store') }}",
                    type: "POST",
                    data: element.serializeArray(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        window.location.href = "{{ route('brand.get') }}"
                        element.trigger('reset');
                    },
                    error: function(jqXHR, exception) {
                        if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                            var errors = jqXHR.responseJSON.errors;
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
