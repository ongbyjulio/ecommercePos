var app = new Vue({
    el: "#controller",
    data: {
        messages: [],
        message: {},
        messageText: "",
        actionUrl, // = actionUrl : actionUrl
        apiUrl,
        postUrl,
    },
    mounted: function () {
        this.getMessages();

        // setInterval(() => {
        //     this.get_messages();
        // }, 5000);
    },
    methods: {
        getMessages() {
            const _this = this;
            $.ajax({
                url: apiUrl,
                method: "GET",
                success: function (data) {
                    _this.messages = JSON.parse(data);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        },

        editStatus(order) {
            this.order = order;
            $("#editModal").modal();
        },
        submitForm() {
            axios
                .post(this.postUrl, {
                    message: this.messageText,
                }) // Kirim data message menggunakan POST request
                .then((response) => {
                    this.messageText = ""; // Reset input field setelah data terkirim
                    this.getMessages(); // Mereload data messages setelah mengirim pesan
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        name(id) {
            if (id !== 1) {
                return "Me";
            } else {
                return "Admin";
            }
        },
    },
});
