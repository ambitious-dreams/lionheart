<template>
    <div class="col-md-12 mb-2">
        <div class="card bg-light comment-item">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1">
                        <comment-item-user-image
                            :comment="comment"
                        ></comment-item-user-image>
                    </div>
                    <div class="col-md-11">
                        <comment-item-content
                            :comment="comment"
                            :reply2Parent="null"
                            @showReplyBox="showReplyBox"
                            @toggleReplies="toggleReplies"
                        ></comment-item-content>

                        <div class="replies" v-if="comment.replies.length && showReplies">
                            <div class="reply my-3" v-for="reply in comment.replies">
                                <div class="row">
                                    <div class="col-md-1">
                                        <comment-item-user-image
                                            :comment="reply"
                                        ></comment-item-user-image>
                                    </div>
                                    <div class="col-md-11">
                                        <comment-item-content
                                            :comment="reply"
                                            :reply2Parent="reply"
                                            @showReplyBox="showReplyBox"
                                            @toggleReplies="toggleReplies"
                                        ></comment-item-content>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <create-comment
                            v-if="showReplyCreate"
                            :parentComment="comment"
                            :parent2Comment="reply2Parent"
                            :indexData="indexData"
                            :isReply="true"
                            @hideReplyBox="hideReplyBox"
                        ></create-comment>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CreateComment from './CreateComment.vue';
import CommentItemUserImage from './CommentItemUserImage.vue';
import CommentItemContent from './CommentItemContent.vue';

export default {
    data() {
        return {
            showReplyCreate: false,
            reply2Parent: null,
            showReplies: false,
        };
    },
    props: {
        comment: {
            type: Object,
            required: true
        },
        indexData: {
            type: Object,
            required: true
        },
    },
    methods: {
        showReplyBox(reply2Parent) {
            this.showReplyCreate = true,
            this.reply2Parent = reply2Parent;
        },
        hideReplyBox() {
            this.showReplyCreate = false;
        },
        toggleReplies() {
            this.showReplies = !this.showReplies;
        }
    },
    components: {
        CreateComment,
        CommentItemUserImage,
        CommentItemContent,
    },
}
</script>
<style>

</style>