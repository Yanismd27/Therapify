<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FAFAFA]">
            <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
                <!-- Section principale -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Meditation Guide</h2>
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

                    <!-- Timer et contrôles -->
                    <div v-if="activeSession" class="mb-8">
                        <div class="bg-purple-50 rounded-xl p-6 text-center">
                            <div class="text-4xl font-bold text-purple-600 mb-4">
                                {{ formatTime(remainingTime) }}
                            </div>
                            <div class="flex justify-center space-x-4">
                                <button 
                                    @click="toggleTimer"
                                    class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path v-if="!isTimerRunning" 
                                              stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path v-else 
                                              stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M10 9v6m4-6v6m-7-3h10"/>
                                    </svg>
                                    {{ isTimerRunning ? 'Pause' : 'Start' }}
                                </button>
                                <button 
                                    @click="resetTimer"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors flex items-center"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Lecteur audio -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Background Sounds</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <button
                                v-for="sound in backgroundSounds"
                                :key="sound.id"
                                @click="toggleSound(sound.id)"
                                :class="[
                                    'p-4 rounded-lg flex flex-col items-center transition-all',
                                    currentSound === sound.id ? 'bg-purple-100 ring-2 ring-purple-500' : 'bg-gray-50 hover:bg-gray-100'
                                ]"
                            >
                                <span class="text-2xl mb-2">{{ sound.icon }}</span>
                                <span class="text-sm font-medium">{{ sound.name }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Sessions de méditation -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium mb-4">Meditation Sessions</h3>
                        <div v-for="session in meditationSessions" 
                             :key="session.id"
                             class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
                        >
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                            <span class="text-purple-600">{{ session.icon }}</span>
                                        </div>
                                        <div>
                                            <h3 class="font-medium">{{ session.title }}</h3>
                                            <p class="text-sm text-gray-500">{{ session.duration }} • {{ session.level }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">{{ session.description }}</p>
                                </div>
                                <button 
                                    class="p-2 text-purple-600 hover:bg-purple-50 rounded-full transition-colors"
                                    @click="startSession(session)"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path v-if="activeSession?.id !== session.id" 
                                              stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path v-else 
                                              stroke-linecap="round" 
                                              stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Progress bar pour la session active -->
                            <div v-if="activeSession?.id === session.id" class="mt-4">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div 
                                        class="bg-purple-600 h-2 rounded-full transition-all duration-1000"
                                        :style="{ width: `${(1 - (remainingTime / (session.durationInSeconds))) * 100}%` }"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips et instructions -->
                <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-medium mb-4">Meditation Tips</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div v-for="(tip, index) in meditationTips" 
                             :key="index"
                             class="bg-gray-50 rounded-lg p-4"
                        >
                            <div class="flex items-center mb-3">
                                <span class="text-purple-600 text-xl mr-3">{{ tip.icon }}</span>
                                <h4 class="font-medium">{{ tip.title }}</h4>
                            </div>
                            <p class="text-sm text-gray-600">{{ tip.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import rainSound from '@/../sounds/rain.mp3'
import wavesSound from '@/../sounds/waves.mp3'
import forestSound from '@/../sounds/forest.mp3'
import whiteNoiseSound from '@/../sounds/white-noise.mp3'

const toast = useToast()
const activeSession = ref(null)
const remainingTime = ref(0)
const isTimerRunning = ref(false)
const timerInterval = ref(null)
const currentSound = ref(null)
const audio = ref(null)

const backgroundSounds = [
    { id: 'rain', name: 'Rain', icon: '🌧', url: rainSound },  // Utilise l'import
    { id: 'waves', name: 'Ocean', icon: '🌊', url: wavesSound },  // Chemin direct
    { id: 'forest', name: 'Forest', icon: '🌲', url: forestSound },
    { id: 'white-noise', name: 'White Noise', icon: '🌫', url: whiteNoiseSound }
]

const meditationSessions = [
    {
        id: 1,
        icon: '🌅',
        title: 'Morning Meditation',
        duration: '5 min',
        durationInSeconds: 300,
        description: 'Start your day with mindful breathing and intention setting',
        level: 'Beginner'
    },
    {
        id: 2,
        icon: '🧘',
        title: 'Stress Relief',
        duration: '10 min',
        durationInSeconds: 600,
        description: 'Guided relaxation for anxiety and stress reduction',
        level: 'Beginner'
    },
    {
        id: 3,
        icon: '🌟',
        title: 'Deep Focus',
        duration: '15 min',
        durationInSeconds: 900,
        description: 'Enhance concentration and mental clarity',
        level: 'Intermediate'
    }
]

const meditationTips = [
    {
        icon: '🧘‍♂️',
        title: 'Posture',
        description: 'Sit comfortably with your back straight. You can use a cushion or chair.'
    },
    {
        icon: '👃',
        title: 'Breathing',
        description: 'Focus on your breath. Notice the sensation of air moving in and out.'
    },
    {
        icon: '🧠',
        title: 'Mindset',
        description: 'Let thoughts come and go without judgment. Return focus to your breath.'
    }
]

const formatTime = (seconds) => {
    const minutes = Math.floor(seconds / 60)
    const remainingSeconds = seconds % 60
    return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`
}

const startSession = (session) => {
    if (activeSession.value?.id === session.id) {
        stopSession()
    } else {
        stopSession()
        activeSession.value = session
        remainingTime.value = session.durationInSeconds
        toast.info(`Starting ${session.title}`)
        startTimer()
    }
}

const toggleTimer = () => {
    if (isTimerRunning.value) {
        pauseTimer()
    } else {
        startTimer()
    }
}

const startTimer = () => {
    if (!isTimerRunning.value && remainingTime.value > 0) {
        isTimerRunning.value = true
        timerInterval.value = setInterval(() => {
            if (remainingTime.value > 0) {
                remainingTime.value--
            } else {
                stopSession()
                toast.success('Meditation session completed!')
            }
        }, 1000)
    }
}

const pauseTimer = () => {
    isTimerRunning.value = false
    clearInterval(timerInterval.value)
}

const resetTimer = () => {
    if (activeSession.value) {
        remainingTime.value = activeSession.value.durationInSeconds
        pauseTimer()
    }
}

const stopSession = () => {
    pauseTimer()
    activeSession.value = null
    remainingTime.value = 0
}

const toggleSound = (soundId) => {
    if (currentSound.value === soundId) {
        if (audio.value) {
            audio.value.pause()
            audio.value = null
        }
        currentSound.value = null
    } else {
        const sound = backgroundSounds.find(s => s.id === soundId)
        if (sound) {
            if (audio.value) {
                audio.value.pause()
            }
            audio.value = new Audio(sound.url)
            audio.value.loop = true
            audio.value.play()
            currentSound.value = soundId
        }
    }
}

onUnmounted(() => {
    clearInterval(timerInterval.value)
    if (audio.value) {
        audio.value.pause()
        audio.value = null
    }
})
</script>

<style scoped>
.transition-colors {
    transition: all 0.2s ease-in-out;
}

.session-progress-enter-active,
.session-progress-leave-active {
    transition: all 0.5s ease-out;
}

.session-progress-enter-from,
.session-progress-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}
</style>