@extends('layouts.ecommerce')

@section('css')
@endsection
@section('content')
    <div class="container text-center">
        <div class="p-2 ">
            <h2 class="display-7 text-center mb-4">Category
                <button type="button" class="btn btn-primary float-start" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <li class="fas fa-plus"></li> Add
                </button>
                <a href="{{ url('add') }}" type="button" class="btn btn-outline-dark float-end">Back</a>
            </h2>

        </div>
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Hello, world! This is a toast message.
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <hr>



        @if (session('success'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <div class="row">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($categorys as $key)
                        <tr>
                            <th scope="row">{{ $no++ }}.</th>
                            <td>{{ $key->name }}</td>
                            <td>
                                <a href="#" style="text-decoration: none;" data-bs-toggle="modal"
                                    data-bs-target="#update{{ $key->id }}">
                                    <li class="fas fa-pencil"></li>
                                </a>

                                <div class="modal fade" id="update{{ $key->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('update_category', $key->id) }}" method="post">
                                                @method('patch')
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" name="name"
                                                                id="floatingInputGrid" placeholder="name"
                                                                value="{{ $key->name }}">
                                                            <label for="floatingInputGrid">Category
                                                                Name </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                &nbsp;
                                <a href="#" data-bs-toggle="modal" data-bs-target="#delete{{ $key->id }}">
                                    <li class="fas fa-trash text-danger"></li>
                                </a>

                                <div class="modal fade" id="delete{{ $key->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('delete_category', $key->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="col-md">
                                                        Are You Sure, delete to Category <b>{{ $key->name }}</b>!

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Delete Category</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('store_category') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="name" id="floatingInputGrid"
                                    placeholder="name">
                                <label for="floatingInputGrid">Category Name </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
