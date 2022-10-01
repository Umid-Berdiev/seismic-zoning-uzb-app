import { defineStore } from "pinia";
import { reactive } from "vue";

export const useMapStore = defineStore("mapStore", {
    state: () => ({
        selectedArea: reactive({
            soato: "",
        }),
    }),
    getters: {},
    actions: {},
});
