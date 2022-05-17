<template>
    <div class="row" v-if="this.success == 'alert_success'">
        <div class="col-md-12 alert alert-success">
            {{ this.response }}
        </div>
    </div>
   
</template>

<script>
    export default {
        props : {
            success : String, // available options: error, success
            response : String
            // display: Boolean
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
