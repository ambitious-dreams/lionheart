<template>
    <div id="app">
        <vue-progress-bar></vue-progress-bar>
        <template v-if="indexData">
            <alert :indexData="indexData"></alert>
            <welcome-box :indexData="indexData"></welcome-box>
            <comments-box :indexData="indexData"></comments-box>
        </template>
    </div>
</template>

<script>
import Alert from './Alert.vue';
import WelcomeBox from './WelcomeBox.vue';
import CommentsBox from './Comment/CommentsBox.vue';

export default {
    data() {
        return {
            indexData: null,
        };
    },
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
                this.indexData = response.data;
            });
        }
    },
    created() {
        this.displayLoaderOnEveryRequest();
        this.index();
    },
    mounted() {
        this.$root.$on('logout', data => {
            axios.post(url('logout')).then(response => {
                this.index();
            });
        });
    }
}
</script>
<style>

</style>
