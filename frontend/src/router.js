import { createRouter, createWebHistory } from "vue-router";
import Home from "./components/pages/Home.vue";
import Login from "./components/pages/Login.vue";
import store from "./store";

const routes = [
    {
        path: "/login",
        name: "login",
        component: Login,
    },

    {
        path: "/",
        name: "home",
        component: Home,
        meta: {
            title: `Beranda`,
            requiresAuth: true,
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

//Navigation Guards
router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!store.getters.isAuth) {
            next({
                name: "login",
            });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
