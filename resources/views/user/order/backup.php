<!-- 

<div class="modal fade" :id="'modalshow' + product.id" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Show Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">@{{ product.name }}</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">
                                <small class="text-muted fw-light">Rp.</small>@{{ product.price }}
                            </h1>
                            <p>
                                Description : <br>
                                @{{ product.description }}
                            </p>
                            <template v-if="!isUserAdmin">
                                <hr>
                                <form :action="'{{ route('add_to_cart', '') }}' + product.id" method="post">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="number" name="amount" value="1" class="form-control">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fas fa-shopping-cart me-2"></i>Add to Cart</button>
                                    </div>
                                </form>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                *Product
            </div>
        </div>
    </div>
</div> -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="border-0 bg-light">
                    <div class="p-2 px-3 text-uppercase">Product</div>
                </th>
                <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Price</div>
                </th>
                <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Quantity</div>
                </th>
                <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Action</div>
                </th>
                {{-- <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Action</div>
                </th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($carts as $cart)
            <tr>
                <th scope="row" class="border-0">
                    <div class="p-2">
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
                            {{-- <img src="{{ url('storage/' . $cart->product->image) }}" alt="" width="70"
                            class="img-fluid rounded shadow-sm"> --}}
                            <div class="ml-md-3 mt-2 mt-md-0">
                                <h5 class="mb-0"> <a href="#" class="text-dark align-middle"
                                        style="text-decoration: none">&nbsp;{{ $cart->product->name }}</a>
                                </h5>
                                {{-- <span class="text-muted font-weight-normal font-italic d-block">Category:
                                    Watches</span> --}}
                            </div>
                        </div>




                    </div>

                </th>

                <td class="border-0 align-middle">
                    <strong>{{ price($cart->product->price) }}</strong>
                </td>
                <td class="border-0 align-middle"><strong>{{ $cart->amount }}</strong></td>

                {{-- <td class="border-0 align-middle">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <form action="{{ route('update_cart', $cart) }}" method="post"
                class="d-flex mb-2 mb-md-0 col-md-8">
                @method('patch')
                @csrf
                <input type="number" name="amount" value="{{ $cart->amount }}" class="form-control">
                <button type="submit" class="btn btn-primary btn-sm ms-2"><i
                        class="fas fa-shopping-cart me-2"></i>Update</button>
                </form>
                <form action="{{ route('delete_cart', $cart) }}" method="post" class="col-md-4">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm ms-2"><i class="fas fa-trash  me-2"
                            class="form-control"></i>Delete</button>
                </form>
</div>
</td> --}}
<td class="border-0 align-middle">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
        <form action="{{ route('update_cart', $cart) }}" method="post" class="d-flex mb-2 mb-md-0">
            @method('patch')
            @csrf
            <div class="input-group col-md-8">
                <input type="number" name="amount" value="{{ $cart->amount }}" class="form-control">
                <button type="submit" class="btn btn-primary btn-sm ms-2"><i
                        class="fas fa-shopping-cart me-2"></i>Update</button>
            </div>
        </form>
        <form action="{{ route('delete_cart', $cart) }}" method="post" class="col-md-6">
            @method('delete')
            @csrf
            &nbsp;
            <button type="submit" class="btn btn-outline-danger btn-sm mt-2 mt-md-0"><i
                    class="fas fa-trash me-2"></i>Delete</button>
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





@extends('layouts.ecommerce')
@section('content')
@php
$total_price = 0;
@endphp
<table class="table">
    <thead>
        <tr>
            <th scope="col">OrderID</th>
            <th scope="col">User</th>
            <th scope="col">Payment</th>
            <th scope="col">Order Date</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <th scope="row">{{ $order->id }}</th>
            <td>{{ $order->user->name }}</td>
            <td>
                @if ($order->is_paid == true)
                <span class="badge text-bg-info">Paid</span>
                @else
                <span class="badge text-bg-dark">Unpaid</span>
                @if ($order->payment_receipt)
                | <a href="{{ url('storage/' . $order->payment_receipt) }}">
                    <i class="fas fa-eye"></i>
                </a>
                @endif
                @endif

            </td>
            <td>{{ $order->created_at }}</td>
            <td>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modaldetail{{ $order->id }}">Show</button>
                    @if ($order->is_paid == false && Auth::user()->is_admin)
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalConfirm{{ $order->id }}">Confirm</button>
                    @endif
                </div>

                {{-- detail modal --}}
                <div class="modal fade" id="modaldetail{{ $order->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Show Order</h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="m2 text-md-end">

                                    Order by : <b>{{ $order->user->name }}/{{ $order->id }}</b>

                                </div>
                                <hr>
                                @foreach ($order->transactions as $transaction)
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-12 col-xl-10">
                                        <div class="card shadow-0 border rounded-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                                        <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                                            <img src="{{ url('storage/' . $transaction->product->image) }}"
                                                                class="w-100" />
                                                            <a href="#!">
                                                                <div class="hover-overlay">
                                                                    <div class="mask"
                                                                        style="background-color: rgba(253, 253, 253, 0.15);">
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xl-6">
                                                        <h5>{{ $transaction->product->name }}</h5>

                                                        <span>{{ $transaction->amount }}</span>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $total_price += $transaction->product->price * $transaction->amount;
                                @endphp
                                @endforeach
                                <hr>
                                @if ($order->is_paid == false && $order->payment_receipt == null)
                                <form action="{{ route('submit_payment_receipt', $order) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label for="payment_receipt" class="text-md mb-1">
                                        Upload Your Payment
                                        Receipt</label>
                                    <div class="row mb-3">

                                        <div class="col">
                                            <div class="input-group">
                                                <input type="file" name="payment_receipt" id="payment_receipt"
                                                    class="form-control">
                                                <button type="submit" class="btn btn-outline-success">Submit
                                                    Payment</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>



                            <div class="modal-footer">
                                <p>Total Rp. {{ $total_price }} &nbsp;</p>
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                                    aria-label="Close">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- end edtail modal --}}
                confirm_payment....
                <div class="modal fade" id="modalConfirm{{ $order->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                Konfirmasi pembayaran user <b>{{ $order->user->name }}</b>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('confirm_payment', $order) }}" method="post">
                                    @csrf
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"> Confirm</button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>


            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection



Cart


{{-- Add modal --}}
{{-- <div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
    <label for="name" class="col-sm-2 col-form-label text-start">Category</label>
    <div class="col-sm-10">
        <input type="text" name="name" id="name" class="form-control">
    </div>
</div>


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
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="">Close</button>
</div>

</form>

</div>
</div>
<div class="modal-footer">
    *Product
</div>
</div>
</div>
</div> --}}
{{-- End Modal Add --}}
const _this = this;
axios
.get(apiUrl)
.then((response) => {
_this.products = response.data;
_this.isLoading = false;
})
.catch((error) => {
console.log(error);
_this.isLoading = false;
});



filteredName() {
return this.products.filter((product) => {
return product.name
.toLowerCase()
.includes(this.search.toLowerCase());
});
},
filterByCategory(product) {
return this.products.filter((product) => {
return product.category_id
.toLowerCase()
.includes(this.search.toLowerCase());
});
},



$products = Product::all();
$datatables = datatables()->of($products)
->addColumn('name_category', function ($product) {
return nameCategory($product->category_id);
})
->addIndexColumn();

return response()->json($datatables->make(true));

const _this = this;
$.ajax({
url: apiUrl,
method: "GET",
success: function (data) {
_this.products = JSON.parse(data);
_this.isLoading = false;
},
error: function (error) {
console.log(error);
_this.isLoading = false;
},
});

// if ($request->id_stocks == null) {
// $existing_cart = Cart::where('product_id', $product_id)
// ->where('user_id', $user_id)
// ->first();

// } else {
// $existing_cart = Cart::where('product_id', $product_id)
// ->where('user_id', $user_id)
// ->where('optional', $request->id_stocks)
// ->first();
// }

Smartphone XYZ-2000 adalah perangkat canggih yang menghadirkan berbagai fitur hebat untuk memenuhi kebutuhan Anda.
Dengan desain modern dan performa yang andal, smartphone ini merupakan pilihan tepat untuk aktifitas sehari-hari dan
hiburan.

Spesifikasi:

Layar: 6.5 inci Super AMOLED dengan resolusi Full HD+
Prosesor: Octa-core 2.5 GHz
RAM: 8 GB
Penyimpanan: 128 GB (dapat diperluas dengan kartu microSD hingga 512 GB)
Kamera Belakang: 48 MP + 8 MP + 2 MP + 2 MP
Kamera Depan: 16 MP
Baterai: 4000 mAh dengan pengisian cepat
Harga: Rp 3.999.000,00

Ulasan:
Smartphone XYZ-2000 mendapatkan banyak ulasan positif dari para pengguna. Mereka mengapresiasi kualitas kamera yang
menakjubkan, performa yang cepat, dan baterai yang tahan lama. Produk ini juga mendapat pujian atas desainnya yang
elegan dan layar yang tajam.

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
                    <form action="{{ route('update_product', $product) }}" method="post" enctype="multipart/form-data">
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



Menu Pembayaran :

<form class="needs-validation" novalidate>
    <div class="alert alert-warning" role="alert">
        Jika anda belum melakukan pembayaran, silahkan melakukan pembayaran dan pilih metode
        pembayaran dibawah ini.</div>
    <h4 class="mb-3">Payment</h4>
    <div id="app">
        <div class="my-3">
            <div class="form-check">
                <input id="credit" name="paymentMethod" type="radio" class="form-check-input" value="tf"
                    v-model="paymentMethod" required>
                <label class="form-check-label" for="credit">Transfer</label>
            </div>
            <div class="form-check">
                <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" value="paypal"
                    v-model="paymentMethod" required>
                <label class="form-check-label" for="paypal">PayPal</label>
            </div>
        </div>

        <div class="row gy-3">
            <div v-if="paymentMethod === 'tf'">
                <div class="card text-white bg-warning mb-4 ">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title font-monospace fs-4">Metode Pembayaran:
                                Transfer</h5>
                            <hr>


                            <table class="fw-bolder font-monospace p-3 ">
                                <tr>
                                    <td>Bank</td>
                                    <td>:</td>
                                    <td>Mandiri</td>
                                </tr>
                                <tr>
                                    <td>Rekening</td>
                                    <td>:</td>
                                    <td>12345678</td>
                                </tr>
                                <tr>
                                    <td>A.n</td>
                                    <td>:</td>
                                    <td>Ongky</td>
                                </tr>
                            </table>
                        </center>



                    </div>
                </div>

                <!-- Konten untuk metode pembayaran Transfer -->
            </div>
            <div v-else-if="paymentMethod === 'paypal'">
                <div class="card text-white bg-info mb-4">

                    <div class="card-body">
                        <center>
                            <h5 class="card-title font-monospace fs-4">Metode Pembayaran: Paypal
                            </h5>
                            <hr>


                            <table class="fw-bolder font-monospace p-3 ">
                                <tr>
                                    <td>Bank</td>
                                    <td>:</td>
                                    <td>Mandiri</td>
                                </tr>
                                <tr>
                                    <td>Rekening</td>
                                    <td>:</td>
                                    <td>12345678</td>

                                </tr>
                                <tr>
                                    <td>A.n</td>
                                    <td>:</td>
                                    <td>Ongky</td>
                                </tr>
                            </table>
                        </center>



                    </div>
                </div>
                <!-- Konten untuk metode pembayaran PayPal -->
            </div>
        </div>
    </div>

</form>


@if ($errors->any())
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (!Auth::user()->is_admin)
<form action="{{ route('submit_payment_receipt', $order) }}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="payment_receipt" class="text-md mb-1">
        Upload Your Payment
        Receipt</label>
    <div class="row mb-3">

        <div class="col">
            <div class="input-group">
                <input type="file" name="payment_receipt" id="payment_receipt" class="form-control">
                <button type="submit" class="btn btn-outline-success">Submit
                    Payment</button>
            </div>
        </div>
    </div>
</form>
@endif








@extends('layouts.ecommerce')
@section('css')
@endsection
@section('content')
@php
$total_price = 0;
@endphp
{{-- {{ $order->id }} --}}
<div class="container">
    <main>
        <div class="py- text-center">

            <h2>Detail Order</h2>
            <hr>
        </div>

        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill"></span>
                </h4>
                <ul class="list-group mb-3">
                    @foreach ($order->transactions as $transaction)
                    <li class="list-group-item justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">{{ $transaction->product->name }}
                                <span class="badge rounded-pill text-bg-primary"> {{ $transaction->amount }}</span>
                            </h6>

                        </div>
                        <p>
                            <span class="text-muted">{{ price($transaction->product->price) }}</span>
                        </p>
                    </li>
                    @php
                    $total_price += $transaction->product->price * $transaction->amount;
                    @endphp
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ price($total_price) }}</strong>
                    </li>

                </ul>

                <div class="card bg-secondary text-warning">
                    <div class="card-body">
                        <div class="scrollable-container" style="height: 200px; overflow-y: auto;">
                            Chat Admin
                            <p v-for="message in messages" :key="message.id">@{{ message.user_id }} :
                                @{{ message.message }}</p>
                        </div>

                        <!-- tambahkan lebih banyak paragraf di sini -->
                    </div>


                </div>
            </div>

            <div class="input-group mt-2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Kirim</button>
                <input type="text" class="form-control" placeholder="Kirim pesan...."
                    aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>


        </div>


        <div class="col-md-7 col-lg-8">

            {{-- Halaman User --}}
            @if (Auth::user()->is_admin)
            @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                {{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="alert alert-warning" role="alert">
                Jika anda belum melakukan pembayaran, silahkan melakukan pembayaran dan pilih metode
                pembayaran dibawah ini.</div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa fa-credit-card" aria-hidden="true"></i> <i>Lanjutkan Pembayaran</i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Pembayaran</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Pilih Metode Pembayaran :
                            <div id="app">
                                <div class="my-3">
                                    <div class="form-check">
                                        <input id="credit" name="paymentMethod" type="radio" class="form-check-input"
                                            value="tf" v-model="paymentMethod" required>
                                        <label class="form-check-label" for="credit">Transfer Mandiri</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="paypal" name="paymentMethod" type="radio" class="form-check-input"
                                            value="paypal" v-model="paymentMethod" required>
                                        <label class="form-check-label" for="paypal">PayPal</label>
                                    </div>
                                </div>

                                <div class="row gy-3">
                                    <div v-if="paymentMethod === 'tf'">
                                        <div class="card text-white bg-warning mb-4 ">
                                            <div class="card-body">
                                                <center>
                                                    <h5 class="card-title font-monospace fs-4">Metode
                                                        Pembayaran:
                                                        Transfer</h5>
                                                    <hr>


                                                    <table class="fw-bolder font-monospace p-3 ">
                                                        <tr>
                                                            <td>Bank</td>
                                                            <td>:</td>
                                                            <td>Mandiri</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rekening</td>
                                                            <td>:</td>
                                                            <td>12345678</td>
                                                        </tr>
                                                        <tr>
                                                            <td>A.n</td>
                                                            <td>:</td>
                                                            <td>Ongky</td>
                                                        </tr>
                                                    </table>
                                                </center>



                                            </div>
                                        </div>

                                        <!-- Konten untuk metode pembayaran Transfer -->
                                    </div>
                                    <div v-else-if="paymentMethod === 'paypal'">
                                        <div class="card text-white bg-info mb-4">

                                            <div class="card-body">
                                                <center>
                                                    <h5 class="card-title font-monospace fs-4">Metode
                                                        Pembayaran: Paypal
                                                    </h5>
                                                    <hr>


                                                    <table class="fw-bolder font-monospace p-3 ">
                                                        <tr>
                                                            <td>Bank</td>
                                                            <td>:</td>
                                                            <td>Mandiri</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rekening</td>
                                                            <td>:</td>
                                                            <td>12345678</td>

                                                        </tr>
                                                        <tr>
                                                            <td>A.n</td>
                                                            <td>:</td>
                                                            <td>Ongky</td>
                                                        </tr>
                                                    </table>
                                                </center>



                                            </div>
                                        </div>
                                        <!-- Konten untuk metode pembayaran PayPal -->
                                    </div>
                                </div>
                            </div>
                            <p class="lead">
                                <b>Total </b>: {{ price($total_price) }}
                            </p>


                            <form action="{{ route('submit_payment_receipt', $order) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <label for="payment_receipt" class="text-md mb-1">
                                    Upload Your Payment
                                    Receipt</label>
                                <div class="row mb-3">

                                    <div class="col">
                                        <div class="input-group">
                                            <input type="file" name="payment_receipt" id="payment_receipt"
                                                class="form-control">
                                            <button type="submit" class="btn btn-outline-secondary">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Understood</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- Halaman User --}}

            {{-- Halaman Admin --}}
            @if (!Auth::user()->is_admin)
            <table class="table table-striped">
                <tr>
                    <td class="text-primary"><b>Status Pembayaran</b></td>
                    <td>:</td>
                    <td>
                        <strong>
                            <span class="badge text-bg-primary">Menunggu Konfirmasi...</span>
                            {{-- <span class="badge text-bg-secondary">Belum dibayar...</span>
                            <span class="badge text-bg-success">Dikonfirmasi...</span>
                            <span class="badge text-bg-danger">Pending...</span> --}}
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-primary"><b>Status Barang</b></td>
                    <td>:</td>
                    <td>
                        <strong>
                            <span class="badge text-bg-secondary">Belum dikirim...</span>
                            {{-- <span class="badge text-bg-success">Dikirim...</span> --}}
                        </strong>
                    </td>
                </tr>
            </table>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Pengiriman</h5>
                    <p class="card-text">Nama Penerima : {{ $order->user->name }}</p>
                    <p class="card-text">Alamat : {{ $order->user->alamat }}</p>
                    <p class="card-text">No Hp : {{ $order->user->telp }}</p>

                    <button class="btn btn-primary">Konfirmasi Pengiriman Barang</button>
                </div>
            </div>
            @endif
            {{-- Halaman Admin --}}

        </div>



</div>
</main>


</div>
@endsection

@section('js')
{{--
<script type="text/javascript">

    var actionUrl = "'{{ url('order') }} + '/' + {{ $order->id  }}"; //variable global
var apiUrl = '{{ url('api/message') }}';
</script> --}}
<script src="{{ asset('js/messages.js') }}"></script>
<script>
new Vue({
    el: '#app',
    data: {
        paymentMethod: 'tf' // Default value set to 'tf'
    }
});
</script>
@endsection


{{-- <input type="hidden" name="orderId" value="{{ $order->id }}">
{{-- <form class="card p-2" method="POST" @submit="submitForm()"> action="{{ route('message_order', $order) }}" --}}
<input type="hidden" name="userId"> --}}
{{-- <input type="text" name="message" id="message" class="form-control" placeholder="Masukkan teks..." required>
    <input type="hidden" name="orderId" value="{{ $order->id }}" v-model="orderId">
<input type="hidden" name="userId" value="{{ $order->users_id }}" v-model="userId"> --}}

<table class="mb-3">
    <tr>
        <td><b>Status Pembayaran</b></td>
        <td>:</td>
        <td>
            <strong>

                <span class="badge text-bg-primary">Menunggu Konfirmasi...</span>
                {{-- <span class="badge text-bg-secondary">Belum dibayar...</span>
                    <span class="badge text-bg-success">Dikonfirmasi...</span>
                    <span class="badge text-bg-danger">Pending...</span> --}}
            </strong>
        </td>

        <td> <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                <li class="fas fa-edit"></li>
            </a>
        </td>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>

    </tr>
    <tr>
        <td><b>Status Order/Barang</b></td>
        <td>:</td>
        <td>
            <strong>
                <span class="badge text-bg-secondary">Belum dikirim...</span>
                {{-- <span class="badge text-bg-success">Dikirim...</span>
                    <span class="badge text-bg-danger">Dibatalkan...</span>
                    --}}
            </strong>
        </td>
        <td> <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">
                <li class="fas fa-edit"></li>
            </a>
        </td>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Data
                            Order/Barang
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>
    </tr>
</table>

{{-- @if (Auth::user()->is_admin)
    <button v-if="!order.is_paid" type="button" class="btn btn-outline-primary btn-sm" :data-bs-toggle="'modal'"
        :data-bs-target="'#modalConfirm' + order.id">Confirm</button>
    @endif --}}

<div class="modal fade" :id="'modalConfirm' + order.id" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                {{-- Konfirmasi pembayaran user <b>{{ $order->user->name }}</b> --}}
                Konfirmasi pembayaran user
            </div>
            <div class="modal-footer">
                <form :action="'{{ url('order') }}' + '/' + order.id + '/' + 'confirm'" method="post">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"> Confirm</button>
                </form>


            </div>
        </div>
    </div>
</div>


<p class="card-text">Nama Penerima : {{ $order->user->name }}</p>
<p class="card-text">Alamat : {{ $order->user->alamat }}</p>
<p class="card-text">No Hp : {{ $order->user->telp }}</p>

<script>
var app = new Vue({
  el: '#app',
  data: {
    selectedYear: '', // Tahun yang dipilih oleh pengguna
    availableYears: [], // Daftar tahun yang tersedia (dapat diisi dari sumber data)
    salesData: [], // Data penjualan berdasarkan tahun yang dipilih
  },
  mounted: function () {
    // Ambil daftar tahun yang tersedia dari sumber data (misalnya, dari backend)
    this.availableYears = [2021, 2022, 2023]; // Ganti dengan daftar tahun yang sesuai dengan data Anda
    // Set tahun yang dipilih menjadi tahun pertama dari daftar tahun tersedia
    this.selectedYear = this.availableYears[0];
    // Ambil data penjualan berdasarkan tahun yang dipilih saat halaman dimuat
    this.fetchSalesData();
  },
  methods: {
    // Fungsi untuk mengambil data penjualan berdasarkan tahun yang dipilih
    fetchSalesData: function () {
      const _this = this;
      axios
        .get(`/api/sales/${this.selectedYear}`) // Ganti dengan URL API endpoint yang sesuai dengan backend Anda
        .then(function (response) {
          // Berhasil mengambil data
          _this.salesData = response.data; // Simpan data penjualan ke variabel salesData
          // Di sini Anda dapat mengupdate chart atau data penjualan Anda sesuai dengan data baru
        })
        .catch(function (error) {
          console.error(error);
        });
    },
  },
});
</script>


const initialData = {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100, 200, 75],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)',
                ],
                hoverOffset: 4,
            }, ],
        };

        // Inisialisasi chart dengan data awal
        const ctp = document.getElementById('myProduct').getContext('2d');
        const myProduct = new Chart(ctp, {
            type: 'doughnut',
            data: initialData,
        });

        // Fungsi untuk menampilkan semua data atau data awal
        let isShowingAllData = false;

        function showAllData() {
            const newData = isShowingAllData ? [300, 50, 100, 200, 75] : [300, 50, 100, 300, 50, 100, 300, 50, 100, 300, 50,
                100
            ];

            myProduct.data.datasets[0].data = newData;
            myProduct.update();

            isShowingAllData = !isShowingAllData;
        }

        <script>
        var app = new Vue({
            el: '#app',
            data: {
                selectedYear: '', // Tahun yang dipilih oleh pengguna
                availableYears: [], // Daftar tahun yang tersedia (dapat diisi dari sumber data)
                salesData: [],
                charts: [], // Data penjualan berdasarkan tahun yang dipilih
            },
            mounted: function() {
                // Ambil daftar tahun yang tersedia dari sumber data (misalnya, dari backend)
                this.availableYears = [2023, 2024, 2025

                ]; // Ganti dengan daftar tahun yang sesuai dengan data Anda
                // Set tahun yang dipilih menjadi tahun pertama dari daftar tahun tersedia
                this.selectedYear = this.availableYears[0];
                // Ambil data penjualan berdasarkan tahun yang dipilih saat halaman dimuat
                this.fetchSalesData();
            },
            methods: {
                // Fungsi untuk mengambil data penjualan berdasarkan tahun yang dipilih
                fetchSalesData: function() {
                    const _this = this;
                    axios
                        .get(
                            `/sale/${this.selectedYear}`
                        ) // Ganti dengan URL API endpoint yang sesuai dengan backend Anda
                        .then(function(response) {
                            // Berhasil mengambil data

                            _this.salesData = response.data; // Simpan data penjualan ke variabel salesData
                            _this.updateChart();
                            // Di sini Anda dapat mengupdate chart atau data penjualan Anda sesuai dengan data baru
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                },

                updateChart: function() {
                    const ctx = document.getElementById('mySale');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July',
                                'August', 'September',
                                'October', 'November', 'December'
                            ],

                            datasets: [{
                                label: 'Sale (2022)',
                                data: this.salesData,
                                selectedYear: '',
                                borderWidth: 1
                                // borderColor: '#36A2EB',
                                // backgroundColor: '#9BD0F5',
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                },

            },
        });
    </script>

<figure class="text-center">
        <blockquote class="blockquote">
            <p>Data Costumer</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            Costumer <cite title="Source Title"></cite>
        </figcaption>
    </figure>