<template>
    <div class="container"v-if="indexData.errors">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger mb-0" role="alert">{{ indexData.errors }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['indexData'],
}
</script>
<style>

</style>
