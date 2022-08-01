<template>
<div>
    <div class="container mt-3">
        <div class="row">
            <div class="col">
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
                <form @submit.prevent="onSubmit">
                    <div class="mb-2">
                        <label class="required">*</label><label>Enter your name</label>
                        <input v-model="contact.name" type="text" class="form-control" placeholder="name">
                    </div>
                    <small class="danger" v-if="errors.name">{{ errors.name }}</small>
                    <div class="mb-2">
                        <label class="required">*</label><label>Enter image url</label>
                        <input v-model="contact.photo" type="text" class="form-control" placeholder="Photo URL">
                    </div>
                    <small class="danger" v-if="errors.photo">{{ errors.photo }}</small>
                    <div class="mb-2">
                        <label class="required">*</label><label>Enter email address</label>
                        <input v-model="contact.email" type="email" class="form-control" placeholder="Email">
                    </div>
                    <small class="danger" v-if="errors.email">{{ errors.email }}</small>
                    <div class="mb-2">
                        <label class="required">*</label><label>Enter phone number</label>
                        <input v-model="contact.mobile" type="number" class="form-control" placeholder="Mobile">
                    </div>
                    <small class="danger" v-if="errors.mobile">{{ errors.mobile }}</small>
                    <div class="mb-2">
                        <label class="required">*</label><label>Enter company name</label>
                        <input v-model="contact.company" type="text" class="form-control" placeholder="Company">
                    </div>
                    <small class="danger" v-if="errors.company">{{ errors.company }}</small>
                    <div class="mb-2">
                        <label class="required">*</label><label>Enter title</label>
                        <input v-model="contact.title" type="text" class="form-control" placeholder="Title">
                    </div>
                    <small class="danger" v-if="errors.title">{{ errors.title }}</small>
                    <div class="mb-2">
                        <input type="submit" class="btn btn-success" :value="contact.button">
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <img :src="contact.photo" alt="" class="contact-img">
            </div>
        </div>
    </div>

</div>
</template>

<script>
export default {

    props: ['contact','errors'],
    emits: ["form-submit"],
    methods: {
        onSubmit() {
            this.$emit("form-submit", this.contact);
        }
    },
}
</script >

<style>
.danger {
    color: red;
}

.required {
    color: red;
}
</style>
