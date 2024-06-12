<template>
    <div>
        <br>
        <form @submit.prevent="submitComment">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">User Name:</label>
                    <input type="text" id="username" v-model="username" class="form-control">
                    <div class="invalid-feedback text-danger" v-if="errors.username">{{ errors.username[0] }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" id="email" v-model="email" class="form-control">
                    <div class="invalid-feedback text-danger" v-if="errors.email">{{ errors.email[0] }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="homepage" class="form-label">Home page:</label>
                    <input type="url" id="homepage" v-model="homepage" class="form-control">
                    <div class="invalid-feedback text-danger" v-if="errors.homepage">{{ errors.homepage[0] }}</div>
                    <br>
                </div>
                <div :id="'captcha_' + parentId" class="col-md-6 mb-3">
                    <div style="display: flex; align-items: center;margin-top: 25px;">
                        <label class="form-label">Captcha:</label>

                        <img src="https://i0.wp.com/appetito.by/wp-content/plugins/payment-qr-woo/assets/loader.gif" alt="Loading..." class="captcha-placeholder">
                        <img :src="captchaImageUrl" alt="Loading..." style="margin-left: 10px;display: none;" class="captcha-image">
                        <input type="text" :id="captchaId" v-model="captcha" class="form-control" style="width: 60px; margin-left: 0px;" required>
                    </div>
                    <div class="invalid-feedback text-danger" v-if="errors.captcha">{{ errors.captcha[0] }}</div>
                    <br>
                </div>

            </div>
            <textarea id="comment-text" v-model="text" class="form-control" placeholder="Leave your comment" rows="5"></textarea>
            <div class="invalid-feedback text-danger" v-if="errors.text">{{ errors.text[0] }}</div>
            <br>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
        <div class="clearfix"></div>
        <hr>
    </div>
</template>

<script>
export default {
    props: {
        parentId: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            username: '',
            email: '',
            homepage: '',
            captcha: '',
            text: '',
            errors: {},
            captchaId: 'captcha_' + this.parentId,
            captchaImageUrl: '',
        };
    },
    mounted() {
        this.loadCaptchaImage();
    },
    methods: {
        async loadCaptchaImage() {
            try {
                console.log(this.captchaId);
                const captchaImage = document.querySelector(`div#${this.captchaId} .captcha-image`);
                const captchaPlaceholder = document.querySelector(`div#${this.captchaId} .captcha-placeholder`);

                captchaImage.style.display = 'none';
                captchaPlaceholder.style.display = 'inline';

                const tmpId = this.captchaId;
                const response = await axios.get('/captcha-image', { params: { tmpId }, responseType: 'blob' });

                this.captchaImageUrl = URL.createObjectURL(response.data);

                captchaImage.style.display = 'inline';
                captchaPlaceholder.style.display = 'none';

            } catch (error) {
                console.error('Error when uploading CAPTCHA image:', error);
            }
        },
        async submitComment() {
            try {
                const response = await axios.post('/add-comment', {
                    username: this.username,
                    email: this.email,
                    homepage: this.homepage,
                    captcha: this.captcha,
                    text: this.text,
                    parent_id: this.parentId
                });
                console.log(response.data.message);

                this.clearForm();

                this.loadCaptchaImage();

                this.$emit('comment-added');

            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                    if (this.errors.captcha) {
                        this.$nextTick(() => {
                            this.$refs.captchaInput.focus();
                        });
                    }
                }
            }
        },
        clearForm() {
            this.username = '';
            this.email = '';
            this.homepage = '';
            this.captcha = '';
            this.text = '';
            this.errors = {};
        }
    }
};
</script>
