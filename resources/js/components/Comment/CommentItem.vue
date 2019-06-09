<template>
    <div class="col-md-12 mb-2">
        <div class="card bg-light comment-item">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1">
                        <img :src="comment.user.avatar_url" class="img-fluid rounded-circle"/>
                    </div>
                    <div class="col-md-11">
                        <h5 class="card-title mb-0">{{ comment.user.name }} {{ comment.user.surname }}</h5>
                        <small class="text-muted">{{ comment.created_at }}</small>
                        <p class="card-text">{{ comment.content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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