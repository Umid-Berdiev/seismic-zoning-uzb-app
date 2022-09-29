<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { useI18n } from "vue-i18n";
import { useStorage } from "@vueuse/core";

const { locale, availableLocales, t } = useI18n();

/**
 * We use the same storage key as we use in the /src/i18n.ts file
 * so if user reload the page, the selected language will be the same
 */
// const defaultLocale = useStorage('locale', navigator?.language || 'uz')
const defaultLocale = useStorage("locale", "uz");

/**
 * Each time we change the locale, we persit it in the storage
 */
watch(locale, () => {
    defaultLocale.value = locale.value;
});

const filteredLocales = computed(() =>
    availableLocales.filter((item) => item !== locale.value)
);

const localFlagSrc = computed(() => {
    return (locale: string) => {
        switch (locale) {
            case "en":
                return "/images/svg/flag_en.svg";
            case "ru":
                return "/images/svg/flag_ru.svg";
            case "uz":
            default:
                return "/images/svg/flag_uz.svg";
        }
    };
});

function changeLocale(loc: string) {
    locale.value = loc;
    location.reload();
}
</script>

<template>
    <div class="dropdown">
        <button
            type="button"
            class="btn btn-sm btn-alt-secondary dropdown-toggle"
            data-bs-toggle="dropdown"
            aria-expanded="false"
        >
            {{ locale.toUpperCase() }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li v-for="lang in filteredLocales" class="text-center">
                <button
                    class="btn btn-sm btn-light dropdown-item"
                    type="button"
                    @click="changeLocale(lang)"
                >
                    <img
                        class="me-2"
                        :src="localFlagSrc(lang)"
                        :alt="lang + 'flag'"
                    />
                    <span>{{ lang.toUpperCase() }}</span>
                </button>
            </li>
        </ul>
    </div>
</template>

<style scoped lang="scss">
.locale-dropdown .dropdown-menu {
    min-width: none !important;
}
</style>
