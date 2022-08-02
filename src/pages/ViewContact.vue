<template>
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <p class="h3 text-success fw-bold">View Contact</p>
            <p class="fst-italic">
                It is a long established fact that a reader will be
                by the readable content of a page when looking at its layout. The point
                of using Lorem Ipsum is that it has a more-or-less normal distribution
                of letters, as opposed to using 'Content here, content here', making it
                look like readable English. Many desktop publishing packages and web
            </p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row align-items-center">
        <div class="col-md-4" v-for="contact of contacts" :key="contact">
            <img :src="contact.photo" alt="" class="contact-img-big">
        </div>
        <div class="col-md-6 " v-for="contact of contacts" :key="contact">
            <ul class="list-group">
                <li class="list-group-item">
                    ID : <span class="fw-bold">{{ this.contactId }}</span>
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
                <li class="list-group-item">
                    Company : <span class="fw-bold">{{ contact.company }}</span>
                </li>
                <li class="list-group-item">
                    Title : <span class="fw-bold">{{ contact.title }}</span>
                </li>

            </ul>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <router-link to="/contacts" class="btn btn-success"> <i class="fa fa-arrow-alt-circle-left"></i> Back</router-link>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'ViewContact',

    data() {
        return {
            contactId: this.$route.params.contactId,
            contacts: [],
        }
    },
    mounted() {
        this.fetchData();   
    },
    methods: {
        fetchData(){
            const that = this;
        jQuery.ajax({
            type: "GET",
            url: ajax_url.ajaxurl,
            dataType: 'json',
            data: {
                action: "cm_get_single_data",
                id: that.contactId
            },
            success: function (data) {
                that.contacts = data.data;
            }
        });

        }
    }
}
</script>

<style>

</style>
