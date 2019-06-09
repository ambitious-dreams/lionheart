<template>
    <div id="app">
        <vue-progress-bar></vue-progress-bar>
        <alert></alert>
        <welcome-box></welcome-box>
        <comments-box></comments-box>
    </div>
</template>

<script>
import Alert from './Alert.vue';
import WelcomeBox from './WelcomeBox.vue';
import CommentsBox from './Comment/CommentsBox.vue';

export default {
    components: {
        Alert,
        WelcomeBox,
        CommentsBox
    },
    methods: {
        displayLoaderOnEveryRequest() {
            axios.interceptors.request.use(config => {
                this.$Progress.start();
                return config;
            }, error => {
                this.$Progress.finish();
                return Promise.reject(error);
            });

            axios.interceptors.response.use(response => {
                this.$Progress.finish();
                return response;
            }, error => {
                this.$Progress.finish();
                return Promise.reject(error);
            });
        },
        index() {
            axios.get(url('api/index')).then(response => {
                this.$root.$emit('indexLoaded', response.data);
            });
        }
    },
    created() {
        this.displayLoaderOnEveryRequest();
        this.index();
    },
    mounted() {
        this.$root.$on('logout', data => {
            this.index();
        });
    }
}
</script>
<style>

</style>
