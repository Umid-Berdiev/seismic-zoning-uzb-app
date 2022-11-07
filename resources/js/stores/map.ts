import { defineStore } from "pinia";
import { reactive, ref } from "vue";

export const useMapStore = defineStore("mapStore", {
    state: () => ({
        selectedArea: reactive({
            soato: "main",
        }),
    }),
    getters: {},
    actions: {},
});
