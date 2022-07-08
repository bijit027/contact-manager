<template>
<div>
    <p class="h3 text-success fw-bold">Edit Contact</p>
    <h2 class="show-error">{{ error }}</h2>
    <InputForm v-bind:contact="contact" @form-submit="onSubmit" />
</div>
</template>

<script>
import InputForm from "../components/InputForm.vue";
export default {
    name: "EditContact",

    data: function () {
        return {
            contactId: this.$route.params.contactId,
            contact: {

                name: '',
                photo: '',
                email: '',
                mobile: '',
                company: '',
                title: '',
                button: ''

            },
            contacts: [],
            mydata: '',
            error: '',
        }
    },

    components: {
        InputForm
    },

    created: function () {
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
                that.contact = data.data[0];
                that.contact.button = 'Update';
            }
        });
    },

    methods: {
        onSubmit() {
            const that = this;
            jQuery.ajax({
                type: "POST",
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: "cm_insert_contact_table",
                    id: that.contactId,
                    name: that.contact.name,
                    photo: that.contact.photo,
                    email: that.contact.email,
                    mobile: that.contact.mobile,
                    company: that.contact.company,
                    title: that.contact.title,
                    wpsfb_nonce: ajax_url.wpsfb_nonce,
                },

                success: function (data) {
                    that.mydata = data.data;
                    that.$router.push({
                        name: "ContactManager"
                    });
                },
                error: function (error) {
                    that.error = error.responseJSON;
                },

            });

        }
    },
}
</script>

<style scoped>
.h3 {
    margin-top: 20px;
    margin-left: 20px;
}
</style>
