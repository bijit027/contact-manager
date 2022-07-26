<template>
<router-view />
<div>
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

    <div>
        <h2 class="error">{{ error }}</h2>  
    </div>
   
    <div class="container mt-3">
        <div class="row">
            <div class="input-group input-group-lg">
                <form @submit.prevent="submitChange()">
                    <div class="mb-2">
                        <label for="color">Select table header color:</label>
                        <input id="color" type="color" v-model="contact.color" class="form-control">
                        <small class="danger" v-if="error.color">{{ error.color }}</small>
                    </div>
                    <div class="mb-2">
                        <label for="row">How many row you want to show:</label>
                        <input id="row" v-model="contact.limit" type="number" min="1" class="form-control" placeholder="Number of row">
                        <small class="danger" v-if="error.limit">{{ error.limit }}</small>
                    </div>
                    <div class="mb-2">
                        <label for="orderBy">Order By:</label><br>
                        <select id="orderBy" class="form-control" v-model="contact.orderby" name="cars">
                            <option value="id">ID</option>
                            <option value="name">Name</option>
                            <option value="email">Email</option>
                            <option value="mobile">Mobile</option>
                            <option value="company">Company</option>
                            <option value="title">Title</option>
                        </select>
                        <small class="danger" v-if="error.orderby">{{ error.orderby }}</small>
                    </div>
                    <div>
                        <label >Hide Column:</label><br>
                        <input type="checkbox" id="id" value="ID" v-model="hideColumn">
                        <label for="id">ID</label><br>
                        <input type="checkbox" id="email" value="Email" v-model="hideColumn">
                        <label for="email">Email</label><br>
                        <input type="checkbox" id="company" value="Company" v-model="hideColumn">
                        <label for="company">Company</label><br>
                        <input type="checkbox" id="title" value="Title" v-model="hideColumn">
                        <label for="title">Title</label>
                    </div><br>

                    <div class="mb-2">
                        <input type="submit" class="btn btn-success" value="Change">
                    </div>

                </form>

            </div>
            <div class="col">
                <button class="btn btn-outline-secondary" v-on:click="defaults('')">Default</button>
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

            hideColumn: [],

            default: {
                id: '1',
                color: '#4CAF50',
                limit: '5',
                page: '3',
                column: '1',
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
                    column: that.hideColumn,
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
.danger {
    color: red;
}
.error{
    color: red;
}

form label{
  font-weight:bold;
}
</style>
