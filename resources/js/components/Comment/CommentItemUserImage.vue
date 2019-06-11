<template>
    <img :src="comment.user.avatar_url" class="img-fluid rounded-circle"/>
</template>
<script>
export default {
    props: {
        comment: {
            type: Object,
            required: true
        },
    },
}
</script>
<style>

</style>