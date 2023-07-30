@extends('layouts.ecommerce')
@section('css')
@endsection

@section('content')
    <figure class="text-center">
        <blockquote class="blockquote">
            <p>Data Costumer</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            Costumer <cite title="Source Title"></cite>
        </figcaption>
    </figure>

    <div id="controller">

        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-10 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group align-items-center mb-2 d-flex justify-content-between">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search name..."
                    aria-label="Search" aria-describedby="basic-addon2" v-model="search">

            </div>
        </form>

        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                {{-- <th width="10px">#</th> --}}
                                <th class="text-center" width="10px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-center">Transaction</th>
                                <th>created_at</th>
                            </tr>

                            <tr v-for="(user, index) in filteredList" :key="user.id">
                                <td>@{{ index + 1 }}.</td>
                                <td>@{{ user.name }}</td>
                                <td>@{{ user.email }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-primary" v-if="user.totalTransaction !== 0">
                                        @{{ user.totalTransaction }}
                                    </span>
                                    <span class="" v-else>
                                        -
                                        <!-- Atau tampilkan sesuai kebutuhan jika totalTransaction bisa bernilai null atau tidak ada -->
                                    </span>

                                </td>

                                <td>
                                    @{{ user.created_at.substring(0, 10) + ' ' + user.created_at.substring(11, 19) }}
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
    <script>
        var actionUrl = '{{ url('index_user') }}'; //variable global
        var apiUrl = '{{ url('api/costumer') }}';

        var controller = new Vue({
            el: "#controller",
            data: {
                search: "",
                users: [],
                user: {},
                actionUrl,
                apiUrl,
            },

            mounted: function() {
                this.getUser();
            },
            methods: {
                getUser() {
                    const _this = this;
                    $.ajax({
                        url: apiUrl,
                        method: "GET",
                        success: function(data) {
                            _this.users = JSON.parse(data);
                        },
                        error: function(error) {
                            console.log(error);
                        },
                    });
                },

            },

            computed: {
                filteredList() {
                    return this.users.filter((user) => {
                        return user.name
                            .toLowerCase()
                            .includes(this.search.toLowerCase());
                    });
                },
            },

        });
    </script>
@endsection
