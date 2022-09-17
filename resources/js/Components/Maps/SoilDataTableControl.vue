<script setup>
import { computed, reactive, ref } from "vue";
import { Dataset, DatasetItem, DatasetInfo, DatasetPager } from "vue-dataset";
import BaseBlock from "../BaseBlock.vue";

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
    labelType: "",
});

const soilDataAreaTotal = computed(
    () =>
        props.data.length &&
        props.data.reduce((acc, cur) => acc + Number(cur.area), 0)
);

function areaInPercent(rowAreaValue) {
    return ((rowAreaValue / soilDataAreaTotal.value) * 100).toFixed(2);
}
</script>

<template>
    <BaseBlock id="table_control_block" class="pb-3" title="Table">
        <Dataset
            v-slot="{ ds }"
            :ds-data="data.sort((a, b) => a.value - b.value)"
        >
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">№</th>
                                    <th>
                                        {{ labelType.split("_").join(" ") }}
                                    </th>
                                    <th>Area</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <DatasetItem tag="tbody" class="fs-sm">
                                <template #default="{ row, rowIndex }">
                                    <tr>
                                        <th scope="row">
                                            {{ rowIndex + 1 }}
                                        </th>
                                        <!-- <td>{{ row.value }}</td> -->
                                        <td>{{ row[labelType] }}</td>
                                        <td class="text-end">
                                            {{ row.area }}
                                        </td>
                                        <td class="text-end">
                                            {{ areaInPercent(row.area) }}
                                        </td>
                                    </tr>
                                </template>
                            </DatasetItem>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div
                            class="d-flex flex-md-row flex-column justify-content-between align-items-center"
                        >
                            <DatasetInfo class="py-3 fs-sm" />
                            <DatasetPager class="flex-wrap py-3 fs-sm" />
                        </div> -->
        </Dataset>
    </BaseBlock>
</template>

<style lang="scss" scoped>
#table_control_block {
    border: 2px solid lightgray;
    position: absolute;
    top: 4.25rem;
    right: 0.6rem;
    z-index: 800;
    width: 370px;
}
</style>
