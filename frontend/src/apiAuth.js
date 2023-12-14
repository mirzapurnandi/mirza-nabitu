import axios from "axios";
const url = "http://localhost:2345/api";
const api = axios.create({
    baseURL: url,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
});

export default api;
