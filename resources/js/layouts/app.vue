<template>
    <div>
        <comment-form @comment-added="loadComments"></comment-form>
        <div v-if="comments.length > 0">
            <h2>Comments:</h2>
            <comment v-for="comment in comments" :key="comment.id" :comment="comment" @comment-added="loadComments"></comment>
        </div>
        <div v-else>
            <p>No comments yet.</p>
        </div>
    </div>
</template>

<script>
import CommentForm from '../components/CommentForm.vue';
import Comment from '../components/Comment.vue';
import axios from 'axios';

export default {
    components: {
        CommentForm,
        Comment
    },
    data() {
        return {
            comments: []
        };
    },
    mounted() {
        this.loadComments();
    },
    methods: {
        async loadComments() {
            try {
                const response = await axios.get('/comments');
                this.comments = response.data;
            } catch (error) {
                console.error('Error loading comments:', error);
            }
        },
        async addComment() {
            await this.loadComments();
        }
    }
};
</script>
