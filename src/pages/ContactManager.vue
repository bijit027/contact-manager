<template>
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <p class="h3 text-success fw-bold">Contact Manager
                <router-link to="/contacts/add" class="btn btn-success btn-sm"> <i class="fa fa-plus-circle"></i> New</router-link>
            </p>
            <p class="fst-italic">It is a long established fact that a reader will be
                by the readable content of a page when looking at its layout. The point
                of using Lorem Ipsum is that it has a more-or-less normal distribution
                of letters, as opposed to using 'Content here, content here', making it
                look like readable English. Many desktop publishing packages and web
            </p>
        </div>
        <div class="col">
            <p class="h6 text-primary" style="background-color: white; border: 1px solid black;"> If you want to use shortcode then use the code below <br><br>
                for all contacts use: <br> => <b>[contact-code]</b> <br><br>
                for id based contact: <br>
                => <b>[contact-code id=""]</b>
            </p>
        </div>
    </div>
</div>
<div class="alert alert-success" v-if="this.showSuccess.length" role="alert">
    <h2>{{this.showSuccess}}</h2>
</div>
<div class="alert alert-danger" v-if="this.showError"  role="alert">
    <h2>{{ this.showError }}</h2>
</div>
<div calss="container mt-3 " style="margin-left: 5%; width:100% " v-if="contacts.length > 0">
    <div class="row">
        <div class="col-md-6" v-for="contact of contacts" :key="contact">
            <div class="card my-2 list-group-item-success shadow-lg">
                <div class="card-body">
                    <div class="row align-item-center">
                        <div class="col-sm-5">
                            <img :src="contact.photo" alt="" class="contact-img" />
                        </div>
                        <div class="col-sm-6">
                            <b>[contact-code id="{{ contact.id }}"]</b>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    ID : <span class="fw-bold">{{ contact.id }}</span>
                                </li>
                                <li class="list-group-item">
                                    Name : <span class="fw-bold">{{ contact.name }}</span>
                                </li>
                                <li class="list-group-item">
                                    Email : <span class="fw-bold">{{ contact.email }}</span>
                                </li>
                                <li class="list-group-item">
                                    Mobile : <span class="fw-bold">{{ contact.mobile }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-1   flex-column justify-content-center align-items-center ">
                            <router-link :to="`/contacts/view/${contact.id}`" class="btn btn-warning my-1">
                                <i class="fa fa-eye"></i>
                            </router-link>
                            <router-link :to="`/contacts/edit/${contact.id}`" class="btn btn-primary my-1">
                                <i class="fa fa-pen"></i>
                            </router-link>
                            <button class="btn btn-danger my-1" @click="clickDeleteContact(contact.id)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "ContactManager",

    data() {
        return {
            loading: false,
            contacts: [],
            errorMessage: null,
            showSuccess: '',
            showError: '',

        }
    },

    mounted() {

        this.fetchData();
    },

    methods: {
        fetchData() {
            const that = this;
            jQuery.ajax({
                type: "GET",
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: "cm_get_contact_lists",
                },
                success: function (data) {
                    that.contacts = data.data;
                }
            });

        },

        clickDeleteContact: async function (contactID) {
            const that = this;
            jQuery.ajax({
                type: "POST",
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: "cm_delete_contact",
                    id: contactID,
                    wpsfb_nonce: ajax_url.wpsfb_nonce,
                },
                success: function (data) {
                    that.showSuccess = 'Value deleted successfully';
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);

                },
                error: function (error) {
                    that.showError = 'Something went wrong';
                    that.errors = error.responseJSON.data;

                },
            });

        },
    }
}
</script>

<style>
.col-sm-1 {
    margin-top: 25px;
}
</style>
