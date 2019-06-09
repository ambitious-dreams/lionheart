<template>
    <div class="row mt-4 mb-4">
        <div class="col-md-12">
            <form @submit.prevent="store">
                <div class="form-group">
                    <textarea class="form-control" v-model="comment.content" rows="3" placeholder="Enter your message..."></textarea>
                    <div class="errors" v-if="errors && errors.content">
                        <span class="text-danger font-weight-bold" v-for="error in errors.content">
                            {{ error }}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Add Comment</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            comment: {},
            errors: []
        };
    },
    methods: {
        store() {
            axios
                .post(url('api/comments'), this.comment)
                .then(response => {
                    this.comment = {};
                    this.errors = [];
                    this.$root.$emit('commentCreated', response.data);
                })
                .catch(error => {
                    if (error.response) {
                        this.errors = error.response.data.errors;
                    }
                });
        }
    }
}
</script>
<style>

</style>
