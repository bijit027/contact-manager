<template>
<router-view />
<div>
    <h2 class="show-error">{{ error }}</h2>
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <p class="h3 text-success fw-bold">Settings Page</p>
                <p class="fst-italic">It is a long established fact that a reader will be
                    by the readable content of a page when looking at its layout. The point
                    of using Lorem Ipsum is that it has a more-or-less normal distribution
                    of letters, as opposed to using 'Content here, content here', making it
                    look like readable English. Many desktop publishing packages and web
                </p>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">

                <form @submit.prevent="submitChange()">
                    <div class="mb-2">
                        <label for="favcolor">Select table header color:</label>
                        <input type="color" v-model="contact.color" class="form-control"><br><br>
                    </div>
                    <div class="mb-2">
                        <label for="favcolor">How many row you want to show:</label>
                        <input v-model="contact.limit" type="number" min="1" class="form-control" placeholder="Number of row">
                    </div>
                    <div class="mb-2">
                        <label for="favcolor">Order By:</label><br>
                        <select id="cars" v-model="contact.orderby" name="cars">
                            <option value="id">ID</option>
                            <option value="name">Name</option>
                            <option value="email">Email</option>
                            <option value="mobile">Mobile</option>
                            <option value="company">Company</option>
                            <option value="title">Title</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="favcolor">Hide Column:</label><br>
                        <select id="cars" v-model="contact.column" name="cars">
                            <option value="">None</option>
                            <option value="id">ID</option>
                            <option value="name">Name</option>
                            <option value="email">Email</option>
                            <option value="mobile">Mobile</option>
                            <option value="company">Company</option>
                            <option value="title">Title</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <input type="submit" class="btn btn-success" value="Change">
                    </div>

                </form>

            </div>
                <div class="col">
                    <button class="btn btn-secondary" v-on:click="defaults('')">Default</button>
                </div>
        </div>
    </div>
</div>
</template>

<script>
import $ from 'jquery';
export default {
    name: 'AddContact',
    data: function () {
        return {
            contact: {
                id: '',
                color: '',
                limit: '',
                page: '',
                column: '',
                orderby: ''
            },

            default: {
                id: '1',
                color: '#4CAF50',
                limit: '5',
                page: '3',
                column: '',
                orderby: 'id'

            },
            contacts: [],
            error: '',
            id: '1'
        }
    },
    created() {

        // watch the params of the route to fetch the data again
        this.$watch(
            () => this.$route.params,
            () => {
                this.fetchData()
            },
            // fetch the data when the view is created and the data is
            // already being observed
            {
                immediate: true
            }
        )
    },

    methods: {

        fetchData() {
            const that = this;
            jQuery.ajax({
                type: "GET",
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: "cm_get_shortcode_value",
                },
                success: function (data) {
                    that.contact = data.data[0];

                }
            });

        },
        submitChange() {
            const that = this;
            console.log(ajax_url.ajaxurl);
            $.ajax({
                type: "POST",
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: "cm_insert_shortcode_table",
                    id: that.id,
                    color: that.contact.color,
                    limit: that.contact.limit,
                    page: that.contact.page,
                    column: that.contact.column,
                    orderby: that.contact.orderby,
                    wpsfb_nonce: ajax_url.wpsfb_nonce,
                },
                success: function (data) {
                    that.mydata = data.data;
                    window.location.reload();
                },
                error: function (error) {
                    that.error = error.responseJSON.data;
                },
            });
        },

        defaults() {

            this.contact = this.default;

        },
    }
}
</script>

<style>
.show-error {
    color: red;
}
</style>
