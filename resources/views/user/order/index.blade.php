@extends('layouts.ecommerce')
@section('content')
    @php
        $total_price = 0;
    @endphp

    <div id="controller">

        <figure class="text-center">
            <blockquote class="blockquote">
                <p>Data Order</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                @if (!Auth::user()->is_admin)
                    My Order <cite title="Source Title"></cite>
                @else
                    All Order <cite title="Source Title"></cite>
                @endif
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


        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-10 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group align-items-center mb-2 d-flex justify-content-between">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search name..."
                    aria-label="Search" aria-describedby="basic-addon2" v-model="search">

            </div>
        </form>
        <!-- Content -->



        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                {{-- <th width="10px">#</th> --}}
                                <th class="text-center">OrderID</th>
                                <th>User</th>
                                <th>Payment</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>

                            <tr v-for="order in filteredList" class="">
                                {{-- <td>{{ index + 1 }}</td> --}}
                                <td class="text-center">@{{ order.id }}</td>
                                <td>@{{ order.user_id }}</td>
                                <td>
                                    <span v-if="order.is_paid" class="badge text-bg-info">Paid</span>
                                    <span v-else class="badge text-bg-dark">Unpaid</span>

                                </td>

                                <td>@{{ order.created_at.substring(0, 10) + ' ' + order.created_at.substring(11, 19) }}
                                </td>
                                <td>
                                    <a :href="'{{ route('index_order') }}' + '/' + order.id"
                                        class="btn btn-outline-primary btn-sm">Show</a>

                                </td>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var actionUrl = '{{ url('index_order') }}'; //variable global
        var apiUrl = '{{ url('api/order') }}';
    </script>
    <script src="{{ asset('js/order.js') }}"></script>
@endsection
