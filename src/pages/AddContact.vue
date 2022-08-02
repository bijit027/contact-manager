<template>
<div>
    <p class="h3 text-success fw-bold">Add Contact</p>
    <div class="alert alert-success" v-if="this.showSuccess.length" role="alert">
        <h2>{{this.showSuccess}}</h2>
    </div>

    <div class="alert alert-danger" v-if="this.showError" v-show="elementVisible" role="alert">
        <h2>{{ this.showError }}</h2>
    </div>
    <InputForm v-bind:contact="contact" v-bind:errors="errors" @form-submit="onSubmit" />
</div>
</template>

<script>
import InputForm from "../components/InputForm.vue";

export default {

    data: function () {
        return {
            contact: {
                name: '',
                photo: '',
                email: '',
                mobile: '',
                company: '',
                title: '',
                button: 'Create',
            },
            errors: [],
            showSuccess: '',
            showError: '',
        }
    },
    components: {
        InputForm
    },
    methods: {
        onSubmit() {
            const that = this;
            console.log(ajax_url.ajaxurl);
            jQuery.ajax({
                type: "POST",
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: "cm_insert_into_contact_table",
                    name: that.contact.name,
                    photo: that.contact.photo,
                    email: that.contact.email,
                    mobile: that.contact.mobile,
                    company: that.contact.company,
                    title: that.contact.title,
                    wpsfb_nonce: ajax_url.wpsfb_nonce,
                },
                success: function (data) {

                    that.showSuccess = 'Added value successfully';

                    that.mydata = data.data;
                    setTimeout(function () {
                        that.$router.push({
                            name: "ContactManager"
                        });
                    }, 500);

                },
                error: function (error) {
                    that.showError = 'Something went wrong';
                    that.errors = error.responseJSON.data;

                },
            });
        }
    }
};
</script>

<style scoped>
.h3 {
    margin-top: 20px;
    margin-left: 20px;
}
</style>
