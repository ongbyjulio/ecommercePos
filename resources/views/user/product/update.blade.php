@extends('layouts.ecommerce')

@section('css')
@endsection
@section('content')
    <figure class="text-center">
        <blockquote class="blockquote">
            <p>Edit Data</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            <cite title="Source Title">Product : {{ $product->name }}</cite>
        </figcaption>
    </figure>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <code class="text-dark"> <b>{{ $error }}</b></code>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('update_product', $product) }}" class="row g-3" method="post" enctype="multipart/form-data"
        @submit="checkDescriptionChanges">
        @method('patch')
        @csrf
        <div class="row g-2 mt-3">
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="name" id="floatingInputGrid"
                        value="{{ $product->name }}" placeholder="name">
                    <label for="floatingInputGrid">Product Name </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select" name="category_id" id="floatingSelectGrid"
                        aria-label="Floating label select example">
                        @foreach ($categorys as $key)
                            <option value="{{ $key->id }}" {{ $key->id == $product->category_id ? 'selected' : '' }}>
                                {{ $key->name }}
                            </option>
                        @endforeach
                    </select>
                    <label for="floatingSelectGrid">Category with selects</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <a href="{{ route('index_category') }}" class="btn btn-primary">
                        <li class="fas fa-plus"></li> Add Categori
                    </a>
                </div>
            </div>

        </div>

        <div class="row g-2">
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" name="price" class="form-control" value="{{ $product->price }}"
                        id="floatingInputGrids" placeholder="Price">
                    <label for="floatingInputGrids">Price </label>
                </div>
            </div>
        </div>

        <div id="app">

            <div class="row g-2">
                <div class="col-md mb-3">

                    <input type="hidden" name="description" id="descriptionInput">

                    <label class="mb-2">Desription Product :</label>
                    <div class="form-floating">

                        <div id="editor" style="height: 200px" v-html="descriptionTampil">

                        </div>
                    </div>

                </div>
            </div>

            <div class="my-3">
                <div class="form-check">
                    <input id="stock2" name="stock_type" type="radio" class="form-check-input" value="optiont"
                        v-model="stocks" required>
                    <label class="form-check-label" for="stock2">Option</label>
                </div>

                <div class="form-check">
                    <input id="stock1" name="stock_type" type="radio" class="form-check-input" value="no-option"
                        v-model="stocks" required>
                    <label class="form-check-label" for="stock1">No Option</label>
                </div>
            </div>


            <div v-if="stocks === 'no-option'">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="number" name="stock" class="form-control" id="floatingInputGrids"
                                placeholder="Stock" v-model="nooption">
                            <label for="floatingInputGrids">Stock </label>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else-if="stocks === 'optiont'">
                <div class="row g-3 mb-3" v-for="(optiont, index) in options" :key="index">
                    <div class="col">
                        <label for="name3" class="mb-2">Option</label>
                        <input type="text" id="name3" class="form-control" :name="'options[' + index + '][optional]'"
                            v-model="optiont.optional" placeholder="size : M/29/Color">
                    </div>
                    <div class="col">
                        <label for="name4" class="mb-2">Stock</label>
                        <input type="number" id="name4" class="form-control" :name="'options[' + index + '][stock]'"
                            v-model="optiont.stock" placeholder="Stock" required>
                    </div>
                    <div class="col">
                        <a href="#" @click="removeOption(index)" v-if="options.length > 1">
                            <li class="fas fa-trash"></li>
                        </a>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary me-md-2" type="button" @click="addOption">Add option</button>
                </div>
            </div>
        </div>


        <hr>

        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Multiple files input Image</label>
            <input class="form-control" type="file" id="formFileMultiple" name="image" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                descriptionTampil: '{!! $product->description !!}',

                stocks: '{{ $stocks && count($stocks) == 1 ? 'no-option' : 'optiont' }}',
                options: [
                    @foreach ($stocks as $stock)
                        {
                            optional: '{{ $stock->optional }}',
                            stock: '{{ $stock->stock }}'
                        },
                    @endforeach
                ],
                nooption: '{{ $stock->stock }}'

            },
            methods: {
                addOption() {
                    this.options.push({
                        optional: '',
                        stock: ''
                    });
                },
                removeOption(index) {
                    this.options.splice(index, 1);
                },

                updateDescriptionInput(content) {
                    document.getElementById('descriptionInput').value = content;
                },
            },

            mounted() {
                const options = {
                    theme: 'snow',
                    placeholder: 'Enter your text...',
                };

                const editor = new Quill('#editor', options);

                editor.on('text-change', () => {
                    const content = editor.root.innerHTML;
                    this.updateDescriptionInput(content);
                });
            },
        });
    </script>

    <script>
        // Function to format the price input with dot separator
        function formatPriceInput(input) {
            // Remove existing dots and non-numeric characters
            const value = input.value.replace(/\D/g, '');

            // Add dot separator for every three digits from the right
            const formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Set the formatted value back to the input
            input.value = formattedValue;
        }

        // Get the price input element
        const priceInput = document.querySelector('input[name="price"]');

        // Listen for input event and format the price on each input change
        priceInput.addEventListener('input', function() {
            formatPriceInput(this);
        });
    </script>
@endsection
