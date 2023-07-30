@extends('layouts.ecommerce')

@section('css')
    <style>
        .image-container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-container img {
            transition: transform 0.6s ease;
        }

        .image-container:hover img {
            transform: scale(1.2) rotate(-2deg);
        }

        .custom-text {
            /* Tambahkan gaya khusus sesuai kebutuhan Anda */
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            /* Atur nilai sesuai kebutuhan, misalnya 1.5 */

            /* ... */
        }

        .custom-text br {
            margin-bottom: 0.5em;
            /* Atur jarak yang lebih pendek, misalnya setengah em */
        }
    </style>
@endsection



@section('content')
    <h2 class="display-7 text-center mb-4">Add To Cart</h2>




    <div class="card mb-3">
        <div class="row g-0">

            <div class="col-md-5 bg-black">
                <div class="image-container">
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start p-3" alt="...">
                </div>
            </div>
            <div class="col-md-7">
                <div class="card-body m-3">
                    <h5 class="card-title">
                        <a href="{{ route('index_product') }}" class="btn btn-outline-dark text-end">
                            <li class="fas fa-arrow-left"></li>
                        </a>
                        &nbsp;{{ $product->name }}
                    </h5>

                    <asd class="custom-text">
                        <p>{!! $product->description !!}</p>
                    </asd>


                    @php
                        $totalStock = $products->stocks->sum('stock');
                    @endphp
                    <figure class="text-end">
                        <blockquote class="blockquote">
                            <p>{{ price($product->price) }}</p>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            Stock: <cite title="Source Title"> {{ $totalStock }}</cite>
                        </figcaption>
                    </figure>

                    @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    @if (Auth::check() && !Auth::user()->is_admin)
                        <hr>

                        <form action="{{ route('add_to_cart', $product) }}" method="post"
                            class="d-flex align-items-center">
                            @csrf


                            @if ($stocks->count() > 1)
                                <div class="input-group mb-2 me-3">
                                    <label for="a" class="py-2">Size : &nbsp;</label>
                                    <select id="a" class="form-select" name="id_stocks"
                                        aria-label="Default select example" required>
                                        @foreach ($stocks as $option)
                                            @if ($option->stock == 0)
                                                <option value="{{ $option->id }}" disabled>{{ getOptional($option->id) }}
                                                </option>
                                            @else
                                                <option value="{{ $option->id }}">{{ getOptional($option->id) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="input-group mb-2">
                                {{-- <input type="hidden" value="{{ $prodduct->id }}" name="productId"> --}}
                                <input type="number" name="amount" value="1" min="1"
                                    class="form-control form-control-sm">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                </button>
                            </div>
                        </form>

                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
@endsection
