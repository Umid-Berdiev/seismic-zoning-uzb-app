<script setup>
import BaseBlock from "../BaseBlock.vue";
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
                <BaseBlock title="Sismologik ma'lumotlar" transparent>
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
                                </div>
                            </nav>
                            <div class="tab-content pt-3" id="nav-tabContent">
                                <div
                                    class="tab-pane fade show active"
                                    id="nav-osr"
                                    role="tabpanel"
                                    aria-labelledby="nav-osr-tab"
                                    tabindex="0"
                                >
                                    Lorem ipsum dolor sit amet consectetur
                                    adipisicing elit. Fuga, sunt.
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="nav-dsr"
                                    role="tabpanel"
                                    aria-labelledby="nav-dsr-tab"
                                    tabindex="0"
                                >
                                    Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit. Dolores natus veritatis
                                    laboriosam velit sequi? Cumque.
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="nav-smr"
                                    role="tabpanel"
                                    aria-labelledby="nav-smr-tab"
                                    tabindex="0"
                                >
                                    Lorem ipsum dolor sit amet.
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
