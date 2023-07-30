@extends('layouts.ecommerce')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/product.css') }}">
    <style>
        .tooltips {
            position: relative;
            display: inline-block;
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        .tooltips:hover::before {
            content: attr(title);
            position: absolute;
            top: -50px;
            left: 0;
            background-color: #fff;
            color: #000;
            padding: 5px;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            white-space: nowrap;
        }
    </style>
@endsection



@section('content')
    {{-- <h2 class="display-6 text-center mb-4">Product</h2> --}}
    <div id="controller">
        <figure class="text-center">
            <blockquote class="blockquote">
                <p>Data Product</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                Product <cite title="Source Title"></cite>
            </figcaption>
        </figure>
        <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative">
            <div class="btn-toolbar justify-content-between mb-5" role="toolbar" aria-label="Toolbar with button groups">

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Category
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#" @click="clearFiltersN">
                                All</a>
                        </li>
                        @foreach ($categorys as $key)
                            <li><a class="dropdown-item" href="#"
                                    @click="categoryFilter = '{{ $key->name }}'; search = ''">
                                    {{ ucwords($key->name) }}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>

                <div class="input-group">

                    @if (Auth::check() && Auth::user()->is_admin)
                        <a href="{{ url('/add') }}" class="btn btn-outline-primary"> <i class="fas fa-plus"></i>
                            Add Product
                        </a>
                    @else
                        <div class="input-group-text" id="btnGroupAddon2"><i class="fas fa-search"></i></div>
                    @endif

                    <input type="text" class="form-control" placeholder="Search.." aria-label="Input group example"
                        aria-describedby="btnGroupAddon2" v-model="search" @click="clearFiltersN">
                </div>
            </div>

            <div class="d-flex align-items-center p-6" v-if="isLoading">
                <strong>Loading...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>

            <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">

                <div class="col hp" v-for="product in filteredList">

                    <div class="card h-100 shadow-sm">

                        <img :src="'/storage/' + product.image" class="card-img-top" alt="product.title" />


                        <div class="label-top shadow-sm">

                            <a class="text-white" href="#">@{{ product.category_id }}</a>
                        </div>

                        <div class="card-body">
                            <div class="clearfix mb-3">
                                <p class="text-center tooltips" :title="product.name">@{{ nameFormat(product.name) }}</p>
                                <hr>
                                <span class="float-start badge rounded-pill bg-success">@{{ formattedPrice(product.price) }}</span>


                            </div>

                            <h5 class="card-title">

                                <p v-html="renderHTML(product.description)"></p>

                            </h5>

                            <div class="d-grid gap-2 my-4">

                                <a :href="'{{ route('show_product', '') }}/' + product.id"
                                    class="btn btn-outline-dark rounded">Add To Cart</a>
                                @if (Auth::check() && Auth::user()->is_admin)
                                    {{-- /product/{product}/edit --}}
                                    <a :href="'{{ route('edit_product', '') }}/' + product.id"
                                        class="btn btn-primary btn-sm">Update</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        :data-bs-target="'#deleteModal' + product.id">Delete</button>
                                @endif

                            </div>
                        </div>
                    </div>
                    @foreach ($products as $product)
                        {{-- delete Modal --}}
                        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are You Sure, delete to Product <b>{{ $product->name }}</b>!
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('delete_product', $product) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary"> Delete Product</button>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Modal Delete --}}
                    @endforeach
                </div>

            </div>


        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var actionUrl = '{{ url('index_product') }}';
        // const updateUrl = '{{ route('update_product', ':id') }}';
        //variable global
        var apiUrl = '{{ url('api/product ') }}';
    </script>
    <script></script>
    <script src="{{ asset('js/product.js') }}"></script>
@endsection
