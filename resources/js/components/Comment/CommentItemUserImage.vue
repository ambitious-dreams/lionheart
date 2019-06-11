<template>
    <img :src="comment.user.avatar_url" class="img-fluid rounded-circle user-image"/>
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
    .user-image {
        max-height: 100px;
    }
</style>