<template>
    <div class="row">
        <div  v-if="this.success_status == 'alert_success'" class="col-md-12 alert alert-success">
            {{this.response_message}}
        </div>
        <div  v-else-if="this.success_status == 'alert_danger'" class="col-md-12 alert alert-danger">
            {{this.response_message}}
            <ul v-if="this.errors">
                <li v-for="(error,index) in this.errors" :key="index">
                    {{ error[0] }}
                </li>
            </ul>
        </div>
    </div>   
</template>

<script>
    export default {
        props : {
            success : [String, Boolean], // available options: error, success
            response : [String, Boolean],
            options : Object
        },
        data : function () {
            return {
                success_status : "",
                response_message : "",
                errors : [{}]
            }
        },
        watch : {
            options : function (newVal, oldVal) {
                this.errors = [{}];
                this.success_status = (newVal.status == 409 || newVal.status == 422) ? "alert_danger" : 'alert_success';

                if (this.success_status == "alert_success") {
                    this.response_message = newVal.message;
                } else if(newVal.status == 409) {
                    this.response_message = newVal.statusText;
                } else if(newVal.status == 422) {
                    this.response_message = "Error processing following request";
                    // this.response = newVal.status
                    this.errors = newVal.errors
                }

                if (this.success_status == "alert_success" && newVal.refresh == true) {
                    location.reload();
                }
            }
        }
    }
</script>
