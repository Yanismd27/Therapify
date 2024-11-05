<template>
    <div class="min-h-screen bg-[#FAFAFA]">
        <nav class="w-full py-6 px-6 lg:px-12 bg-white shadow-sm">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center group">
                    <Link :href="route('dashboard')" class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center transition-transform group-hover:scale-110">
                            <div class="h-6 w-6 bg-white rounded-full"></div>
                        </div>
                        <span class="ml-3 text-xl font-bold tracking-tight">Therapify</span>
                    </Link>
                </div>

                <!-- Navigation -->
                <div class="hidden lg:flex items-center space-x-10">
                    <NavLink 
                        v-for="item in navigationItems" 
                        :key="item.text"
                        :href="item.href"
                        :active="route().current(item.route)"
                    >
                        {{ item.text }}
                    </NavLink>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                <span>{{ $page.props.auth.user.name }}</span>
                                <div class="h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    {{ $page.props.auth.user.name[0] }}
                                </div>
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
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
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const navigationItems = computed(() => {
    if (user.value.role === 'patient') {
        return [
            { text: 'Dashboard', href: route('patient.dashboard'), route: 'patient.dashboard' },
            { text: 'Find Therapist', href: route('patient.therapists'), route: 'patient.therapists' },
            { text: 'My Appointments', href: route('patient.appointments'), route: 'patient.appointments' }
        ];
    } else if (user.value.role === 'therapist') {
        return [
            { text: 'Dashboard', href: route('therapist.dashboard'), route: 'therapist.dashboard' },
            { text: 'Appointments', href: route('therapist.appointments'), route: 'therapist.appointments' },
            { text: 'Schedule', href: route('therapist.schedule'), route: 'therapist.schedule' }
        ];
    }
    return [];
});
</script>
  
  <style scoped>
  .router-link-active {
    @apply text-purple-600;
  }
  
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