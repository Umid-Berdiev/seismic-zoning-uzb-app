<script setup>
import BaseBlock from "../BaseBlock.vue";

const props = defineProps({
    searchResult: {
        osr: {
            balls: [],
            zones: [],
        },
        dsr: {
            balls: [],
            zones: [],
        },
        smr: {
            balls: [],
            zones: [],
        },
        fyy: {
            balls: [],
            zones: [],
        },
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
                                        class="nav-link active"
                                        id="nav-smr-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#nav-smr"
                                        type="button"
                                        role="tab"
                                        aria-controls="nav-smr"
                                        aria-selected="true"
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
                                        class="nav-link"
                                        id="nav-osr-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#nav-osr"
                                        type="button"
                                        role="tab"
                                        aria-controls="nav-osr"
                                        aria-selected="false"
                                    >
                                        OSR
                                    </button>
                                    <button
                                        class="nav-link"
                                        id="nav-fyy-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#nav-fyy"
                                        type="button"
                                        role="tab"
                                        aria-controls="nav-fyy"
                                        aria-selected="false"
                                    >
                                        Faol yer yoriqlari
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content pt-3" id="nav-tabContent">
                                <div
                                    class="tab-pane fade show active"
                                    id="nav-smr"
                                    role="tabpanel"
                                    aria-labelledby="nav-smr-tab"
                                    tabindex="0"
                                >
                                    <table class="table table-sm">
                                        <template
                                            v-if="searchResult.smr.balls.length"
                                        >
                                            <tbody>
                                                <tr
                                                    v-for="ball in searchResult
                                                        .smr.balls"
                                                >
                                                    <th>
                                                        Ball (MSK-64
                                                        makroseismik shkala
                                                        bo'yicha)
                                                    </th>
                                                    <td>
                                                        <div>
                                                            Darajasi:
                                                            {{ ball.level }}
                                                        </div>
                                                        <div>
                                                            Aniqlik:
                                                            {{ ball.accuracy }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template
                                            v-if="searchResult.smr.zones.length"
                                        >
                                            <tbody>
                                                <tr
                                                    v-for="zone in searchResult
                                                        .smr.zones"
                                                >
                                                    <th>PGA, sm/s&sup2;</th>
                                                    <td>
                                                        <div>
                                                            PGA oralig'i:
                                                            {{
                                                                zone.pga_value.replace(
                                                                    "_",
                                                                    "-"
                                                                )
                                                            }}
                                                        </div>
                                                        <div>
                                                            Aniqlik:
                                                            {{ zone.accuracy }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template
                                            v-if="
                                                searchResult.smr.balls
                                                    .length === 0 &&
                                                searchResult.smr.zones
                                                    .length === 0
                                            "
                                        >
                                            Ma'lumot mavjud emas
                                        </template>
                                    </table>
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="nav-dsr"
                                    role="tabpanel"
                                    aria-labelledby="nav-dsr-tab"
                                    tabindex="0"
                                >
                                    <table class="table table-sm">
                                        <template
                                            v-if="searchResult.dsr.balls.length"
                                        >
                                            <tbody>
                                                <tr
                                                    v-for="ball in searchResult
                                                        .dsr.balls"
                                                >
                                                    <th>
                                                        Ball (MSK-64
                                                        makroseismik shkala
                                                        bo'yicha)
                                                    </th>
                                                    <td>
                                                        <div>
                                                            Darajasi:
                                                            {{ ball.level }}
                                                        </div>
                                                        <div>
                                                            Aniqlik:
                                                            {{ ball.accuracy }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template
                                            v-if="searchResult.dsr.zones.length"
                                        >
                                            <tbody>
                                                <tr
                                                    v-for="zone in searchResult
                                                        .dsr.zones"
                                                >
                                                    <th>PGA, sm/s&sup2;</th>
                                                    <td>
                                                        <div>
                                                            PGA oralig'i:
                                                            {{
                                                                zone.pga_value.replace(
                                                                    "_",
                                                                    "-"
                                                                )
                                                            }}
                                                        </div>
                                                        <div>
                                                            Aniqlik:
                                                            {{ zone.accuracy }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template
                                            v-if="
                                                searchResult.dsr.balls
                                                    .length === 0 &&
                                                searchResult.dsr.zones
                                                    .length === 0
                                            "
                                        >
                                            Ma'lumot mavjud emas
                                        </template>
                                    </table>
                                </div>
                                <div
                                    class="tab-pane fade show"
                                    id="nav-osr"
                                    role="tabpanel"
                                    aria-labelledby="nav-osr-tab"
                                    tabindex="0"
                                >
                                    <table class="table table-sm">
                                        <template
                                            v-if="searchResult.osr.balls.length"
                                        >
                                            <tbody>
                                                <tr
                                                    v-for="ball in searchResult
                                                        .osr.balls"
                                                >
                                                    <th>
                                                        Ball (MSK-64
                                                        makroseismik shkala
                                                        bo'yicha)
                                                    </th>
                                                    <td>
                                                        <div>
                                                            Darajasi:
                                                            {{ ball.level }}
                                                        </div>
                                                        <div>
                                                            Aniqlik:
                                                            {{ ball.accuracy }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template
                                            v-if="searchResult.osr.zones.length"
                                        >
                                            <tbody>
                                                <tr
                                                    v-for="zone in searchResult
                                                        .osr.zones"
                                                >
                                                    <th>PGA, sm/s&sup2;</th>
                                                    <td>
                                                        <div>
                                                            PGA oralig'i:
                                                            {{
                                                                zone.pga_value.replace(
                                                                    "_",
                                                                    "-"
                                                                )
                                                            }}
                                                        </div>
                                                        <div>
                                                            Aniqlik:
                                                            {{ zone.accuracy }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template
                                            v-if="
                                                searchResult.osr.balls
                                                    .length === 0 &&
                                                searchResult.osr.zones
                                                    .length === 0
                                            "
                                        >
                                            Ma'lumot mavjud emas
                                        </template>
                                    </table>
                                </div>
                                <div
                                    class="tab-pane fade show"
                                    id="nav-fyy"
                                    role="tabpanel"
                                    aria-labelledby="nav-fyy-tab"
                                    tabindex="0"
                                >
                                    <table class="table table-sm">
                                        <template v-if="searchResult.fyy">
                                            <tbody>
                                                <tr
                                                    v-for="item in searchResult.fyy"
                                                >
                                                    <th>
                                                        {{ item.Nomi }}
                                                    </th>
                                                    <td>
                                                        <b>Yer yorig'i:</b>
                                                        {{ item.Yer_yorig_ }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template v-else>
                                            Ma'lumot mavjud emas
                                        </template>
                                    </table>
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
