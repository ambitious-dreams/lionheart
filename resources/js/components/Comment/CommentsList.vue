<template>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-outline-secondary btn-block mb-2" @click="getMore" v-if="olderCommentsCount" :disabled="getMoreBtnDisabled">
                Older comments ({{ olderCommentsCount }})
            </button>
        </div>
        <div class="col-md-12 text-center" v-if="!comments.length">
            <img :src="loaderImage" alt="loading">
        </div>
        <template v-else>
            <comment-item
                v-for="comment in comments"
                :comment="comment"
                :key="comment.id"
                :indexData="indexData"
            ></comment-item>
        </template>
    </div>
</template>

<script>
import CommentItem from './CommentItem.vue';

export default {
    data() {
        return {
            comments: [],
            totalCommentsCount: 0,
            getMoreBtnDisabled: false,
        };
    },
    props: ['indexData'],
    computed: {
        olderCommentsCount: function () {
          return this.totalCommentsCount - this.comments.length;
        },
        loaderImage() {
            return url('images/loader.gif');
        }
    },
    methods: {
        index() {
            axios.get(url('api/comments')).then(response => {
                this.comments = response.data.comments;
                this.comments.reverse();
                this.totalCommentsCount = response.data.totalCommentsCount;
            });
        },
        getMore() {
            this.getMoreBtnDisabled = true;
            axios.get(url('api/get-more-comments'), {params: {skip: this.comments.length}}).then(response => {
                let items = response.data;
                items.reverse();
                this.comments = items.concat(this.comments);
                this.getMoreBtnDisabled = false;
            });
        },
    },
    components: {
        CommentItem
    },
    created() {
        this.index();
    },
    mounted() {
        this.$root.$on('commentCreated', data => {
            if (!data.parent_id) {
                this.comments.push(data);
                this.totalCommentsCount++;
            } else {
                let parentComment = this.comments.filter(comment => {
                    return comment.id === data.parent_id;
                });
                parentComment = parentComment[0];
                parentComment.replies.push(data);
            }
        });
    }
}
</script>
<style>

</style>
