@extends('layouts.ecommerce')
@section('css')
    <style>
        .card {
            padding: 15px;
            /* JUST TO LOOK COOL */
            border: 1px solid #eee;
            /* JUST TO LOOK COOL */
            box-shadow: rgba(0, 0, 0, 0.06) 0px 2px 4px;
            transition: all .3s ease-in-out;
        }

        .card:hover {
            box-shadow: rgba(0, 0, 0, 0.22) 0px 19px 43px;
            transform: translate3d(0px, -1px, 0px);
        }
    </style>
@endsection

@section('content')
    <div id="app">
        <figure class="text-center">
            <blockquote class="blockquote">
                <p>Dashboard</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                Data Grafik <cite title="Source Title"></cite>
            </figcaption>
        </figure>

        <div class="float-end">
            <select v-model="selectedYear" @change="fetchSalesData" class="form-select" aria-label="Default select example">
                <option v-for="year in availableYears" :key="year" :value="year">
                    @{{ year }}
                </option>
            </select>
        </div>
        <!-- Tampilkan chart atau data penjualan di sini -->
        <canvas id="mySale"></canvas>


        <hr>
        <div class="container overflow-hidden">
            <div class="row gx-5">
                <div class="col mb-5">
                    <h5 class="card-title text-center">Category </h5>
                    <canvas id="myCategory"></canvas>
                </div>
                <div class="col">


                    <div class="card mb-3" @click="product()">
                        <div class="card-body">
                            <h5 class="card-title text-center text-primary">Product </h5>
                            <p class="card-text text-center">
                            <h1 class="text-center">{{ getAllTotalProduct() }}</h1>
                            <hr>
                            </p>
                            <p class="card-text"><small class="text-muted"> Stock : <span class="badge bg-primary">Tersedia
                                        {{ getAllStockNotNull() }}</span>
                                    <span class="badge bg-secondary">Kosong {{ getAllStockNull() }}</span></small></p>
                        </div>

                    </div>

                    <div class="card" @click="user()">

                        <div class="card-body">
                            <h5 class="card-title  text-center text-primary">Costumer</h5>
                            <p class="card-text">
                            <h1 class="text-center">{{ getAllTotalUser() }}</h1>
                            </p>
                            <hr>
                            <p class="card-text">
                                <small class="text-muted"><span class="badge bg-success">active</span>

                                </small>

                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                selectedYear: '',
                availableYears: [],
                salesData: [],
                chart: null,
            },
            mounted: function() {
                this.availableYears = [2023, 2024, 2025];
                this.selectedYear = this.availableYears[0];
                this.fetchSalesData();
            },
            methods: {
                fetchSalesData: function() {
                    const _this = this;
                    axios
                        .get(
                            `/sale/${this.selectedYear}`
                        )
                        .then(function(response) {
                            _this.salesData = response.data;
                            _this.updateChart();
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                },

                updateChart: function() {
                    if (this.chart) {
                        // Hancurkan chart sebelumnya jika sudah ada
                        this.chart.destroy();
                    }


                    const ctx = document.getElementById('mySale');
                    this.chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July',
                                'August', 'September',
                                'October', 'November', 'December'
                            ],

                            datasets: [{
                                label: 'Sale (' + this.selectedYear + ')',
                                data: this.salesData,
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

                product() {
                    window.location.href = '/product';
                },
                user() {
                    window.location.href = '/costumer';
                },

            },
        });
    </script>

    <script>
        var dataProducts = '{!! json_encode($data_products) !!}'
        var label = '{!! json_encode($label_category) !!}';

        const ctp = document.getElementById('myCategory');
        new Chart(ctp, {
            type: 'doughnut',
            data: {
                labels: JSON.parse(label),
                datasets: [{
                    label: 'My First Dataset',
                    data: JSON.parse(dataProducts),
                    backgroundColor: [
                        "#4e73df",
                        "#1cc88a",
                        "#36b9cc",
                        "#4ab3dc",
                        "#F0F8FF",
                        "#00FFFF",
                        "#FFE4C4",
                        "#8A2BE2",
                        "#A52A2A",
                        "#5F9EA0",
                        "#FF7F50",
                    ],
                    hoverBackgroundColor: [
                        "#2e59d9",
                        "#17a673",
                        "#2c9faf",
                        "#1c3aaf",
                    ],
                    hoverOffset: 4
                }]
            }

        });
    </script>
@endsection
