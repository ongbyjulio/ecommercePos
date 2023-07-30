var app = new Vue({
    el: "#controller",
    data: {
        products: [],
        search: "",
        product: {},
        actionUrl, // = actionUrl : actionUrl
        apiUrl,
        categoryFilter: "",
        isLoading: true,

        // updateUrl,
        // editStatus: false,
    },
    mounted: function () {
        this.get_products();
    },
    methods: {
        get_products() {
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
        },

        formattedPrice(price) {
            return this.price(price);
        },
        price(value) {
            // Fungsi helper price
            // Lakukan operasi pengubahan format harga di sini
            return "Rp " + value.toLocaleString();
        },

        nameFormat(name) {
            return this.name(name);
        },
        name(value) {
            if (value.length > 17) {
                return value.substring(0, 17) + "..";
            }
            return value;
        },

        renderHTML(html) {
            return html.replace(/&lt;/g, "<").replace(/&gt;/g, ">");
        },

        clearFiltersN() {
            this.categoryFilter = "";
        },

        clearAllFilter() {
            this.categoryFilter = "";
            this.search = "";
        },
    },
    computed: {
        filteredList() {
            if (this.categoryFilter) {
                return this.products.filter((product) => {
                    return product.category_id
                        .toLowerCase()
                        .includes(this.categoryFilter.toLowerCase());
                });
            } else if (this.search) {
                return this.products.filter((product) => {
                    return product.name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                });
            } else {
                return this.products;
            }
        },
    },
});
