<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { useMainStore } from "@/stores/main";

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
    <div class="hero-static d-flex align-items-center">
        <div class="w-100">
            <!-- Sign In Section -->
            <div class="bg-body-extra-light">
                <div class="content content-full">
                    <div class="row g-0 justify-content-center">
                        <div
                            class="col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5"
                        >
                            <!-- Header -->
                            <div class="text-center">
                                <p class="mb-2">
                                    <i
                                        class="fa fa-2x fa-circle-notch text-primary"
                                    ></i>
                                </p>
                                <h1 class="h4 mb-1">Sign In</h1>
                                <p class="fw-medium text-muted mb-3">
                                    A perfect match for your project
                                </p>
                            </div>
                            <!-- END Header -->

                            <!-- Sign In Form -->
                            <form @submit.prevent="onSubmit">
                                <div class="py-3">
                                    <div class="mb-4">
                                        <input
                                            type="text"
                                            class="form-control form-control-lg form-control-alt"
                                            id="login-email"
                                            name="login-email"
                                            placeholder="Email"
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
                                            placeholder="Password"
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
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-xxl-5">
                                        <button
                                            type="submit"
                                            class="btn w-100 btn-alt-primary"
                                        >
                                            <i
                                                class="fa fa-fw fa-sign-in-alt me-1 opacity-50"
                                            ></i>
                                            Sign In
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- END Sign In Form -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Sign In Section -->

            <!-- Footer -->
            <div class="fs-sm text-center text-muted py-3">
                <strong>{{ store.app.name }}</strong>
                &copy;
                {{ store.app.copyright }}
            </div>
            <!-- END Footer -->
        </div>
    </div>
    <!-- END Page Content -->
</template>
