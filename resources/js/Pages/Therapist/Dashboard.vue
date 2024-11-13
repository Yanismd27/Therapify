<template>
    <Head title="Therapist Dashboard" />
  
    <AuthenticatedLayout>
      <div class="min-h-screen bg-[#FAFAFA]">

        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
          <div class="relative">
            <div class="max-w-3xl mx-auto text-center mb-16">
              <h1 class="text-4xl lg:text-5xl font-bold leading-tight tracking-tight text-gray-900 mb-4">
                Welcome Back,
                <span class="relative">
                  <span class="text-purple-600">{{ user.name }}</span>
                  <svg class="absolute -bottom-2 left-0 w-full h-2 text-purple-200" viewBox="0 0 100 10">
                    <path d="M0 5 Q 25 0, 50 5 T 100 5" fill="none" stroke="currentColor" stroke-width="2"/>
                  </svg>
                </span>
              </h1>
              <p class="text-xl text-gray-600 mb-8">
                Here's an overview of your therapy practice and upcoming sessions.
              </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
              <div v-for="stat in stats" :key="stat.title" 
                   class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                  <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <span class="text-purple-600 text-xl">{{ stat.icon }}</span>
                  </div>
                  <span :class="[
                    'text-sm px-2 py-1 rounded-full',
                    stat.trend > 0 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'
                  ]">
                    {{ stat.trend > 0 ? '+' : '' }}{{ stat.trend }}%
                  </span>
                </div>
                <h3 class="text-2xl font-bold mb-1">{{ stat.value }}</h3>
                <p class="text-gray-600">{{ stat.title }}</p>
              </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
              <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6">
                  <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Today's Sessions</h2>
                    <Link 
                      :href="route('therapist.schedule')"
                      class="text-purple-600 hover:text-purple-700 flex items-center"
                    >
                      View Schedule
                      <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                      </svg>
                    </Link>
                  </div>
  
                  <div class="space-y-4">
                    <div v-if="todaySessions.length === 0" 
                         class="text-center py-8 text-gray-500">
                      No sessions scheduled for today
                    </div>
                    <div v-else v-for="session in todaySessions" 
                         :key="session.id"
                         class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                      <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                          {{ session.patient.name[0] }}
                        </div>
                        <div>
                          <h4 class="font-medium">{{ session.patient.name }}</h4>
                          <p class="text-sm text-gray-500">{{ session.time }}</p>
                        </div>
                      </div>
                      <div class="flex space-x-2">
                        <button class="p-2 text-green-600 hover:bg-green-50 rounded-full">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                          </svg>
                        </button>
                        <button class="p-2 text-purple-600 hover:bg-purple-50 rounded-full">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
  
       
              <div class="space-y-6">

                <div class="bg-white rounded-xl shadow-sm p-6">
                  <h2 class="text-lg font-semibold mb-4">Profile Completion</h2>
                  <div class="mb-4">
                    <div class="flex justify-between mb-2">
                      <span class="text-sm text-gray-600">Progress</span>
                      <span class="text-sm font-medium">85%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                  </div>
                  <Link 
                    :href="route(user.role === 'therapist' ? 'therapist.profile' : 'patient.profile')"
                    class="text-purple-600 hover:text-purple-700 text-sm flex items-center"
                  >
                    Complete your profile
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </Link>
                </div>
  
                <div class="bg-white rounded-xl shadow-sm p-6">
                  <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>
                  <div class="space-y-3">
                    <Link v-for="action in quickActions" 
                          :key="action.title"
                          :href="action.href"
                          class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                      <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                        <span class="text-purple-600">{{ action.icon }}</span>
                      </div>
                      <div>
                        <h3 class="font-medium">{{ action.title }}</h3>
                        <p class="text-sm text-gray-500">{{ action.description }}</p>
                      </div>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="absolute top-1/2 right-0 -translate-y-1/2 w-96 h-96 bg-purple-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
            <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-blue-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
</template>
  
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const stats = [
  { title: 'Total Patients', value: '48', trend: 12, icon: '👥' },
  { title: 'Sessions This Week', value: '24', trend: 8, icon: '📅' },
  { title: 'Avg. Rating', value: '4.8', trend: 2, icon: '⭐' },
  { title: 'Revenue', value: '$2.4k', trend: -5, icon: '💰' }
];

const todaySessions = [
  {
    id: 1,
    patient: { name: 'John Doe' },
    time: '10:00 AM - 11:00 AM'
  },
  {
    id: 2,
    patient: { name: 'Jane Smith' },
    time: '2:00 PM - 3:00 PM'
  }
];

const quickActions = [
  {
    icon: '📅',
    title: 'Schedule Session',
    description: 'Create a new appointment',
    href: route('therapist.schedule')
  },
  {
    icon: '📝',
    title: 'Write Notes',
    description: 'Document session notes',
    href: '#'
  },
  {
    icon: '📊',
    title: 'View Analytics',
    description: 'Check your performance',
    href: '#'
  }
];
</script>

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
  animation: fadeIn 0.6s ease-out forwards;
}
</style>