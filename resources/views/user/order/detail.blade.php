@extends('layouts.ecommerce')
@section('css')
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>
@endsection
@section('content')
    @php
        $total_price = 0;
    @endphp
    <div class="container">
        <main>
            <div class="py-2 text-center">

                <h2>Order</h2>
                <hr>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart</span>

                    </h4>
                    <ul class="list-group mb-3">
                        @foreach ($order->transactions as $transaction)
                            <li class="list-group-item justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ names($transaction->product->name) }}
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
                            <span>Total : </span>
                            <strong>{{ price($total_price) }}</strong>
                        </li>
                    </ul>


                    <div id="controller">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">Admin Chat</span>

                        </h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="scrollable-container" style="height: 200px; overflow-y: auto;">

                                    <p v-for="message in messages" :key="message.id">
                                        @{{ name(message.user_id) }} :
                                        @{{ message.message }}
                                    </p>
                                </div>

                                <!-- tambahkan lebih banyak paragraf di sini -->
                            </div>

                            <form class="card p-2" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="message" v-model="messageText" class="form-control"
                                        placeholder="Masukkan teks..." required>
                                    <button type="submit" class="btn btn-primary"
                                        @click.prevent="submitForm">Kirim</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3 text-primary">Informasi Order</h4>
                    <div id="status">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Status Pembayaran</th>
                                    <th scope="col">Status Order/Barang</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orders" :key="order.id">
                                    <td> <span v-if="order.is_paid" class="badge text-bg-info">Paid</span>
                                        <span v-else class="badge text-bg-dark">Unpaid</span>
                                        </span>
                                        <a v-if="order.payment_receipt"
                                            :href="'{{ url('storage/') }}' + '/' + order.payment_receipt">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (Auth::user()->is_admin)
                                            <a data-bs-toggle="modal" class="float-end" data-bs-target="#modalConfirm">
                                                <li class="fas fa-edit"></li>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <span v-html="statusSpan(order.status)"></span>
                                        @if (Auth::user()->is_admin)
                                            <a data-bs-toggle="modal" class="float-end" data-bs-target="#editStatus">
                                                <li class="fas fa-edit"></li>
                                            </a>
                                        @endif

                                    </td>

                                </tr>
                            </tbody>
                        </table>



                    </div>

                    {{-- Modal Status Order --}}
                    <div class="modal fade" id="editStatus" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="{{ route('confirm_status', $order) }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi
                                            Status
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect1"
                                                aria-label="Floating label select example" name="status">
                                                <option value="1">Belum Dikirim</option>
                                                <option value="2">Sudah Dikirim</option>
                                                <option value="3">Dibatalkan</option>
                                            </select>
                                            <label for="floatingSelect1">Status Order</label>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Modal Status Order --}}

                    {{-- Modal ConfirmPayment --}}
                    <div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirm Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    {{-- Konfirmasi pembayaran user <b>{{ $order->user->name }}</b> --}}
                                    Konfirmasi pembayaran user
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
                    {{-- Modal ConfirmPayment --}}


                    {{-- Halaman User --}}
                    @if (!Auth::user()->is_admin)
                        @if ($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="alert alert-warning" role="alert">
                            Jika anda belum melakukan pembayaran, silahkan melakukan pembayaran dan pilih metode
                            pembayaran dibawah ini, dan pastikan alamat,nomor telpon dan nama penerima sudah sesuai!. Jika
                            belum klik <a href="{{ route('show_profile') }}" style="text-decoration: none;">disini</a>
                            untuk
                            mengedit data.
                        </div>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            <i class="fa fa-credit-card" aria-hidden="true"></i> <i>Lanjutkan Pembayaran</i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Pembayaran</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Pilih Metode Pembayaran :
                                        <div id="app">
                                            <div class="my-3">
                                                <div class="form-check">
                                                    <input id="credit" name="paymentMethod" type="radio"
                                                        class="form-check-input" value="tf" v-model="paymentMethod"
                                                        required>
                                                    <label class="form-check-label" for="credit">Transfer
                                                        Mandiri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input id="paypal" name="paymentMethod" type="radio"
                                                        class="form-check-input" value="paypal" v-model="paymentMethod"
                                                        required>
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

                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Halaman User --}}


                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">Data Penerima</div>
                        <div class="card-body text-white">
                            <table class="table table-striped">
                                <tr>
                                    <td>Penerima</td>
                                    <td>:</td>
                                    <td><b>{{ $order->user->name }}</b></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $order->user->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>Penerima</td>
                                    <td>:</td>
                                    <td>{{ $order->user->telp }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <p>Comment :</p>
                    {{ $order->comment }}

                </div>
            </div>
        </main>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var actionUrl = "{{ url('order') }}/{{ $order->id }}"; // variabel global
        var apiUrl = "{{ url('api/message') }}/{{ $order->id }}"; // variabel global
        var apieditUrl = "{{ url('api/order') }}/{{ $order->id }}"; // variabel global
        var postUrl = "{{ url('order') }}/{{ $order->id }}/{{ 'message' }}"; // variabel global
    </script>
    <script src="{{ asset('js/messages.js') }}"></script>
    <script src="{{ asset('js/editOrder.js') }}"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                paymentMethod: 'tf' // Default value set to 'tf'
            }
        });
    </script>
@endsection
