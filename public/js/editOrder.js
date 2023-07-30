var controller = new Vue({
    el: "#status",
    data: {
        // untuk menyimpan sebuah variable
        orders: [],
        order: {},
        actionUrl, // = actionUrl : actionUrl
        apieditUrl,
    },

    mounted: function () {
        // function yang akan dijalankan saat membuka halaman
        this.getStatus();
    },
    methods: {
        // untuk menyimpan beberapa function
        getStatus() {
            const _this = this;
            $.ajax({
                url: apieditUrl,
                method: "GET",
                success: function (data) {
                    _this.orders = JSON.parse(data);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },

        addPayment(id) {
            var actionUr = "order" + "/" + id;
            window.location.href = actionUr;
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

        statusSpan(id) {
            if (id === "1") {
                return "<span class='badge text-bg-secondary'>Belum Dikirim..</span>";
            } else if (id === "2") {
                return "<span class='badge text-bg-success'>Dikirim..</span>";
            } else {
                return "<span class='badge text-bg-danger'>Dibatalkan..</span>";
            }
        },
    },
});
