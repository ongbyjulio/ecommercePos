<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/style.css') }}" rel="stylesheet">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


    @yield('css')
</head>

<body>
    <div class="container py-3">
        <header>
            <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                <a href="{{ route('index_product') }}" class="d-flex align-items-center text-dark text-decoration-none">


                    <title>E-commerce</title>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"
                        fill="currentColor"></path>
                    </svg>
                    <span class="fs-4">B-SHOP</span>
                </a>

                <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                    @guest
                        @if (Route::has('login'))
                            <a class="me-3 py-2 text-dark text-decoration-none"
                                href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif

                        @if (Route::has('register'))
                            <a class="me-3 py-2 text-dark text-decoration-none"
                                href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        @if (Auth::user()->is_admin)
                            <a class="me-3 py-2 text-dark text-decoration-none"
                                href="{{ route('index_dashboard') }}">Dashboard</a>
                        @endif

                        <a class="me-3 py-2 text-dark text-decoration-none" href="{{ route('index_product') }}">Product</a>
                        @if (!Auth::user()->is_admin)
                            <a class="me-3 py-2 text-dark text-decoration-none" href="{{ route('show_cart') }}">Cart

                                <span
                                    class="badge text-bg-secondary">{{ getTotalCartByUserId($userId = Auth::id()) }}</span>


                            </a>
                        @endif
                        <a class="me-3 py-2 text-dark text-decoration-none" href="{{ route('index_order') }}">Order</a>

                        @if (Auth::user()->is_admin)
                            <a class="me-3 py-2 text-dark text-decoration-none"
                                href="{{ route('index_user') }}">Costumer</a>
                        @endif

                        <div class="dropdown py-2">
                            <a class="py-2 text-dark text-decoration-none dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $userName = ucwords(Auth::user()->name) }}
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li>
                                    <a class="dropdown-item" href="{{ route('show_profile') }}">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>



                    @endguest
                </nav>
            </div>

            {{-- <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-4 fw-normal">Pricing</h1>
                <p class="fs-5 text-muted">Quickly build an effective pricing table for your potential customers with
                    this Bootstrap example. It’s built with default Bootstrap components and utilities with little
                    customization.</p>
            </div> --}}
        </header>
        <main>
            @yield('content')
        </main>
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">

                    <small class="d-block mb-3 text-muted text-center">&copy; 2023–2024 <code>'BY :
                            OjCode'</code>.</small>
                </div>

            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @yield('js')

</body>

</html>
