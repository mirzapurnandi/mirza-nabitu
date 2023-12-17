import axios from "axios";
import store from "./store.js";

const url = "http://localhost:3456/api";
const api = axios.create({
    baseURL: url,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

api.interceptors.request.use(
    function (config) {
        const token = store.state.token;
        if (token) config.headers.Authorization = `Bearer ${token}`;
        return config;
    },
    function (error) {
        return Promise.reject(error);
    }
);

export default api;
