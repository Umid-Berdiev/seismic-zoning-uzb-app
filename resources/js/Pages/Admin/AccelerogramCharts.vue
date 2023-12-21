<script setup lang="ts">
import { computed, onMounted, ref, watch } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { useNotyf } from "@/composable/useNotyf";
import BaseBlock from "@/Components/BaseBlock.vue";
import InputLabel from "@/Components/InputLabel.vue";
import VueSelect from "vue-select";
import { Inertia } from "@inertiajs/inertia";
import LineChart from "@/Components/Charts/LineChart.vue";

const props = withDefaults(
    defineProps<{
        list: any[];
        regions: any[];
    }>(),
    {
        list: () => [],
        regions: () => [],
    }
);

const notif = useNotyf();
const formFields = useForm({
    region_soato: "1703",
    accuracy: 90,
});
const accuracies = ref([
    {
        label: "90%",
        value: 90,
    },
    {
        label: "95%",
        value: 95,
    },
    {
        label: "98%",
        value: 98,
    },
    {
        label: "99%",
        value: 99,
    },
]);

const selectedRegion = ref(props.regions[0]);
const selectedAccuracy = ref(accuracies.value[0]);
const data = computed(() => {
    const filteredData = props.list;
    return {
        labels: filteredData.map((item) => Number(item.t_sec_a)),
        datasets: [
            {
                label: "E (cm/s2)",
                data: filteredData.map((item) => Number(item.e_cm_s2)),
                // backgroundColor: ["#FF8B26", "#FFC533", "#285FD3"],
                // hoverBackgroundColor: ["#FF8B26", "#FFC533", "#285FD3"],
                // borderWidth: 5,
                // borderColor: "#fff",
                // borderColor: "rgb(75, 192, 192)",
                fill: false,
                stepped: false,
                tension: 0.7,
            },
            {
                label: "N (cm/s2)",
                data: filteredData.map((item) => Number(item.n_cm_s2)),
                fill: false,
                stepped: false,
                tension: 0.7,
            },
            {
                label: "Z (cm/s2)",
                data: filteredData.map((item) => Number(item.z_cm_s2)),
                fill: false,
                stepped: false,
                tension: 0.7,
            },
        ],
    };
});

onMounted(() => {
    // Remove labels from
    document.querySelectorAll("#datasetLength label").forEach((el) => {
        el.remove();
    });

    // Replace select classes
    let selectLength = document.querySelector("#datasetLength select");

    if (selectLength) {
        selectLength.classList = "";
        selectLength.classList.add("form-select");
    }
});

watch(
    () => selectedRegion.value,
    (newValue) => {
        formFields.region_soato = newValue?.soato;
    }
);

watch(
    () => selectedAccuracy.value,
    (newValue) => {
        formFields.accuracy = newValue?.value;
    }
);

watch(formFields, (newValue) => {
    if (newValue) {
        Inertia.reload({
            data: {
                region_soato: newValue.region_soato,
                accuracy: newValue.accuracy,
            },
        });
    }
});
</script>

<template>
    <div class="content">
        <BaseBlock>
            <div class="row pb-3">
                <div class="col-md-6">
                    <InputLabel value="Viloyatlar ro'yhati" />
                    <VueSelect
                        v-model="selectedRegion"
                        :options="regions"
                        label="name_uz"
                        placeholder="Viloyatni tanlang"
                    />
                </div>
                <div class="col-md-6">
                    <InputLabel value="Aniqlik darajasi" />
                    <VueSelect
                        v-model="selectedAccuracy"
                        :options="accuracies"
                        placeholder="Aniqlik darajasini tanlang"
                    />
                </div>
            </div>
        </BaseBlock>

        <BaseBlock title="Akselerogramma diagrammasi" content-full>
            <div v-if="props.list?.length == 0" class="text-center">
                {{ $t("No_data") }}
            </div>
            <div v-else class="row">
                <div class="col-md-12">
                    <LineChart type="line" :data="data" />
                </div>
            </div>
        </BaseBlock>
    </div>
</template>

<style lang="scss">
// Vue Select + Custom overrides
@import "vue-select/dist/vue-select.css";
@import "@/assets/scss/vendor/vue-select";
</style>
