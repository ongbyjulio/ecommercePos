<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mb-3 text-center">
    <div class="card mb-4" style="width: 18rem;" v-for="product in filteredList">
        <img :src="'/storage/' + product.image" class="card-img-top" alt="..." height="200px">
        <div class="card-body">

            <h4 class="my-0 fw-normal">@{{ product.name }}</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                card's
                content.</p>

            <div class="d-grid gap-2 col-6 mx-auto">
                <a :href="'{{ route('show_product', '') }}/' + product.id"
                    class="btn btn-outline-success btn-sm rounded">Show</a>
                @if (Auth::check() && Auth::user()->is_admin)
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    :data-bs-target="'#modalupdate' + product.id">Update</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    :data-bs-target="'#deleteModal' + product.id">Delete</button>
                @endif
            </div>
        </div>

        @foreach ($products as $product)
        {{-- Update modal --}}
        <div class="modal fade" id="modalupdate{{ $product->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Product</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <form action="{{ route('update_product', $product) }}" method="post"
                                enctype="multipart/form-data">
                                @method('patch')
                                @csrf

                                <div class="mb-3 row">
                                    <label for="name" class="col-sm-2 col-form-label text-start">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ $product->name }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="description" class="col-sm-2 col-form-label text-start">Descrip..
                                        &nbsp;</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="description" id="description" class="form-control"
                                            value="{{ $product->description }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="price" class="col-sm-2 col-form-label text-start">Price</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="price" id="price" class="form-control"
                                            value="{{ $product->price }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="stock" class="col-sm-2 col-form-label text-start">Stock</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="stock" id="stock" class="form-control"
                                            value="{{ $product->stock }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="image" class="col-sm-2 col-form-label text-start">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3 text-start">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                                        aria-label="">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                    <div class="modal-footer">
                        *Product
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal Update --}}

        {{-- delete Modal --}}
        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are You Sure, delete to Product <b>{{ $product->name }}</b>!
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('delete_product', $product) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> Delete Product</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal Delete --}}
        @endforeach

    </div>



    {{-- Add modal --}}
    <div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <form action="{{ route('store_product') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label text-start">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="description" class="col-sm-2 col-form-label text-start">Descrip..
                                    &nbsp;</label>
                                <div class="col-sm-10">
                                    <input type="text" name="description" id="description" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="price" class="col-sm-2 col-form-label text-start">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" name="price" id="price" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="stock" class="col-sm-2 col-form-label text-start">Stock</label>
                                <div class="col-sm-10">
                                    <input type="number" name="stock" id="stock" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="image" class="col-sm-2 col-form-label text-start">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 text-start">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                                    aria-label="">Close</button>
                            </div>

                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    *Product
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Add --}}

</div>


--cart
<div class="row">
    @foreach ($carts as $cart)
    <div class="card m-3 " style="width: 18rem;">
        <img src="{{ url('storage/' . $cart->product->image) }}" class=" mt-4" alt="..." height="140px">
        <div class="card-body text-center">
            <h5 class="card-title ">{{ $cart->product->name }}</h5>
            <p class="card-text">Amount : {{ $cart->amount }}</p>
            <hr>

            <form action="{{ route('update_cart', $cart) }}" method="post">
                @method('patch')
                @csrf
                <div class="input-group mb-3">
                    <input type="number" name="amount" value="{{ $cart->amount }}" class="form-control">
                    <button type="submit" class="btn btn-primary"><i
                            class="fas fa-shopping-cart me-2"></i>Update</button>
                </div>
            </form>
            <form action="{{ route('delete_cart', $cart) }}" method="post">
                @method('delete')
                @csrf
                <div class="input-group mb-3 justify-content-end">
                    <button type="submit " class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                </div>
            </form>

        </div>
    </div>
    @php
    $total_price += $cart->product->price * $cart->amount;
    @endphp
    @endforeach
    <p class="h5 m-2 text-danger text-end"><b>{{ price($total_price) }} </b></p>
    <hr>
    @if ($carts->isNotEmpty())
    <form action="{{ route('checkouts') }}" method="post" class="text-end">
        @csrf
        <button type="submit" class="btn btn-outline-success ">Checkout</button>
    </form>
    @else
    <p class="text-muted">Cart Kosong...</p>
    @endif
</div>