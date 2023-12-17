import { createApp } from "vue";
import Vuex from "vuex";

import auth from "./stores/auth.store";
import reminder from "./stores/reminder.store";
createApp({}).use(Vuex);

const store = new Vuex.Store({
    modules: {
        auth,
        reminder,
    },

    state: {
        token: localStorage.getItem("token"),
        errors: [],
    },

    getters: {
        isAuth: (state) => {
            return state.token != null && state.token != "null";
        },
    },

    mutations: {
        SET_TOKEN(state, payload) {
            state.token = payload;
        },
        SET_ERRORS(state, payload) {
            state.errors = payload;
        },
        CLEAR_ERRORS(state) {
            state.errors = [];
        },
    },
});

export default store;
