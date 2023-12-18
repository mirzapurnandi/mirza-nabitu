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
    viewReminder({ commit }, payload) {
        return new Promise(async (resolve, reject) => {
            await getProfile.profile().catch(async () => {
                await apiRefresh.refresh().then((response) => {
                    commit("SET_TOKEN", response, {
                        root: true,
                    });
                    resolve();
                });
            });
            await apiAuth.get(`/reminders/${payload}`).then((response) => {
                resolve(response.data);
            });
        });
    },

    getReminder({ commit }) {
        return new Promise(async (resolve, reject) => {
            await getProfile.profile().catch(async () => {
                await apiRefresh.refresh().then((response) => {
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

    createReminder({ commit }, payload) {
        commit("SET_PROCESSING", true, { root: true });
        return new Promise(async (resolve, reject) => {
            await getProfile.profile().catch(async () => {
                await apiRefresh.refresh().then((response) => {
                    commit("SET_TOKEN", response, {
                        root: true,
                    });
                });
            });

            await apiAuth
                .post("/reminders", payload)
                .then((response) => {
                    commit("CLEAR_ERRORS", "", { root: true });
                    resolve(response.data);
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        commit("SET_ERRORS", error.response.data.msg, {
                            root: true,
                        });
                    }
                });
            commit("SET_PROCESSING", false, { root: true });
        });
    },

    removeReminder({ commit }, payload) {
        return new Promise(async (resolve, reject) => {
            await getProfile.profile().catch(async () => {
                await apiRefresh.refresh().then((response) => {
                    commit("SET_TOKEN", response, {
                        root: true,
                    });
                });
            });
            await apiAuth.delete(`/reminders/${payload}`).then((response) => {
                resolve(response.data);
            });
        });
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};
