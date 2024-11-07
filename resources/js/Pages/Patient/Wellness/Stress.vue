<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FAFAFA]">
            <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Stress Management</h2>
                        <Link 
                            :href="route('patient.dashboard')"
                            class="text-purple-600 hover:text-purple-700 flex items-center"
                        >
                            Back to Dashboard
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </Link>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div v-for="(technique, index) in stressManagementTechniques" 
                             :key="index"
                             class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                    <span class="text-purple-600">{{ technique.icon }}</span>
                                </div>
                                <h3 class="font-medium">{{ technique.title }}</h3>
                            </div>
                            <ul class="space-y-2">
                                <li v-for="(step, stepIndex) in technique.steps" 
                                    :key="stepIndex"
                                    class="text-sm text-gray-600 flex items-start">
                                    <span class="mr-2">•</span>
                                    {{ step }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const stressManagementTechniques = [
    {
        icon: '🌬️',
        title: 'Quick Relief Techniques',
        steps: [
            'Box breathing (4 seconds each: inhale, hold, exhale, hold)',
            'Progressive muscle relaxation',
            '5-minute mindful walking',
            'Grounding technique: name 5 things you can see'
        ]
    },
    {
        icon: '📅',
        title: 'Daily Practices',
        steps: [
            'Morning routine: 5 minutes of meditation',
            'Regular exercise breaks',
            'Mindful eating practice',
            'Evening wind-down ritual'
        ]
    }
]
</script>