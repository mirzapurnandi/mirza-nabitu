import apiAuth from "../apiAuth.js";
import { apiRefresh, getProfile } from "../apiRefresh.js";

const state = () => ({
    reminder: [],
});

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.reminder = payload;
    },
};

const actions = {
    getReminder({ commit }) {
        return new Promise(async (resolve, reject) => {
            await getProfile.profile().catch(async (error) => {
                await apiRefresh.refresh().then((response) => {
                    console.log(response);
                    commit("SET_TOKEN", response, {
                        root: true,
                    });
                    resolve();
                });
            });
            await apiAuth
                .get("/reminders")
                .then((response) => {
                    commit("ASSIGN_DATA", response.data.data.reminders);
                    resolve(response.data.data);
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                        localStorage.setItem("token", null);
                        localStorage.setItem("refresh_token", null);
                        commit("SET_TOKEN", null, {
                            root: true,
                        });
                        resolve();
                    }
                });
        });
    },

    /* createProduct({ commit }, payload) {
        commit("SET_PROCESSING", true, { root: true });
        return new Promise((resolve, reject) => {
            apiAuth
                .post("/product/insert", payload)
                .then((response) => {
                    commit("CLEAR_ERRORS", "", { root: true });
                    resolve(response.data);
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        commit("SET_ERRORS", error.response.data.result, {
                            root: true,
                        });
                    }
                });
            commit("SET_PROCESSING", false, { root: true });
        });
    }, */
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};
