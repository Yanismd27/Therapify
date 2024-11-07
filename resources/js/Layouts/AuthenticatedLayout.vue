<template>
    <div class="min-h-screen bg-[#FAFAFA]">
        <nav class="w-full py-6 px-6 lg:px-12 bg-white shadow-sm">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center group">
                    <Link :href="homeRoute" class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center transition-transform group-hover:scale-110">
                            <div class="h-6 w-6 bg-white rounded-full"></div>
                        </div>
                        <span class="ml-3 text-xl font-bold tracking-tight">Therapify</span>
                    </Link>
                </div>

                <!-- Navigation -->
                <div class="hidden lg:flex items-center space-x-10">
                    <Link
                        v-for="item in filteredNavigation"
                        :key="item.text"
                        :href="item.href"
                        class="inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors duration-200"
                        :class="item.href === currentRoute ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-600 hover:text-gray-900'"
                    >
                        {{ item.text }}
                    </Link>
                </div>

                <!-- User Menu -->
                <div v-if="user" class="flex items-center space-x-4">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                <span>{{ user.name }}</span>
                                <div class="h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    {{ user.name[0] }}
                                </div>
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink :href="profileRoute">
                                Profile
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { computed } from 'vue';

const page = usePage();

const user = computed(() => page.props.auth?.user);
const currentRoute = computed(() => window.location.pathname);

const navigation = {
    patient: [
        { text: 'Dashboard', href: '/patient/dashboard' },
        { text: 'Find Therapist', href: '/patient/therapists' },
        { text: 'My Appointments', href: '/patient/appointments' }
    ],
    therapist: [
        { text: 'Dashboard', href: '/therapist/dashboard' },
        { text: 'Appointments', href: '/therapist/appointments' },
        { text: 'Schedule', href: '/therapist/schedule' }
    ]
};

const filteredNavigation = computed(() => {
    if (!user.value) return [];
    return navigation[user.value.role] || [];
});

const profileRoute = computed(() => {
    if (!user.value) return '/';
    return `/${user.value.role}/profile`;
});

const homeRoute = computed(() => {
    if (!user.value) return '/';
    return `/${user.value.role}/dashboard`;
});
</script>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
    transition: all 0.3s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>