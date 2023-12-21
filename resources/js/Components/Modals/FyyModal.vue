<script setup lang="ts">
import BaseBlock from "../BaseBlock.vue";

defineProps<{
    data: any;
}>();
</script>

<template>
    <div
        class="modal fade"
        id="fyy-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="fyy-modal"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <BaseBlock title="Faol yer yorig'i ma'lumotlari" transparent>
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
                            <template v-if="data">
                                <p class="mb-1"><b>Nomi:</b> {{ data.Nomi }}</p>
                                <p class="mb-1"><b>Turi:</b> {{ data.Turi }}</p>
                                <p class="mb-1">
                                    <b>Yer yorig'i:</b> {{ data.Yer_yorig_ }}
                                </p>
                                <p class="mb-1">
                                    <b>Uzunligi:</b> {{ data.Uzunligi__ }}
                                </p>
                                <p class="mb-1">
                                    <b>Chuqurligi:</b> {{ data.Chuqurligi }}
                                </p>
                                <p class="mb-1">
                                    <b>Morfologiy:</b> {{ data.Morfologiy }}
                                </p>
                                <p class="mb-1">
                                    <b>Vertikal_h:</b> {{ data.Vertikal_h }}
                                </p>
                                <p class="mb-1">
                                    <b>Vertikal_1:</b> {{ data.Vertikal_1 }}
                                </p>
                                <p class="mb-1">
                                    <b>Yotish burchagi:</b>
                                    {{ data.Yotish_bur }}
                                </p>
                                <p class="mb-1">
                                    <b>Faollanish:</b> {{ data.Faollanish }}
                                </p>
                                <p class="mb-1">
                                    <b>Seysmik_fa:</b> {{ data.Seysmik_fa }}
                                </p>
                                <p class="mb-1">
                                    <b>Dinamik_ta:</b> {{ data.Dinamik_ta }}
                                </p>
                                <p class="mb-1">
                                    <b>Maksimal_s:</b> {{ data.Maksimal_s }}
                                </p>
                                <p class="mb-1">
                                    <b>Manbaalar:</b> {{ data.Manbaalar }}
                                </p>
                            </template>
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
