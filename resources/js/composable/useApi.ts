import axios, { AxiosInstance } from "axios";
import nProgress from "nprogress";
import { useStorage } from "@vueuse/core";
import { useUserStore } from "@/stores/user";

let api: AxiosInstance;

export function createApi() {
    // Here we set the base URL for all requests made to the api
    api = axios.create({
        baseURL: import.meta.env.VITE_API_BASE_URL,
    });

    // We set an interceptor for each request to
    // include Bearer token to the request if user is logged in
    api.interceptors.request.use((config) => {
        const userSession = useUserStore();
        nProgress.start();

        if (userSession.isLoggedIn) {
            config.headers = {
                ...config.headers,
                Authorization: `Bearer ${userSession.token}`,
                Language: useStorage("locale", "uz").value,
            };
        }

        return config;
    });

    // We set an interceptor for each response to
    // check if user is logged in
    api.interceptors.response.use(
        function (response) {
            // Any status code that lie within the range of 2xx cause this function to trigger
            // Do something with response data
            nProgress.done();
            return response;
        },
        function (error) {
            const userSession = useUserStore();
            nProgress.done();

            if (error) {
                if (
                    error.response?.status ===
                    401 /* && !originalRequest._retry */
                ) {
                    userSession.setToken(undefined);
                    userSession.setUser(undefined);
                    location.href = "/";
                }

                throw error;
            }
        }
    );

    return api;
}

export function useApi() {
    if (!api) {
        createApi();
    }
    return api;
}
