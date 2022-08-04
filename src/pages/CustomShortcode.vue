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

    <div class="alert alert-danger" v-if="this.error.error" role="alert">
        <h2>{{ this.error.error }}</h2>
    </div>
    <div class="alert alert-success" v-if="this.success.length" role="alert">
        <h2>{{this.success}}</h2>
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
                        <select id="orderBy" class="form-control" v-model="contact.orderby">
                            <option v-for="value in conditionalOrderby" :value="value">{{ value }}</option>
                        </select>
                        <small class="danger" v-if="error.orderby">{{ error.orderby }}</small>
                    </div>

                    <div class="hideColumn"><label>Hide Column:</label><br>
                        <span v-for="item in conditionalHideColumn">
                            <input type="checkbox" :value="item" v-model="hideColumn"> <span class="checkbox-label"> {{item}} </span> <br>
                        </span>
                    </div><br>

                    <div class="mb-2">
                        <input type="submit" class="btn btn-success" value="Save Changes">
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

    data: function () {
        return {
            elementVisible: true,
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
            optionField: [],
            allFieldName: [],
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
                column: [],
                orderby: 'Name'

            },

            contacts: [],
            error: '',
            success: '',
            id: '1'
        }
    },
    mounted() {

        this.fetchData();
        this.fetchColumn();
    },
    computed: {
        conditionalOrderby() {
            var data = this.removeFromArray(this.orderby, this.hideColumn);
            return data;
        },
        conditionalHideColumn() {
            var data = this.removeFromArray(this.optionField, this.contact.orderby);
            return data;
        }
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
                    action: "cm_get_contact_field_name",
                },
                success: function (data) {
                    that.allFieldName = data.data.map(function (item) {
                        return item.Field;
                    });
                    that.capitalizedFieldName = that.capitalizeWords(that.allFieldName);
                    that.orderby = that.capitalizedFieldName.filter(function (item) {
                        return item !== 'Photo'
                    });
                    that.optionField = that.removeFromArray(that.capitalizedFieldName , that.remove);
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
                    action: "cm_insert_into_shortcode_settings",
                    id: that.id,
                    color: that.contact.color,
                    limit: that.contact.limit,
                    page: that.contact.page,
                    column: that.hideColumn,
                    orderby: that.contact.orderby,
                    wpsfb_nonce: ajax_url.wpsfb_nonce,
                },
                success: function (data) {
                    that.success = 'Updated value successfully';
                    that.mydata = data.data;
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                },
                error: function (error) {
                    that.error = error.responseJSON.data;
                    setTimeout(function () {
                        that.error.error = false;
                    }, 2000);
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

.hideColumn {
    overflow-y: scroll;
    height: 100px;
}
</style>
