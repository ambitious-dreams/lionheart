<template>
    <section id="commentsBox" v-if="indexData.user">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <comments-list :indexData="indexData"></comments-list>
                    <create-comment
                        :indexData="indexData"
                        :isNew="true"
                    ></create-comment>
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
    props: ['indexData'],
}
</script>
<style>

</style>
