<script setup>
import { reactive, computed } from "vue";
import { useRouter } from "vue-router";
import { useMainStore } from "@/stores/main";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import BaseBlock from "@/Components/BaseBlock.vue";

// // Vuelidate, for more info and examples you can check out https://github.com/vuelidate/vuelidate
// import useVuelidate from "@vuelidate/core";
// import { required, minLength, email, sameAs } from "@vuelidate/validators";

// Main store and Router
const store = useMainStore();
// const router = useRouter();

const form = useForm({
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

// // Input state variables
// const state = reactive({
//   username: null,
//   email: null,
//   password: null,
//   confirmPassword: null,
//   terms: null,
// });

// // Validation rules
// const rules = computed(() => {
//   return {
//     username: {
//       required,
//       minLength: minLength(3),
//     },
//     email: {
//       required,
//       email,
//     },
//     password: {
//       required,
//       minLength: minLength(5),
//     },
//     confirmPassword: {
//       required,
//       sameAs: sameAs(state.password),
//     },
//     terms: {
//       sameAs: sameAs(true),
//     },
//   };
// });

// // Use vuelidate
// const v$ = useVuelidate(rules, state);

// On form submission
async function onSubmit() {
    //   const result = await v$.value.$validate();
    //   if (!result) {
    //     // notify user form is invalid
    //     return;
    //   }
    //   // Go to dashboard
    //   router.push({ name: "backend-pages-auth" });

    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
}
</script>

<template>
    <!-- Page Content -->
    <div class="hero-static d-flex align-items-center">
        <div class="w-100">
            <!-- Sign Up Section -->
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
                                <h1 class="h4 mb-1">Create Account</h1>
                                <p class="text-muted mb-3">
                                    Get your access today in one easy step
                                </p>
                            </div>
                            <!-- END Header -->

                            <!-- Sign Up Form -->
                            <form @submit.prevent="onSubmit">
                                <div class="py-3">
                                    <div class="mb-4">
                                        <input
                                            type="text"
                                            class="form-control form-control-lg form-control-alt"
                                            id="signup-username"
                                            name="signup-username"
                                            placeholder="Username"
                                            :class="{
                                                'is-invalid':
                                                    form.errors.username
                                                        ?.length,
                                            }"
                                            v-model="form.username"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                        >
                                            {{ form.errors.username }}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <input
                                            type="text"
                                            class="form-control form-control-lg form-control-alt"
                                            id="signup-email"
                                            name="signup-email"
                                            placeholder="Email"
                                            :class="{
                                                'is-invalid':
                                                    form.errors.email?.length,
                                            }"
                                            v-model="form.email"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                        >
                                            {{ form.errors.email }}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <input
                                            type="password"
                                            class="form-control form-control-lg form-control-alt"
                                            id="signup-password"
                                            name="signup-password"
                                            placeholder="Password"
                                            :class="{
                                                'is-invalid':
                                                    form.errors.password
                                                        ?.length,
                                            }"
                                            v-model="form.password"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                        >
                                            {{ form.errors.password }}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <input
                                            type="password"
                                            class="form-control form-control-lg form-control-alt"
                                            id="signup-password-confirm"
                                            name="signup-password-confirm"
                                            placeholder="Confirm Password"
                                            :class="{
                                                'is-invalid':
                                                    form.errors
                                                        .password_confirmation
                                                        ?.length,
                                            }"
                                            v-model="form.password_confirmation"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                        >
                                            {{
                                                form.errors
                                                    .password_confirmation
                                            }}
                                        </div>
                                    </div>
                                    <!-- <div class="mb-4">
                                        <div
                                            class="d-md-flex align-items-md-center justify-content-md-between"
                                        >
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    id="signup-terms"
                                                    name="signup-terms"
                                                    :class="{
                                                        'is-invalid':
                                                            v$.terms.$errors
                                                                .length,
                                                    }"
                                                    v-model="state.terms"
                                                    @blur="v$.terms.$touch"
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="signup-terms"
                                                    >I agree to Terms &amp;
                                                    Conditions</label
                                                >
                                                <div
                                                    v-if="
                                                        v$.terms.$errors.length
                                                    "
                                                    class="invalid-feedback animated fadeIn"
                                                >
                                                    You must agree to the
                                                    service terms!
                                                </div>
                                            </div>
                                            <div class="py-2">
                                                <a
                                                    class="fs-sm fw-medium"
                                                    href="javascript:void(0)"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#one-signup-terms"
                                                    >View Terms</a
                                                >
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-xxl-5">
                                        <button
                                            type="submit"
                                            class="btn w-100 btn-alt-success"
                                        >
                                            <i
                                                class="fa fa-fw fa-plus me-1 opacity-50"
                                            ></i>
                                            Sign Up
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- END Sign Up Form -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Sign Up Section -->

            <!-- Footer -->
            <div class="fs-sm text-center text-muted py-3">
                <strong>{{ store.app.name }}</strong>
                &copy;
                {{ store.app.copyright }}
            </div>
            <!-- END Footer -->
        </div>

        <!-- Terms Modal -->
        <div
            class="modal fade"
            id="one-signup-terms"
            tabindex="-1"
            role="dialog"
            aria-labelledby="one-signup-terms"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-lg modal-dialog-popout"
                role="document"
            >
                <div class="modal-content">
                    <BaseBlock
                        title="Terms &amp; Conditions"
                        transparent
                        class="mb-0"
                    >
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
                            <div class="block-content">
                                <p>
                                    Dolor posuere proin blandit accumsan
                                    senectus netus nullam curae, ornare laoreet
                                    adipiscing luctus mauris adipiscing pretium
                                    eget fermentum, tristique lobortis est ut
                                    metus lobortis tortor tincidunt himenaeos
                                    habitant quis dictumst proin odio sagittis
                                    purus mi, nec taciti vestibulum quis in sit
                                    varius lorem sit metus mi.
                                </p>
                                <p>
                                    Dolor posuere proin blandit accumsan
                                    senectus netus nullam curae, ornare laoreet
                                    adipiscing luctus mauris adipiscing pretium
                                    eget fermentum, tristique lobortis est ut
                                    metus lobortis tortor tincidunt himenaeos
                                    habitant quis dictumst proin odio sagittis
                                    purus mi, nec taciti vestibulum quis in sit
                                    varius lorem sit metus mi.
                                </p>
                                <p>
                                    Dolor posuere proin blandit accumsan
                                    senectus netus nullam curae, ornare laoreet
                                    adipiscing luctus mauris adipiscing pretium
                                    eget fermentum, tristique lobortis est ut
                                    metus lobortis tortor tincidunt himenaeos
                                    habitant quis dictumst proin odio sagittis
                                    purus mi, nec taciti vestibulum quis in sit
                                    varius lorem sit metus mi.
                                </p>
                                <p>
                                    Dolor posuere proin blandit accumsan
                                    senectus netus nullam curae, ornare laoreet
                                    adipiscing luctus mauris adipiscing pretium
                                    eget fermentum, tristique lobortis est ut
                                    metus lobortis tortor tincidunt himenaeos
                                    habitant quis dictumst proin odio sagittis
                                    purus mi, nec taciti vestibulum quis in sit
                                    varius lorem sit metus mi.
                                </p>
                                <p>
                                    Dolor posuere proin blandit accumsan
                                    senectus netus nullam curae, ornare laoreet
                                    adipiscing luctus mauris adipiscing pretium
                                    eget fermentum, tristique lobortis est ut
                                    metus lobortis tortor tincidunt himenaeos
                                    habitant quis dictumst proin odio sagittis
                                    purus mi, nec taciti vestibulum quis in sit
                                    varius lorem sit metus mi.
                                </p>
                                <p>
                                    Dolor posuere proin blandit accumsan
                                    senectus netus nullam curae, ornare laoreet
                                    adipiscing luctus mauris adipiscing pretium
                                    eget fermentum, tristique lobortis est ut
                                    metus lobortis tortor tincidunt himenaeos
                                    habitant quis dictumst proin odio sagittis
                                    purus mi, nec taciti vestibulum quis in sit
                                    varius lorem sit metus mi.
                                </p>
                            </div>
                            <div
                                class="block-content block-content-full text-end bg-body"
                            >
                                <button
                                    type="button"
                                    class="btn btn-sm btn-alt-secondary me-1"
                                    data-bs-dismiss="modal"
                                >
                                    Close
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    data-bs-dismiss="modal"
                                >
                                    I Agree
                                </button>
                            </div>
                        </template>
                    </BaseBlock>
                </div>
            </div>
        </div>
        <!-- END Terms Modal -->
    </div>
    <!-- END Page Content -->
</template>
