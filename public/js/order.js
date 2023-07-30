var controller = new Vue({
    el: "#controller",
    data: {
        // untuk menyimpan sebuah variable
        orders: [],
        order: {},
        search: "",
        actionUrl, // = actionUrl : actionUrl
        apiUrl,
    },

    mounted: function () {
        // function yang akan dijalankan saat membuka halaman
        this.getProducts();
    },
    methods: {
        // untuk menyimpan beberapa function
        getProducts() {
            const _this = this;
            $.ajax({
                url: apiUrl,
                method: "GET",
                success: function (data) {
                    _this.orders = JSON.parse(data);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },

        addData() {
            this.data = {}; //mengosongkan data
            // this.actionUrl = '{{ url('authors') }}'; untuk mengosongkan data
            this.editStatus = false;
            $("#defaultModal").modal();
        },
        addPayment(id) {
            var actionUr = "order" + "/" + id;
            window.location.href = actionUr;
        },

        deleteData(event, id) {
            if (confirm("Are you Sure?")) {
                $(event.target).parents("tr").remove();
                axios
                    .post(this.actionUrl + "/" + id, {
                        _method: "DELETE",
                    })
                    .then((response) => {
                        alert("Data Has Been removed");
                    });
            }
        },

        submitForm(event, id) {
            event.preventDefault();
            const _this = this;
            var actionUrl = !this.editStatus
                ? this.actionUrl
                : this.actionUrl + "/" + id;
            axios
                .post(actionUrl, new FormData($(event.target)[0]))
                .then((response) => {
                    $("#defaultModal").modal("hide");
                    _this.table.ajax.reload();
                });
        },
    },

    computed: {
        filteredList() {
            return this.orders.filter((order) => {
                return order.user_id
                    .toLowerCase()
                    .includes(this.search.toLowerCase());
            });
        },
    },
});
