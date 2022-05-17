<template>
    <div class="card">
        <form method="post" ref='new_fee' @submit.prevent="submitForm">
            <div class="header pt-0">
                <h2>
                    <strong>Setup</strong> Fee Structure
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-12">
                        <progress-bar :loading="loading"></progress-bar>
                        <form-error :errors="errors"></form-error>
                        <server-response :options='responseFields' :success="responseFields.success" :response="responseFields.serverResponse"></server-response>

                        <div class="form-group">
                            <label for="admission_fee" class="label-control">
                                Admission Fee
                                <sup class="text-danger">*</sup>
                            </label>
                            <input v-model="fields.admission_fee" type="text" class="form-control" name="admission_fee" id="admission_fee">
                            <div id="admission_fee_error"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="admission_fee" class="label-control">
                                Monthly Fee
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" v-model="fields.monthly_fee" class="form-control" name="monthly_fee" id="monthly_fee" />
                            <div id="monthly_fee_error"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Update Fee Structure</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import FormError from '../FormError.vue';
import ProgressBar from '../ProgressBar.vue';
import ServerResponse from '../ServerResponse.vue';
//import ServerResponse from '../ServerResponse.vue';

export default {
  components: { ProgressBar, FormError, ServerResponse },
    props : {
        action : String
    },
    mounted() {
        console.log(this.action);
    },
    data : function (){
        return{
                fields : {
                    admission_fee : null,
                    monthly_fee : null
                },
                responseFields : {
                    success : "",
                    serverResponse : "",
                    options : null,
                },
                loading: false,
                success : null,
                serverResponse : null,
                serverError : [],
                errors : []
            }
    },
    methods : {
        validateForm() {
            this.errors = [];
            if (! this.fields.admission_fee) {
                this.errors.push('Admission Fee is required');
            }

            if (! this.fields.monthly_fee ) {
                this.errors.push("Monthly Fee is required");
            }
        },
        submitForm() {
            this.loading = true;
            this.validateForm();
            let scroll_id = document.getElementById("app");
            if (this.errors.length) {
                window.scrollTo(scroll_id.offsetLeft,scroll_id.offsetTop);
                this.loading = false;
                return false;
            }
            axios.defaults.headers.post["X-CSRF-TOKEN"] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post(this.action,this.fields).then(response => {
                this.success = "alert_success",
                this.serverResponse = response.data.message,
                this.responseFields  = response.data;
                this.responseFields.status = response.status
                this.fields = {
                    admission_fee : null,
                    monthly_fee : null
                }
            }).catch(error => {
                this.responseFields = error.response.data;
                this.responseFields.status = error.response.status;
            });
            this.loading = false;
            window.scrollTo(scroll_id.offsetLeft,scroll_id.offsetTop);
        }
    }
}
</script>