import api from "../api.js";

const actions = {
    submit({ commit }, payload) {
        localStorage.setItem("token", null);
        commit("SET_TOKEN", null, {
            root: true,
        });
        commit("ASSIGN_USER_AUTH", null, {
            root: true,
        });
        commit("SET_PROCESSING", true, {
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
                        commit("SET_ERRORS", response.data.data, {
                            root: true,
                        });
                    }

                    resolve(response.data);
                })
                .catch((error) => {
                    commit("SET_ERRORS", error.response.data, { root: true });
                });
        });
    },
};

export default {
    namespaced: true,
    actions,
};
