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
    <pre>{{ hideColumn }}</pre>
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
                        <select id="orderBy" class="form-control" v-model="contact.orderby">
                            <option v-for="value in orderby"  :value="value">{{ value }}</option>
                        </select>
                        <small class="danger" v-if="error.orderby">{{ error.orderby }}</small>
                    </div>
                    
                    <div><label>Hide Column:</label><br>
                        <span v-for="item in option_field">
                            <input type="checkbox" :value="item" v-model="hideColumn"> <span class="checkbox-label"> {{item}} </span> <br>
                        </span><br>

                        <div class="mb-2">
                            <input type="submit" class="btn btn-success" value="Save Changes">
                        </div>
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
            orderby: [],
            option_field: [],
            all_field_name: [],
            remove: [
                "Name",
                "Mobile",
                "Photo",
            ],
            default: {
                id: '1',
                color: '#4CAF50',
                limit: '5',
                page: '3',
                column: '1',
                orderby: 'id'

            },
            contacts: [],
            contact_field: [],
            error: '',
            id: '1'
        }
    },
    created() {

        this.fetchData();
        this.fetchColumn();
    },

    methods: {
        capitalizeWords(arr) {
            return arr.map(element => {
                return element.charAt(0).toUpperCase() + element.slice(1).toLowerCase();
            });
        },
        removeFromArray(original, remove) {
            return original.filter(value => !remove.includes(value));
        },

        fetchColumn() {

            const that = this;
            jQuery.ajax({
                type: "GET",
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: "cm_get_contact_lists",
                },
                success: function (data) {
                    that.contact_field = data.data[1];

                    that.all_field_name = Object.keys(that.contact_field);
                    that.field_name = that.removeFromArray(that.all_field_name, that.remove);
                    that.field_name = that.capitalizeWords(that.all_field_name);
                    that.orderby = that.capitalizeWords(that.all_field_name);
                    that.option_field = that.removeFromArray(that.field_name, that.remove);
                    // console.log(that.option_field);

                }
            });

        },

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

                    that.contact = data.data;
                    that.hideColumn = that.contact.column;
                    // that.option_field = Object.keys(that.contact);
                    console.log(that.option_field);

                },
                error: function (error) {
                    that.error = error.responseJSON.data;
                },
            });

        },
        submitChange() {

            const that = this;
            console.log(ajax_url.ajaxurl);
            jQuery.ajax({
                type: "POST",
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: "cm_insert_into_shortcode_table",
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
                    console.log("Error in inerting data");
                    that.error = error.responseJSON;
                },
            });
        },

        defaults() {
            this.contact = this.default;
            this.hideColumn = [];
            this.hideColumn.push("None");
        },
    }
}
</script>

<style scoped>
.danger {
    color: red;
}

.error {
    color: red;
}

form label {
    font-weight: bold;
    color: black;
}

.hide {
    display: none;
}
</style>
