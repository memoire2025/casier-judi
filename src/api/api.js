import axios from "axios";

const api = axios.create({
    baseURL : "http://casier-judiciaire.com",
    // withCredentials : true,
});

api.interceptors.request.use(async (config) => {
    let accessToken = localStorage.getItem("accessToken-casier");
    let userInfo = JSON.parse(localStorage.getItem('userInfo-casier'));

    if (accessToken) {
        
        if (userInfo.exp < Date.now() / 1000) {

            localStorage.removeItem("accessToken-casier");
            localStorage.removeItem('userInfo-casier');
            window.location.href = "/login";
            return Promise.reject(new Error("No refresh token"));

        }
        config.headers.Authorization = `Bearer ${accessToken}`;
    }
    return config;
}, error => Promise.reject(error));

export default api;

