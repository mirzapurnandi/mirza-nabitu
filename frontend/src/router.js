import { createRouter, createWebHistory } from "vue-router";
import store from "./store";

import Home from "./components/pages/Home.vue";
import Login from "./components/pages/Login.vue";

import IndexReminder from "./components/pages/reminder/Index.vue";
import DataReminder from "./components/pages/reminder/Data.vue";

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

    {
        path: "/reminder",
        component: IndexReminder,
        meta: { requiresAuth: true },
        children: [
            {
                path: "",
                name: "reminder.data",
                component: DataReminder,
                meta: { title: "Data Reminder" },
            },
            /* {
                path: "/add",
                name: "product.add",
                component: AddProduct,
                meta: { title: "Tambah Menu Cafe" },
            }, */
        ],
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
