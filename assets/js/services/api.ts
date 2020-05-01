import axios from 'axios';
import * as NProgress from "nprogress";

const instance = axios.create({
        baseURL: 'http://127.0.0.1:80/api',
        withCredentials: false,
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        }
    });


instance.interceptors.request.use(config => {
    NProgress.start();
    return config
});


instance.interceptors.response.use(response => {
    NProgress.done();
    return response
});

export default instance
