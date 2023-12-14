<template>
    <div class="card border-0 mt-5 w-50 m-auto rounded shadow">
        <div class="card-body">
            <form v-on:submit="submitLogin" method="POST">
                <h1 class="h3 mb-5 fw-normal">Please sign in</h1>

                <div class="form-floating mb-2">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        v-model="data.email">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                        v-model="data.password">
                    <label for="floatingPassword">Password</label>
                </div>

                <button class="btn btn-primary w-100" type="submit">Sign in</button>
            </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapGetters, mapState } from "vuex";
export default {
    name: 'Login',
    data() {
        return {
            data: {
                email: "",
                password: ""
            },
        };
    },

    created() {
        if (this.isAuth) {
            this.$router.push({ name: "home" });
        }
    },

    computed: {
        ...mapState(["errors"]),
        ...mapGetters(["isAuth"])
    },

    methods: {
        ...mapActions('auth', ['submit']),
        ...mapMutations(['CLEAR_ERRORS']),

        submitLogin(e) {
            e.preventDefault();
            this.CLEAR_ERRORS();
            this.submit(this.data).then(() => {
                if (this.isAuth) {
                    this.CLEAR_ERRORS();
                    this.$router.go('/');
                }
            });
        }
    },
}
</script>