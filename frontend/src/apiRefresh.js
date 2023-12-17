import axios from "axios";
import store from "./store.js";

const url = "http://localhost:3456/api";
const api = axios.create({
    baseURL: url,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem("refresh_token")}`,
    },
});

const apiProfile = axios.create({
    baseURL: url,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

apiProfile.interceptors.request.use(
    function (config) {
        const token = store.state.token;
        if (token) config.headers.Authorization = `Bearer ${token}`;
        return config;
    },
    function (error) {
        return Promise.reject(error);
    }
);

export const apiRefresh = {
    async refresh() {
        const datas = await api.put("/session");
        return datas.data.data.access_token;
    },
};

export const getProfile = {
    async profile() {
        const datas = await apiProfile.get("/session/profile");
        // console.log(datas);
        return datas.data;
    },
};
