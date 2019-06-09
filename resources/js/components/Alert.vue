<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger mb-0" role="alert" v-if="message">{{ message }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: null
        };
    },
    mounted() {
        this.$root.$on('indexLoaded', data => {
            this.message = data.errors;
        });
    }
}
</script>
<style>

</style>
