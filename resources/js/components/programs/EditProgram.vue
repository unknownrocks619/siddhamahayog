<template>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <progress-bar :loading="loading"></progress-bar>
        <form-error :errors="errors"></form-error>
        <server-response :success="success" :response="serverResponse"></server-response>
        <form ref="meeting_form" @submit.prevent="submitForm" method="post">
            <div class="card">
                <div class="body">
                    <div class="row clearfix mt-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b for="account_name">Program Name
                                    <sup class='text-danger'>*</sup>
                                </b>
                                <input type="text" v-model="fields.program_name" class="form-control" name="program_name"
                                    id="program_name" require value="" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>Program Type
                                    <sup class='text-danger'>*</sup>
                                </b>
                                <select v-model="fields.program_type" name="program_type" id="program_type"
                                    class='form-control' required>
                                    <option value="paid">Paid</option>
                                    <option value="open">Open</option>
                                    <option value="registered_user">Registered User</option>
                                    <option value="club">Club</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div v-if="fields.program_type == 'paid'" class="row clearfix mt-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b for="account_name">Monthly Fee
                                    <sup class='text-danger'>*</sup>
                                </b>
                                <input type="text" v-model="fields.monthly_fee" class="form-control" name="monthly_fee"
                                    id="monthly_fee" require value="" />
                            </div>
                            <div v-if="this.serverError && this.serverError.monthly_fee" class="text-danger">
                                {{ this.serverError.monthly_fee[0] }}
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>Admission Fee
                                    <sup class='text-danger'>*</sup>
                                </b>
                                <input type="text" v-model="fields.admission_fee" class="form-control" name="admission_fee"
                                    id="admission_fee" require value="" />
                            </div>
                            <div v-if="this.serverError && this.serverError.admission_fee" class="text-danger">
                                {{ this.serverError.admission_fee[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix mt-3">

                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>Program Start Date
                                </b>
                                <input type="date" v-model="fields.program_duration_start" class="form-control"
                                    name="program_duration_start" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>Program Start Date
                                </b>
                                <input type="date" v-model="fields.program_duration_start" class="form-control"
                                    name="program_duration_end" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix mt-3">
                        <div class="col-lg-12 col-md-12 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>Write Something About Program
                                </b>
                                <textarea class="form-control" v-model="fields.description" name="description"
                                    id="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix mt-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>Promote
                                </b>

                                <div class="radio">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input v-model="fields.promote" type="radio" name="promote" id="promote_yes"
                                                value="yes">
                                            <label for="promote_yes" class='text-success'>
                                                Yes, Promote in Website
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" v-model="fields.promote" checked name="promote"
                                                id="promote_no" value="no">
                                            <label for="promote_no" class='text-danger'>
                                                No, Don't Promote in Website
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="fields.program_type == 'paid'" class="col-lg-6  col-md-6 col-sm-12 m-b-20">
                            <div class="form-group">
                                <b>Allow Access for Number days to unpaid user.
                                    <span class="text-danger">*</span>
                                </b>
                                <input type="number" required class="form-control" v-model="fields.overdue_allowed"
                                    name="overdue_allowed" id="overdue_allowed" />
                            </div>
                            <div v-if="this.serverError && this.serverError.overdue_allowed" class="text-danger">
                                {{ this.serverError.overdue_allowed[0] }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="footer clearfix mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class='btn btn-primary btn-block'>Update Program Detail</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import axios from 'axios'
import ProgressBar from '../ProgressBar.vue'
import FormError from '../FormError.vue'
import ServerResponse from '../ServerResponse.vue'

export default {
    components: { ProgressBar, FormError, ServerResponse },

    props: {
        upload_path: String,
        resource: {
            required: true,
            type: String
        }
    },
    data: function () {
        return {
            fields: JSON.parse(this.resource),
            loading: false,
            success: null,
            serverResponse: null,
            serverError: [],
            errors: [],
            batches: "loading..."
        }
    },
    mounted() {
        axios.get('/api/v1/batch/list').then(response => {
            this.batches = response.data.data;
        });
    },
    methods: {
        validateForm: function () {
            this.errors = [];

            if (this.fields.program_name == "") {
                this.errors.push('Please provide valid program name.');
            }

            if (this.fields.program_type == "paid" && (this.fields.admission_fee == "" || this.fields.monthly_fee == "")) {
                this.errors.push("Provide Monthly Fee and Admission Fee for program type PAID");
            }
        },

        submitForm: function () {
            this.loading = true;
            this.validateForm();
            if (this.errors.length) {
                window.scrollTo(0, 0);
                this.loading = false;
                return false;
            }
            axios.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            axios.post(this.upload_path, this.fields).then(response => {
                this.success = "alert_success";
                this.serverResponse = response.data.message;
                window.scrollTo(0, 0);

            }).catch(error => {
                this.success = "alert_error";

                if (error.response.status == 422) {
                    document.getElementById("app").scrollIntoView({ behavior: "smooth" });
                    this.errors.push('Check your data before submitting.');
                    this.serverError = error.response.data.errors;
                } else {
                    if (error.response) {
                        let response_error = error.response.data.errors
                        this.errors.push("Response Error:  " + error.response.statusText);
                    } else if (error.request) {
                        this.errors.push('Request Error : ' + error.response.statusText);
                    } else {
                        this.errors.push("Error: " + error.response.statusText);
                    }
                    window.scrollTo(0, 0);
                }
            })
            this.loading = false;

        }
    }
}
</script>
