import axios from "axios";
const url = "http://localhost:3456/api";
const api = axios.create({
    baseURL: url,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

export default api;
