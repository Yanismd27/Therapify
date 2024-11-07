<template>
    <Link
        :href="href"
        class="inline-flex items-center px-1 pt-1 text-sm font-medium"
        :class="{
            'text-purple-600 border-b-2 border-purple-600': active,
            'text-gray-600 hover:text-gray-900 hover:border-b-2 hover:border-purple-600': !active
        }"
    >
        <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true
    },
    active: {
        type: Boolean,
        default: false
    }
});
</script>