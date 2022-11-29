<script setup>
import { computed } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import NavLink from "../NavLink.vue";

const authUser = computed(() => usePage().props.value.auth.user);

function gotoProfilePage() {
    useForm().get(route("profile"));
}

function gotoChangePasswordPage() {
    useForm().get(route("profile.password"));
}
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
                {{ authUser?.fullname }}
            </span>
            <i class="fa fa-fw fa-angle-down"></i>
        </button>
        <div
            class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
            aria-labelledby="page-header-user-dropdown"
        >
            <!-- <div
                class="p-3 text-center bg-body-light border-bottom rounded-top"
            >
                <p class="mt-2 mb-0 fw-medium">
                    {{ authUser?.first_name }}
                    {{ authUser?.last_name }}
                </p>
                <p class="mb-0 text-muted fs-sm fw-medium">Web Developer</p>
            </div> -->
            <div class="p-2">
                <button
                    class="btn dropdown-item"
                    type="button"
                    @click="gotoProfilePage"
                >
                    <span class="fs-sm fw-medium"> Profilni yangilash </span>
                </button>
            </div>
            <div class="p-2">
                <button
                    class="btn dropdown-item"
                    type="button"
                    @click="gotoChangePasswordPage"
                >
                    <span class="fs-sm fw-medium"> Parolni o'zgartirish </span>
                </button>
            </div>
            <div class="p-2">
                <form
                    @submit.prevent="useForm().post(route('logout'))"
                    method="POST"
                >
                    <button type="submit" class="btn dropdown-item">
                        <span class="fs-sm fw-medium">{{
                            $t("logout_text")
                        }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
