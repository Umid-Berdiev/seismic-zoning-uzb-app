import { defineStore } from "pinia";
import { reactive } from "vue";

export const useUserStore = defineStore("userStore", {
    state: () => ({
        user: reactive({
            id: "",
            email: "",
            username: "",
            first_name: "",
            last_name: "",
        }),
    }),
    getters: {},
    actions: {},
});
