@extends('layouts.ecommerce')
@section('css')
@endsection
@section('content')
    @php
        $total_price = 0;
    @endphp

    <section class=" row py-5 p-4 bg-white rounded shadow-sm mb-2">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center">Shopping Cart</h3>
                    <p class="mb-5 text-center">
                        <i class="text-dark font-weight-bold">{{ getTotalCartByUserId($userId = Auth::id()) }}</i> items in
                        your cart
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('danger'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('danger') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($carts->isNotEmpty())
                        <table id="shoppingCart" class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th style="width:40%">Product</th>
                                    <th style="width:20%">Price</th>
                                    <th style="width:15%">Option</th>
                                    <th style="width:10%">Quantity</th>

                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                {{-- <div class="col-md-5 text-left">
                                                    <img src="{{ url('storage/' . $cart->product->image) }}" alt=""
                                                        class="img-fluid d-none d-md-block rounded mb-3 shadow ">
                                                </div> --}}
                                                <div class="col-md-9 text-left mt-sm-2">
                                                    <h4>{{ $cart->product->name }}</h4>
                                                    <p class="font-weight-light">Category :
                                                        <span class="badge text-bg-danger">
                                                            {{ nameCategory($cart->product->category_id) }}
                                                        </span>

                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">{{ price($cart->product->price) }}</td>
                                        <td data-th="Size"><span
                                                class="badge rounded-pill bg-warning text-dark">{{ getOptional($cart->optional) }}</span>
                                        </td>
                                        <td data-th="Quantity">
                                            <form action="{{ route('update_cart', $cart) }}" method="post">
                                                @method('patch')
                                                @csrf
                                                <input type="hidden" name="productId" value="{{ $cart->product_id }}">
                                                <input type="hidden" name="stockId" value="{{ $cart->optional }}">
                                                <input type="number" class="form-control form-control-lg text-center"
                                                    value="{{ $cart->amount }}" name="amount">
                                                <button type="submit"
                                                    class="btn btn-outline-success btn-sm mb-2 float-end mt-1">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                            </form>
                                        </td>

                                        <td class="actions" data-th="">
                                            <div class="float-end">

                                                <form action="{{ route('delete_cart', $cart) }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fas fa-delete sm-2">X</i></button>
                                                </form>



                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $total_price += $cart->product->price * $cart->amount;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>

            <div class="row mt-4 d-flex align-items-center">
                <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                    <a href="{{ route('index_product') }}">
                        <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>





    <div class="row py-5 p-4 bg-white rounded shadow-sm">
        <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Address</div>
            <div class="p-4">
                <p class="font-italic mb-4">Alamat Pengiriman :</p>
                <p class="font-italic mb-4">{{ $cart->user->alamat }}</p>
                <p class="font-italic mb-4">No Telp :</p>
                <p class="font-italic mb-4">{{ $cart->user->telp }}</p>
                <p class="font-italic mb-4"><a href="#" data-bs-toggle="modal"
                        data-bs-target="#exampleModal{{ $cart->user->id }}">
                        <span class="fas fa-edit"></span>
                    </a></p>


                <div class="modal fade" id="exampleModal{{ $cart->user->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Address</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="{{ route('update_profile', $cart->user->id) }}" method="post">
                                @csrf
                                <div class="modal-body">

                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="updateProfileCart" value="yes" id="">

                                        <input type="hidden" name="name" value="{{ $cart->user->name }}">
                                        <input type="hidden" name="email" value="{{ $cart->user->email }}">

                                        <input type="text" name="telp" class="form-control" id="floatingInput"
                                            placeholder="08xxx" value="{{ $cart->user->telp }}">
                                        <label for="floatingInput">
                                            @if ($cart->user->telp == null)
                                                Number your telephone
                                            @else
                                                {{ $cart->user->telp }}
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-floating">
                                        <textarea class="form-control" name="alamat" placeholder="Leave a comment here" id="floatingTextarea2"
                                            style="height: 100px">{{ $cart->user->alamat }}</textarea>
                                        <label for="floatingTextarea2">
                                            @if ($cart->user->alamat == null)
                                                Address
                                            @else
                                                {{ $cart->user->alamat }}
                                            @endif

                                        </label>
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


            </div>
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for
                seller
            </div>

            <form action="{{ route('checkouts') }}" method="post" class="text-end">
                <div class="p-4">
                    <p class="font-italic mb-4">Jika Anda memiliki beberapa informasi untuk penjual, Anda dapat
                        meninggalkannya di kotak di bawah ini</p>
                    <textarea name="comment" cols="30" rows="2" class="form-control"></textarea>
                </div>
        </div>

        <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary
            </div>
            <div class="p-4">
                <p class="font-italic mb-4">Pengiriman dan biaya tambahan dihitung berdasarkan nilai yang
                    telah
                    Anda masukkan.</p>
                <ul class="list-unstyled mb-4">
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order
                            Subtotal
                        </strong><strong>{{ price($total_price) }}</strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping
                            and handling</strong><strong>Rp. 0,00</strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                            class="text-muted">Tax</strong><strong>Rp. 0,00</strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong
                            class="text-muted">Total</strong>
                        <h5 class="font-weight-bold">{{ price($total_price) }}</h5>
                    </li>
                </ul>

                @csrf
                <button type="submit" class="btn btn-dark rounded-pill py-2 btn-block ">Procceed to
                    checkout</button>
                </form>

            </div>
        </div>
    </div>
    @endif
@endsection
