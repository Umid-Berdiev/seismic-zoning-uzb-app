<script setup>
import BaseBlock from "../BaseBlock.vue";
</script>

<template>
    <div
        class="modal fade"
        id="modal-confirm"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modal-confirm"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <BaseBlock title="Confirm action" transparent>
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
                        <h5 class="text-center mt-3">Are You Sure?</h5>
                        <div class="d-flex gap-3 justify-content-center">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                No
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-bs-dismiss="modal"
                                @click="$emit('confirm')"
                            >
                                Yes
                            </button>
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
