import { createRouter, createWebHistory } from "vue-router";
import store from "./store";

import Home from "./components/pages/Home.vue";
import Login from "./components/pages/Login.vue";

import IndexReminder from "./components/pages/reminder/Index.vue";
import DataReminder from "./components/pages/reminder/Data.vue";
import AddReminder from "./components/pages/reminder/Add.vue";
import EditReminder from "./components/pages/reminder/Edit.vue";

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
            {
                path: "add",
                name: "reminder.add",
                component: AddReminder,
                meta: { title: "Create Reminder" },
            },
            {
                path: "edit/:id",
                name: "reminder.edit",
                component: EditReminder,
                meta: { title: "Edit Reminder" },
            },
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
