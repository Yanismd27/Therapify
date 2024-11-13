<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FAFAFA]">
            <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Daily Journal</h2>
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
                    <div class="space-y-6">
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                            <h3 class="text-purple-800 font-medium mb-2">Today's Prompt</h3>
                            <p class="text-purple-600">{{ currentPrompt }}</p>
                            <button 
                                @click="changePrompt"
                                class="mt-2 text-sm text-purple-700 hover:text-purple-800"
                            >
                                Try another prompt →
                            </button>
                        </div>

                        <textarea
                            v-model="journalEntry"
                            class="w-full h-32 p-4 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                            placeholder="Start writing your thoughts..."
                        ></textarea>

                        <div class="flex justify-end">
                            <button 
                                @click="saveEntry"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Save Entry
                            </button>
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
import { useToast } from 'vue-toastification'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const toast = useToast()
const journalEntry = ref('')

const prompts = [
    "What are three things you're grateful for today?",
    "How are you feeling right now, and why?",
    "What's one challenge you faced today, and how did you handle it?",
    "What's one thing you're looking forward to?",
    "What made you smile today?"
]

const currentPrompt = ref(prompts[0])

const changePrompt = () => {
    const currentIndex = prompts.indexOf(currentPrompt.value)
    const nextIndex = (currentIndex + 1) % prompts.length
    currentPrompt.value = prompts[nextIndex]
}

const saveEntry = () => {
    if (journalEntry.value.trim()) {
        toast.success('Journal entry saved successfully')
        journalEntry.value = ''
    } else {
        toast.warning('Please write something before saving')
    }
}
</script>