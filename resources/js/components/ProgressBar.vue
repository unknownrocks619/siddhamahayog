<template>
    <div class="row" v-if="this.loading == true">
        <div class="col-md-12">
            <div class="progress m-b-5">
                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"> <span class="sr-only">Processing Request Please Wait</span> </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : {
            loading : false
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
