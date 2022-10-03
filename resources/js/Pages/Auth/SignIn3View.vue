<script setup>
import { reactive, computed } from "vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import { useMainStore } from "@/stores/main";
import BaseBackground from "@/Components/BaseBackground.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

// Main store and Router
const store = useMainStore();

// On form submission
async function onSubmit() {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
}
</script>

<template>
    <!-- Page Content -->
    <BaseBackground image="/images/88.jpg">
        <div class="row g-0 bg-primary-dark-op">
            <!-- Meta Info Section -->
            <div
                class="hero-static col-lg-7 d-none d-lg-flex flex-column justify-content-center"
            >
                <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                    <div class="w-100 text-center">
                        <img
                            src="/images/uzbekistan-gerb.png"
                            alt="uzb_gerb"
                            width="100"
                        />
                        <br />
                        <Link
                            href="#"
                            class="link-fx fw-semibold fs-2 text-white"
                        >
                            O'ZBEKISTON RESPUBLIKASI FANLAR AKADEMIYASI <br />
                            G'.O.MAVLONOV NOMIDAGI SEYSMOLOGIYA INSTITUTI
                        </Link>
                        <!-- <p class="text-white-75 me-xl-8 mt-2">
                            Welcome to your amazing app. Feel free to login and
                            start managing your projects and clients.
                        </p> -->
                    </div>
                </div>
                <div
                    class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm"
                >
                    <p class="fw-medium text-white-50 mb-0">
                        <strong>{{ store.app.name }}</strong>
                        &copy; {{ store.app.copyright }}
                    </p>
                    <!-- <ul class="list list-inline mb-0 py-2">
                        <li class="list-inline-item">
                            <a
                                class="text-white-75 fw-medium"
                                href="javascript:void(0)"
                                >Legal</a
                            >
                        </li>
                        <li class="list-inline-item">
                            <a
                                class="text-white-75 fw-medium"
                                href="javascript:void(0)"
                                >Contact</a
                            >
                        </li>
                        <li class="list-inline-item">
                            <a
                                class="text-white-75 fw-medium"
                                href="javascript:void(0)"
                                >Terms</a
                            >
                        </li>
                    </ul> -->
                </div>
            </div>
            <!-- END Meta Info Section -->

            <!-- Main Section -->
            <div
                class="hero-static col-lg-5 d-flex flex-column align-items-center bg-body-extra-light"
            >
                <!-- <div class="p-3 w-100 d-lg-none text-center">
                    <RouterLink
                        :to="{ name: 'landing' }"
                        class="link-fx fw-semibold fs-3 text-dark"
                    >
                        One<span class="fw-normal">UI</span>
                    </RouterLink>
                </div> -->
                <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                    <div class="w-100">
                        <!-- Header -->
                        <div class="text-center mb-5">
                            <!-- <p class="mb-3">
                                <i
                                    class="fa fa-2x fa-circle-notch text-primary-light"
                                ></i>
                            </p> -->
                            <img
                                src="/images/circle-cropped.png"
                                alt="main_logo"
                                width="100"
                            />
                            <br />
                            <br />
                            <h3 class="fw-bold mb-2">
                                <span
                                    >Online Map “SeismicZoningUzb” <br />
                                    elektron platformasi axborot tizimi</span
                                >
                            </h3>
                            <h3 class="text-muted">Hush kelibsiz!</h3>
                        </div>
                        <!-- END Header -->

                        <!-- Sign In Form -->
                        <div class="row g-0 justify-content-center">
                            <div class="col-sm-8 col-xl-6">
                                <form @submit.prevent="onSubmit">
                                    <div class="mb-4">
                                        <input
                                            type="text"
                                            class="form-control form-control-lg form-control-alt"
                                            id="login-email"
                                            name="login-email"
                                            placeholder="Elektron manzil"
                                            :class="{
                                                'is-invalid':
                                                    form.errors?.email?.length,
                                            }"
                                            v-model="form.email"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                        >
                                            {{ form.errors?.email }}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <input
                                            type="password"
                                            class="form-control form-control-lg form-control-alt"
                                            id="login-password"
                                            name="login-password"
                                            placeholder="Parol"
                                            :class="{
                                                'is-invalid':
                                                    form.errors?.password
                                                        ?.length,
                                            }"
                                            v-model="form.password"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                        >
                                            {{ form.errors?.password }}
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex justify-content-between align-items-center mb-4"
                                    >
                                        <div>
                                            <button
                                                type="submit"
                                                class="btn btn-lg btn-alt-primary"
                                            >
                                                <i
                                                    class="fa fa-fw fa-sign-in-alt me-1 opacity-50"
                                                ></i>
                                                Kirish
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END Sign In Form -->
                    </div>
                </div>
            </div>
            <!-- END Main Section -->
        </div>
    </BaseBackground>
    <!-- END Page Content -->
</template>
