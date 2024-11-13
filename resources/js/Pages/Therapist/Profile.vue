<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from '@/utils/toast';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    therapist: {
        type: Object,
        required: true
    }
});

const form = useForm({
    specialty: props.therapist?.specialty || '',
    bio: props.therapist?.bio || '',
    hourly_rate: props.therapist?.hourly_rate || '',
    education: props.therapist?.education || '',
    experience: props.therapist?.experience || '',
    license_number: props.therapist?.license_number || '',
});

const submit = () => {
    form.post(route('therapist.profile.update'), {
        onSuccess: () => {
            toast.success('Profil mis à jour avec succès !');
        },
        onError: (errors) => {
            toast.error('Une erreur est survenue lors de la mise à jour.');
        }
    });
};
</script>

<template>
    <Head title="Profil Thérapeute" />

    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FAFAFA]">
            
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-6">
                      
                        <div class="h-24 w-24 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-2xl font-bold">
                            {{ props.user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ props.user.name }}</h1>
                            <p class="text-purple-600 font-medium">Thérapeute {{ form.specialty }}</p>
                            <p class="text-gray-500">{{ props.user.email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                  
                    <div class="lg:col-span-2 space-y-6">
            
                        <div class="bg-white rounded-xl shadow p-6">
                            <h2 class="text-lg font-semibold mb-4">À propos de moi</h2>
                            <textarea
                                v-model="form.bio"
                                rows="4"
                                class="w-full rounded-xl border-gray-200 resize-none focus:border-purple-500 focus:ring-purple-500"
                                placeholder="Parlez de votre approche thérapeutique..."
                            ></textarea>
                        </div>

                        <div class="bg-white rounded-xl shadow p-6">
                            <h2 class="text-lg font-semibold mb-4">Expérience professionnelle</h2>
                            <textarea
                                v-model="form.experience"
                                rows="4"
                                class="w-full rounded-xl border-gray-200 resize-none focus:border-purple-500 focus:ring-purple-500"
                                placeholder="Décrivez votre expérience professionnelle..."
                            ></textarea>
                        </div>

                        <div class="bg-white rounded-xl shadow p-6">
                            <h2 class="text-lg font-semibold mb-4">Formation</h2>
                            <textarea
                                v-model="form.education"
                                rows="4"
                                class="w-full rounded-xl border-gray-200 resize-none focus:border-purple-500 focus:ring-purple-500"
                                placeholder="Listez vos diplômes et certifications..."
                            ></textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white rounded-xl shadow p-6">
                            <h2 class="text-lg font-semibold mb-4">Informations professionnelles</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Spécialité
                                    </label>
                                    <input
                                        type="text"
                                        v-model="form.specialty"
                                        class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Numéro de licence
                                    </label>
                                    <input
                                        type="text"
                                        v-model="form.license_number"
                                        class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tarif horaire (€)
                                    </label>
                                    <input
                                        type="number"
                                        v-model="form.hourly_rate"
                                        class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow p-6">
                            <h2 class="text-lg font-semibold mb-4">Statistiques</h2>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Sessions réalisées</span>
                                    <span class="font-semibold">124</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Patients suivis</span>
                                    <span class="font-semibold">45</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Note moyenne</span>
                                    <div class="flex items-center">
                                        <span class="text-yellow-400">★★★★</span>
                                        <span class="text-gray-400">★</span>
                                        <span class="ml-1 font-semibold">4.2</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button 
                            @click="submit"
                            :disabled="form.processing"
                            class="w-full bg-purple-600 text-white py-3 rounded-xl font-medium transition-colors"
                            :class="{ 'opacity-75 cursor-not-allowed': form.processing, 'hover:bg-purple-700': !form.processing }"
                        >
                            <span v-if="form.processing">Enregistrement...</span>
                            <span v-else>Enregistrer les modifications</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.transition-colors {
    transition-property: background-color, opacity;
    transition-duration: 200ms;
    transition-timing-function: ease-in-out;
}
</style>