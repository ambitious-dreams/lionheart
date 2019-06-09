<template>
    <section id="commentsBox" v-if="indexData && indexData.user">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <comments-list></comments-list>
                    <create-comment></create-comment>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import CommentsList from './CommentsList.vue';
import CreateComment from './CreateComment.vue';

export default {
    components: {
        CommentsList,
        CreateComment
    },
    data() {
        return {
            indexData: null
        };
    },
    mounted() {
        this.$root.$on('indexLoaded', data => {
            this.indexData = data;
        });
    }
}
</script>
<style>

</style>
