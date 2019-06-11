<template>
    <div class="row mt-4 mb-4">
        <div class="col-md-1">
            <img :src="indexData.user.avatar_url" class="img-fluid rounded-circle"/>
        </div>
        <div class="col-md-11">
            <form @submit.prevent="store">
                <input v-if="isReply" type="hidden" v-model="comment.parent_id">
                <div class="form-group">
                    <textarea class="form-control" v-model="comment.content" rows="2" placeholder="Enter your message..."></textarea>
                    <div class="errors mt-1" v-if="errors && errors.content">
                        <span class="text-danger font-weight-bold" v-for="error in errors.content">
                            {{ error }}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Add Comment</button>
                    <button class="btn btn-secondary" type="button" v-if="parentComment" @click="hideReplyBox">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
        };
    },
    computed: {
        comment: function () {
            return {
                parent_id: this.parentComment
                    ? this.parentComment.id
                    : null,
                content: this.parent2Comment
                    ? '@' + this.parent2Comment.user.name + ' ' + this.parent2Comment.user.surname + ' '
                    : null,
            };
        }
    },
    props: [
        'indexData',
        'parentComment',
        'parent2Comment',
        'isNew',
        'isReply',
    ],
    methods: {
        store() {
            axios
                .post(url('api/comments'), this.comment)
                .then(response => {
                    this.comment.content = null;
                    this.errors = [];
                    this.$root.$emit('commentCreated', response.data);
                })
                .catch(error => {
                    if (error.response) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        hideReplyBox() {
            this.$emit('hideReplyBox');
        },
    },
}
</script>
<style>

</style>
