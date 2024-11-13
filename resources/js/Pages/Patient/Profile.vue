<template>
    <Head title="Patient Profile" />

    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#FAFAFA] py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center space-x-6">
                        <div class="h-24 w-24 bg-blue-100 rounded-full flex items-center justify-center text-2xl font-bold text-blue-600">
                            {{ user?.name?.charAt(0) ?? '' }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ user?.name }}</h1>
                            <p class="text-gray-600">{{ user?.email }}</p>
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-semibold mb-6">Personal Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input 
                                        type="text" 
                                        v-model="form.name"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input 
                                        type="email" 
                                        v-model="form.email"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input 
                                        type="tel" 
                                        v-model="form.phone"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <input 
                                        type="date" 
                                        v-model="form.date_of_birth"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                </div>
                            </div>
                        </div>

                        
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-semibold mb-6">Medical History</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Medical Conditions</label>
                                    <textarea 
                                        v-model="form.medical_conditions"
                                        rows="3"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="List any medical conditions..."
                                    ></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Medications</label>
                                    <textarea 
                                        v-model="form.medications"
                                        rows="3"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="List current medications..."
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-semibold mb-6">Emergency Contact</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Contact Name</label>
                                    <input 
                                        type="text" 
                                        v-model="form.emergency_contact_name"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Contact Phone</label>
                                    <input 
                                        type="tel" 
                                        v-model="form.emergency_contact_phone"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <input 
                                        type="text" 
                                        v-model="form.emergency_contact_relationship"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-xl font-semibold mb-6">Preferences</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Preferred Session Type</label>
                                    <select 
                                        v-model="form.preferred_session_type"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option value="video">Video Call</option>
                                        <option value="audio">Audio Call</option>
                                        <option value="chat">Chat</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Communication Preferences</label>
                                    <div class="mt-2 space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" v-model="form.email_notifications" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-600">Email notifications</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" v-model="form.sms_notifications" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-600">SMS notifications</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button 
                            @click="updateProfile"
                            class="w-full bg-blue-600 text-white py-3 rounded-xl font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    patient: {
        type: Object,
        required: true
    }
});

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    phone: props.patient?.phone || '',
    date_of_birth: props.patient?.date_of_birth || '',
    medical_conditions: props.patient?.medical_conditions || '',
    medications: props.patient?.medications || '',
    emergency_contact_name: props.patient?.emergency_contact_name || '',
    emergency_contact_phone: props.patient?.emergency_contact_phone || '',
    emergency_contact_relationship: props.patient?.emergency_contact_relationship || '',
    preferred_session_type: props.patient?.preferred_session_type || 'video',
    email_notifications: props.patient?.email_notifications || true,
    sms_notifications: props.patient?.sms_notifications || false,
});

const updateProfile = () => {
    form.patch(route('patient.profile.update'), {
        onSuccess: () => {
            toast.success('Profile updated successfully!');
        },
    });
};
</script>