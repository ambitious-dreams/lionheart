<template>
    <section id="welcomeBox">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron">
                        <h1 class="display-4">Lionheart</h1>
                        <p class="lead">
                            Yes,
                            <a href="https://www.youtube.com/watch?v=YdcnTURNoHM" target="_blank">
                                Lionheart
                                <i class="fas fa-heart"></i>
                            </a>
                        </p>
                        <hr class="my-4">
                        <template v-if="!indexData || !indexData.user">
                            <p>Please login first!</p>
                            <a class="btn btn-primary btn-lg" :href="url('login/facebook')" role="button">
                                <i class="fab fa-facebook-square"></i>
                                Login with Facebook
                            </a>
                            <a class="btn btn-danger btn-lg" :href="url('login/google')" role="button">
                                <i class="fab fa-google"></i>
                                Login with Google
                            </a>
                        </template>
                        <template v-else>
                            <div class="row">
                                <div class="col-md-1">
                                    <img :src="indexData.user.avatar_url" class="img-fluid rounded-circle"/>
                                </div>
                                <div class="col-md-11">
                                    <h5 class="card-title mb-0">{{ indexData.user.name }} {{ indexData.user.surname }}</h5>
                                    <small class="d-block">Member since {{ indexData.user.created_at }}</small>
                                    <a href="#" @click.prevent="logout" class="d-inline-block">Logout</a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            indexData: null
        };
    },
    methods: {
        url(path) {
            return url(path);
        },
        logout() {
            axios.post(url('logout')).then(response => {
                this.$root.$emit('logout');
            });
        }
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
