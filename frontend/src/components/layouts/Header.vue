<template>
    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li>
                        <router-link :to="{ name: 'home' }" class="nav-link px-2 text-secondary">
                            Home
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'reminder.data' }" class="nav-link px-2 text-secondary">
                            Reminder
                        </router-link>
                    </li>
                </ul>

                <div class="text-end">
                    <a href="javascript:void(0)" @click="logout" class="btn btn-outline-light me-2">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    methods: {
        ...mapActions('auth', ['signOut']),

        logout(e) {
            e.preventDefault();
            this.signOut().then(() => {
                this.$router.go('/login');
            });

        },
    },
}
</script>