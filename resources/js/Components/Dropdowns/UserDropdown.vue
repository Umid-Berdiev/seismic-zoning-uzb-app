<script setup>
import { computed } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

const authUser = computed(() => usePage().props.value.auth.user);
</script>

<template>
    <div class="dropdown d-inline-block">
        <button
            type="button"
            class="btn btn-sm btn-alt-secondary"
            id="page-header-user-dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <span class="">
                {{ authUser.username }}
            </span>
            <i class="fa fa-fw fa-angle-down"></i>
        </button>
        <div
            class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
            aria-labelledby="page-header-user-dropdown"
        >
            <div
                class="p-3 text-center bg-body-light border-bottom rounded-top"
            >
                <p class="mt-2 mb-0 fw-medium">
                    {{ authUser.first_name }}
                    {{ authUser.last_name }}
                </p>
                <p class="mb-0 text-muted fs-sm fw-medium">Web Developer</p>
            </div>
            <div class="p-2">
                <form
                    @submit.prevent="useForm().post(route('logout'))"
                    method="POST"
                >
                    <button type="submit" class="btn dropdown-item text-center">
                        <span class="fs-sm fw-medium">{{
                            $t("logout_text")
                        }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>
