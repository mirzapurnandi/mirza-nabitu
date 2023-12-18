<template>
    <div class="card border-0 mt-5 w-50 m-auto rounded shadow">
        <div class="card-body">
            <form v-on:submit="submitLogin" method="POST">
                <h1 class="h3 mb-5 fw-normal">Please sign in</h1>

                <div class="alert alert-danger" role="alert" v-if="error_message != ''">
                    {{ error_message }}
                </div>

                <div class="form-floating mb-2">
                    <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" id="email"
                        placeholder="name@example.com" v-model="data.email">
                    <span class="error invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</span>
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" :class="{ 'is-invalid': errors.password }" id="password"
                        placeholder="Password" v-model="data.password">
                    <span class="error invalid-feedback" v-if="errors.password">{{ errors.password[0] }}</span>
                    <label for="password">Password</label>
                </div>

                <button class="btn btn-primary w-100" type="submit" :disabled="this.processing">
                    <div class="spinner-border spinner-border-sm" role="status" v-if="this.processing">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Sign in
                </button>
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
        ...mapState(['errors', 'processing']),
        ...mapState('auth', {
            error_message: state => state.error_message
        }),
        ...mapGetters(["isAuth"])
    },

    methods: {
        ...mapActions('auth', ['submit']),
        ...mapMutations('auth', ['CLEAR_ERROR_MESSAGE']),
        ...mapMutations(['CLEAR_ERRORS']),

        submitLogin(e) {
            e.preventDefault();
            this.CLEAR_ERRORS();
            this.CLEAR_ERROR_MESSAGE();
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