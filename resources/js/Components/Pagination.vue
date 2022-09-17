<script setup>
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    current_page: {
        type: Number,
        default: 1,
    },
    first_page_url: "",
    from: {
        type: Number,
        default: 1,
    },
    last_page: {
        type: Number,
        default: 1,
    },
    last_page_url: "",
    links: {
        type: Array,
        default: () => [],
    },
    next_page_url: null,
    path: "",
    per_page: {
        type: Number,
        default: 10,
    },
    prev_page_url: null,
    to: {
        type: Number,
        default: 2,
    },
    total: {
        type: Number,
        default: 10,
    },
});
</script>

<template>
    <div>
        <nav aria-label="...">
            <ul class="pagination">
                <!-- <li class="page-item" :class="{ disabled: !prev_page_url }">
                    <Link :href="prev_page_url" class="page-link">
                        Previous
                    </Link>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li> -->
                <li
                    v-for="link in links"
                    class="page-item"
                    :class="{ disabled: !link.url, active: link.active }"
                >
                    <Link :href="link.url" class="page-link">
                        <span v-html="link.label"></span>
                    </Link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<style lang="scss" scoped></style>
