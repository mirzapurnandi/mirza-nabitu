import api from "../api.js";
import apiAuth from "../apiAuth.js";

const state = () => ({
    error_message: "",
});

const mutations = {
    ERROR_MESSAGE(state, payload) {
        state.error_message = payload;
    },
    CLEAR_ERROR_MESSAGE(state) {
        state.error_message = "";
    },
};

const actions = {
    submit({ commit }, payload) {
        localStorage.setItem("token", null);
        commit("SET_TOKEN", null, {
            root: true,
        });

        return new Promise((resolve, reject) => {
            commit("SET_PROCESSING", true, { root: true });
            api.post("/session", payload)
                .then((response) => {
                    if (response.data.ok === true) {
                        localStorage.setItem(
                            "token",
                            response.data.data.access_token
                        );
                        localStorage.setItem(
                            "refresh_token",
                            response.data.data.refresh_token
                        );
                        commit("SET_TOKEN", response.data.data.access_token, {
                            root: true,
                        });
                    } else {
                        commit("SET_ERRORS", response.data.msg, {
                            root: true,
                        });
                    }
                    commit("SET_PROCESSING", false, { root: true });
                    resolve(response.data);
                })
                .catch((error) => {
                    console.log(error.response);
                    if (error.response.status === 422) {
                        commit("SET_ERRORS", error.response.data.msg, {
                            root: true,
                        });
                    } else if (error.response.status === 401) {
                        commit("ERROR_MESSAGE", error.response.data.msg);
                    } else {
                        commit("ERROR_MESSAGE", "Server Error");
                    }

                    commit("SET_PROCESSING", false, { root: true });
                });
        });
    },

    signOut({ commit }) {
        return new Promise((resolve, reject) => {
            apiAuth
                .post("/session/logout")
                .then(() => {
                    localStorage.setItem("token", null);
                    commit("SET_TOKEN", null, {
                        root: true,
                    });
                    resolve();
                })
                .catch(() => {
                    localStorage.setItem("token", null);
                    commit("SET_TOKEN", null, {
                        root: true,
                    });
                    resolve();
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
