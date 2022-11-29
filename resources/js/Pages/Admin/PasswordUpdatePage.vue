<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Layouts/GuestLayout.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeInputError from "@/Components/InputError.vue";
import BreezeLabel from "@/Components/InputLabel.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import { useNotyf } from "@/composable/useNotyf";

const notif = useNotyf();
const form = useForm({
    current_password: "",
    new_password: "",
    confirm_password: "",
});

const submit = () => {
    form.post(route("update-password"), {
        onFinish: () => {
            form.reset();
        },
        onSuccess: () => {
            notif.success("Parol muvoffaqiyatli yangilandi!");
        },
    });
};
</script>

<template>
    <div class="content content-boxed">
        <form @submit.prevent="submit" class="row row-cols-1 w-50 gap-3">
            <div class="col">
                <BreezeLabel for="current_password" value="Hozirgi parol" />
                <BreezeInput
                    id="current_password"
                    type="password"
                    v-model="form.current_password"
                    autocomplete="current_password"
                    autofocus
                />
                <BreezeInputError :message="form.errors.current_password" />
            </div>
            <div class="col">
                <BreezeLabel for="new_password" value="Yangi parol" />
                <BreezeInput
                    id="new_password"
                    type="password"
                    v-model="form.new_password"
                />
                <BreezeInputError :message="form.errors.new_password" />
            </div>
            <div class="col">
                <BreezeLabel
                    for="confirm_password"
                    value="Yangi parolni qayta kiritish"
                />
                <BreezeInput
                    id="confirm_password"
                    type="password"
                    v-model="form.confirm_password"
                />
                <BreezeInputError :message="form.errors.confirm_password" />
            </div>

            <div class="col text-end">
                <SubmitButton :loading="form.processing">
                    Tasdiqlash
                </SubmitButton>
            </div>
        </form>
    </div>
</template>
