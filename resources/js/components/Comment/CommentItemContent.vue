<template>
    <div class="comment-content">
        <h5 class="card-title mb-0">
            {{ comment.user.name }} {{ comment.user.surname }}
            <a href="#" @click.prevent="showReplyBox(reply2Parent)" class="btn btn-secondary btn-sm">
                <i class="fas fa-reply"></i>
                Reply
            </a>
            <a href="#" v-if="comment.replies && comment.replies.length" @click.prevent="toggleReplies()" class="btn btn-secondary btn-sm">
                {{ comment.replies.length }} replies
            </a>
        </h5>
        <small class="text-muted">{{ comment.created_at }}</small>
        <p class="card-text">
            {{ formattedContent }}
            <a href="" @click.prevent="seeFullContent = true" v-if="contentIsTooLong && !seeFullContent">
                Read more
            </a>
        </p>
    </div>
</template>
<script>
export default {
    data() {
        return {
            seeFullContent: false,
            maxContentLength: 30,
        };
    },
    props: {
        comment: {
            type: Object,
            required: true
        },
        reply2Parent: {
            required: false
        },
    },
    computed: {
        formattedContent: function () {
            return this.seeFullContent || !this.contentIsTooLong
                ? this.comment.content
                : this.comment.content.substring(0, this.maxContentLength) + '...';
        },
        contentIsTooLong: function () {
            return this.comment.content.length > this.maxContentLength;
        }
    },
    methods: {
        showReplyBox(reply2Parent) {
            this.$emit('showReplyBox', reply2Parent);
        },
        toggleReplies() {
            this.$emit('toggleReplies');
        }
    },
}
</script>
<style>

</style>