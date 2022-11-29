<script setup lang="ts">
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import { useNotyf } from "@/composable/useNotyf";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { isEmpty } from "lodash";
import { computed, onMounted, reactive, ref } from "vue";

const form = useForm({
    username: "",
    first_name: "",
    last_name: "",
});

// const computedUserData = computed({
//     get() {
//         return props.user;
//     },
//     set(val) {},
// });

const notif = useNotyf();

onMounted(() => {
    const authUser = usePage().props.value.auth.user;
    Object.assign(form, authUser);
});

const submit = () => {
    form.put(route("profile.update", form), {
        // onFinish: () => {
        //     form.reset();
        // },
        onSuccess: () => {
            notif.success("Ma'lumotlar muvoffaqiyatli yangilandi!");
        },
    });
};
</script>

<template>
    <!-- Page Content -->
    <div class="content content-boxed">
        <form @submit.prevent="submit" class="row row-cols-1 w-50 gap-3">
            <div class="col">
                <label class="form-label" for="example-if-username"
                    >Foydalanuvchi nomi</label
                >
                <input
                    type="text"
                    class="form-control"
                    id="example-if-username"
                    v-model="form.username"
                />
            </div>
            <div class="col">
                <label class="form-label" for="example-if-firstname"
                    >Ismi</label
                >
                <input
                    type="text"
                    class="form-control"
                    id="example-if-firstname"
                    v-model="form.first_name"
                />
            </div>
            <div class="col">
                <label class="form-label" for="example-if-lastname"
                    >Familiyasi</label
                >
                <input
                    type="text"
                    class="form-control"
                    id="example-if-lastname"
                    v-model="form.last_name"
                />
            </div>
            <div class="col text-end">
                <SubmitButton :loading="form.processing" />
            </div>
        </form>
    </div>
    <!-- END Page Content -->
</template>
