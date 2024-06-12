<template>
    <li class="media" style="list-style: none;">
        <div class="comment">
            <a href="#" class="pull-left">
                <img :src="comment.avatar || defaultAvatar" alt="" class="img-circle">
            </a>
            <div class="media-body">
                <strong class="text-success">{{ comment.username }} &nbsp;</strong>
                <span class="text-muted">
                    <small class="text-muted">{{ formatDate(comment.created_at) }}</small>
                </span>
                <p>
                    {{ comment.text }}
                </p>
                <button @click="toggleReplyForm" class="btn btn-link btn-sm">Ответить</button>

                <div v-if="replyFormVisible">
                    <comment-form :parentId="comment.id" @comment-added="handleReplyAdded"></comment-form>
                </div>
                <ul class="media-list" v-if="comment.children_recursive && comment.children_recursive.length > 0">
                    <comment v-for="reply in comment.children_recursive" :key="reply.id" :comment="reply" @comment-added="handleReplyAdded"></comment>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </li>
</template>

<script>
import CommentForm from './CommentForm.vue';

export default {
    components: {
        CommentForm
    },
    props: {
        comment: {
            type: Object,
            required: true
        }
    },
    computed: {
        captchaId() {
            return `captcha_${this.parentId}`;
        }
    },
    data() {
        return {
            replyFormVisible: false,
            defaultAvatar: 'https://bootstraptema.ru/snippets/element/2016/comments/com-1.jpg'
        };
    },
    methods: {
        formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();

            return `${day}.${month}.${year}`;
        },
        toggleReplyForm() {
            this.replyFormVisible = !this.replyFormVisible;
        },
        async handleReplyAdded() {
            this.replyFormVisible = false;
            this.$emit('comment-added', this.comment.id);
        }
    }
};
</script>
