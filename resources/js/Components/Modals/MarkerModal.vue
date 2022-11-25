<script setup>
import BaseBlock from "../BaseBlock.vue";

const props = defineProps({
    searchResult: {
        balls: [],
        zones: [],
    },
});
</script>

<template>
    <div
        class="modal fade"
        id="marker-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="marker-modal"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <BaseBlock title="Qo'shimcha ma'lumotlar" transparent>
                    <template #options>
                        <button
                            type="button"
                            class="btn-block-option"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </template>

                    <template #content>
                        <div class="p-3">
                            <nav>
                                <div
                                    class="nav nav-tabs"
                                    id="nav-tab"
                                    role="tablist"
                                >
                                    <button
                                        class="nav-link"
                                        id="nav-smr-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#nav-smr"
                                        type="button"
                                        role="tab"
                                        aria-controls="nav-smr"
                                        aria-selected="false"
                                    >
                                        SMR
                                    </button>
                                    <button
                                        class="nav-link"
                                        id="nav-dsr-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#nav-dsr"
                                        type="button"
                                        role="tab"
                                        aria-controls="nav-dsr"
                                        aria-selected="false"
                                    >
                                        DSR
                                    </button>
                                    <button
                                        class="nav-link active"
                                        id="nav-osr-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#nav-osr"
                                        type="button"
                                        role="tab"
                                        aria-controls="nav-osr"
                                        aria-selected="true"
                                    >
                                        OSR
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content pt-3" id="nav-tabContent">
                                <div
                                    class="tab-pane fade"
                                    id="nav-smr"
                                    role="tabpanel"
                                    aria-labelledby="nav-smr-tab"
                                    tabindex="0"
                                >
                                    Ma'lumot mavjud emas
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="nav-dsr"
                                    role="tabpanel"
                                    aria-labelledby="nav-dsr-tab"
                                    tabindex="0"
                                >
                                    <table class="table table-sm">
                                        <tbody>
                                            <template
                                                v-if="
                                                    searchResult.balls.filter(
                                                        (ball) =>
                                                            ball.soato != '17'
                                                    ).length
                                                "
                                            >
                                                <tr
                                                    v-for="(
                                                        ball, ballIndex
                                                    ) in searchResult.balls.filter(
                                                        (ball) =>
                                                            ball.soato != '17'
                                                    )"
                                                >
                                                    <th>
                                                        {{ ball.level }} ball
                                                    </th>
                                                    <td>
                                                        <span
                                                            >Aniqlik
                                                            darajasi:</span
                                                        >
                                                        <span>{{
                                                            ball.accuracy
                                                        }}</span>
                                                    </td>
                                                </tr>
                                            </template>
                                            <template
                                                v-if="
                                                    searchResult.zones.filter(
                                                        (zone) =>
                                                            zone.soato != '17'
                                                    ).length
                                                "
                                            >
                                                <tr
                                                    v-for="(
                                                        zone, zoneIndex
                                                    ) in searchResult.zones.filter(
                                                        (zone) =>
                                                            zone.soato != '17'
                                                    )"
                                                >
                                                    <th>
                                                        {{
                                                            zone.pga_value
                                                        }}
                                                        zona
                                                    </th>
                                                    <td>
                                                        <span
                                                            >Aniqlik
                                                            darajasi:</span
                                                        >
                                                        <span>{{
                                                            zone.accuracy
                                                        }}</span>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                <div
                                    class="tab-pane fade show active"
                                    id="nav-osr"
                                    role="tabpanel"
                                    aria-labelledby="nav-osr-tab"
                                    tabindex="0"
                                >
                                    {{
                                        searchResult.balls.filter(
                                            (ball) => ball.soato == "17"
                                        )
                                    }}
                                </div>
                            </div>
                        </div>
                    </template>
                </BaseBlock>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
//
</style>
