<template>
    <div class="row" v-if="this.errors.length">
        <div class="col-md-12 alert alert-danger">
            <p >
                Error Processing Request
                <ul>
                    <li v-for="(error,index) in this.errors" :key="index">
                        {{ error }}
                    </li>
                </ul>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props : {
            errors : Array
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
