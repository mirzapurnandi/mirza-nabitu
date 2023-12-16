import api from "../api.js";
import apiAuth from "../apiAuth.js";

const actions = {
    submit({ commit }, payload) {
        localStorage.setItem("token", null);
        commit("SET_TOKEN", null, {
            root: true,
        });
        commit("ASSIGN_USER_AUTH", null, {
            root: true,
        });

        return new Promise((resolve, reject) => {
            api.post("/session", payload)
                .then((response) => {
                    if (response.data.ok === true) {
                        localStorage.setItem(
                            "token",
                            response.data.data.access_token
                        );
                        commit("SET_TOKEN", response.data.data.access_token, {
                            root: true,
                        });
                    } else {
                        commit("SET_ERRORS", response.data.msg, {
                            root: true,
                        });
                    }

                    resolve(response.data);
                })
                .catch((error) => {
                    commit("SET_ERRORS", error.response.data.msg, {
                        root: true,
                    });
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
    actions,
};
