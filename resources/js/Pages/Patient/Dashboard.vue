<template>
    <Head title="Patient Dashboard" />
   
    <AuthenticatedLayout>
      <div class="min-h-screen bg-[#FAFAFA]">
        <!-- Stats Section -->
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
          <div class="relative">
            <!-- Welcome Section -->
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
                Track your therapy journey and manage your appointments in one place.
              </p>
            </div>
   
            <!-- Stats Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
              <div v-for="stat in stats" :key="stat.title" 
                   class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                  <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <span class="text-purple-600 text-xl">{{ stat.icon }}</span>
                  </div>
                  <span 
                    v-if="stat.progress" 
                    class="text-sm px-2 py-1 rounded-full bg-green-100 text-green-600"
                  >
                    {{ stat.progress }}%
                  </span>
                </div>
                <h3 class="text-2xl font-bold mb-1">{{ stat.value }}</h3>
                <p class="text-gray-600">{{ stat.title }}</p>
              </div>
            </div>
   
            <!-- Main Content Grid -->
            <div class="grid lg:grid-cols-3 gap-8">
              <!-- Upcoming Sessions -->
              <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6">
                  <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Upcoming Sessions</h2>
                    <Link 
                      :href="route('patient.appointments')"
                      class="text-purple-600 hover:text-purple-700 flex items-center"
                    >
                      View All
                      <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                      </svg>
                    </Link>
                  </div>
   
                  <div class="space-y-4">
                    <div v-if="!upcomingAppointments?.length" 
                         class="text-center py-8 text-gray-500">
                      <div class="mb-4">
                        <span class="text-4xl">📅</span>
                      </div>
                      <p class="mb-4">No upcoming sessions scheduled</p>
                      <Link
                        :href="route('patient.therapists')"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-colors"
                      >
                        Find a Therapist
                      </Link>
                    </div>
   
                    <div v-else v-for="appointment in upcomingAppointments" 
                         :key="appointment.id"
                         class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                      <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                          {{ appointment.therapist?.name?.[0] || '?' }}
                        </div>
                        <div>
                          <h4 class="font-medium">Dr. {{ appointment.therapist?.name }}</h4>
                          <p class="text-sm text-gray-500">
                            {{ new Date(appointment.scheduled_at).toLocaleString() }}
                          </p>
                        </div>
                      </div>
                      <div class="flex space-x-2">
                        <button 
                          class="p-2 text-purple-600 hover:bg-purple-50 rounded-full"
                          title="Join Session"
                        >
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                          </svg>
                        </button>
                        <button 
                          @click="openCancelModal(appointment)"
                          class="p-2 text-red-600 hover:bg-red-50 rounded-full"
                          title="Cancel Appointment"
                        >
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
   
                <!-- Your Therapists -->
                <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
                  <h2 class="text-2xl font-semibold mb-6">Your Therapists</h2>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div v-if="!myTherapists?.length" class="md:col-span-2 text-center py-8 text-gray-500">
                      <p>No therapists yet. Start your journey by finding the right match.</p>
                    </div>
   
                    <div v-else v-for="therapist in myTherapists" 
                         :key="therapist.id"
                         class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                      <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                          {{ therapist.user?.name?.[0] || '?' }}
                        </div>
                        <div>
                          <h4 class="font-medium">Dr. {{ therapist.user?.name }}</h4>
                          <p class="text-sm text-gray-500">{{ therapist.specialty }}</p>
                        </div>
                      </div>
                      <div class="flex justify-between">
                        <Link 
                          :href="route('patient.appointments')"
                          class="text-purple-600 hover:text-purple-700 text-sm"
                        >
                          Book Session
                        </Link>
                        <span class="text-sm text-gray-500">
                          {{ therapist.sessions_count || 0 }} sessions
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
   
              <!-- Quick Actions & Progress -->
              <div class="space-y-6">
                <!-- Journey Progress -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                  <h2 class="text-lg font-semibold mb-4">Your Journey</h2>
                  <div class="space-y-4">
                    <div v-for="(progress, index) in journeyProgress" 
                         :key="index"
                         class="mb-4">
                      <div class="flex justify-between mb-2">
                        <span class="text-sm text-gray-600">{{ progress.title }}</span>
                        <span class="text-sm font-medium">{{ progress.value }}%</span>
                      </div>
                      <div class="w-full bg-gray-200 rounded-full h-2">
                        <div 
                          class="bg-purple-600 h-2 rounded-full transition-all duration-500" 
                          :style="{ width: `${progress.value}%` }"
                        ></div>
                      </div>
                    </div>
                  </div>
                </div>
   
                <!-- Quick Actions -->
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
   
                <!-- Resources -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                  <h2 class="text-lg font-semibold mb-4">Resources</h2>
                  <div class="space-y-4">
                    <Link 
                      v-for="resource in resources" 
                      :key="resource.title"
                      :href="resource.href"
                      class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
                    >
                      <h3 class="font-medium mb-1">{{ resource.title }}</h3>
                      <p class="text-sm text-gray-500">{{ resource.description }}</p>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
   
            <!-- Background Effects -->
            <div class="absolute top-1/2 right-0 -translate-y-1/2 w-96 h-96 bg-purple-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
            <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-blue-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
          </div>
        </div>
      </div>
   
      <!-- Modal de confirmation d'annulation -->
      <Modal :show="showCancelModal" @close="closeCancelModal">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-medium">Cancel Appointment</h3>
              <p class="text-sm text-gray-500">Are you sure you want to cancel this appointment?</p>
            </div>
          </div>
   
          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  Please avoid canceling appointments less than 24 hours before the scheduled time. Late cancellations may affect your therapist's schedule and other patients.
                </p>
              </div>
            </div>
          </div>
   
          <div class="mt-4 flex justify-end space-x-3">
            <button
              @click="closeCancelModal"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
            >
              Keep Appointment
            </button>
            <button
              @click="confirmCancel"
              class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700"
            >
              Cancel Appointment
            </button>
          </div>
        </div>
      </Modal>
    </AuthenticatedLayout>
   </template>
   
   <script setup>
   import { ref, computed } from 'vue';
   import { Head, Link, router } from '@inertiajs/vue3';
   import { usePage } from '@inertiajs/vue3';
   import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
   import Modal from '@/Components/Modal.vue';
   import { useToast } from 'vue-toastification';
   
   const page = usePage();
   const user = computed(() => page.props.auth.user);
   
   const toast = useToast();
   const showCancelModal = ref(false);
   const selectedAppointment = ref(null);
   
   defineProps({
    upcomingAppointments: {
      type: Array,
      default: () => []
    },
    pastAppointments: {
      type: Array,
      default: () => []
    },
    myTherapists: {
      type: Array,
      default: () => []
    }
   });
   
   // Méthodes pour la gestion de l'annulation
   const openCancelModal = (appointment) => {
    selectedAppointment.value = appointment;
    showCancelModal.value = true;
   };
   
   const closeCancelModal = () => {
    showCancelModal.value = false;
    selectedAppointment.value = null;
   };
   
   const confirmCancel = () => {
  if (!selectedAppointment.value) return;

  const appointmentDate = new Date(selectedAppointment.value.scheduled_at);
  const now = new Date();
  const hoursUntilAppointment = (appointmentDate - now) / (1000 * 60 * 60);

  if (hoursUntilAppointment < 24) {
    toast.warning("Attention: Cette annulation est faite moins de 24h avant le rendez-vous");
  }

  router.post(route('appointments.cancel', { appointment: selectedAppointment.value.id }), {}, {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Rendez-vous annulé avec succès");
      closeCancelModal();
      router.visit(route('patient.dashboard')); // Changé ici
    },
    onError: () => {
      toast.error("Erreur lors de l'annulation du rendez-vous");
    }
  });
};
   
   // Statistiques
   const stats = [
    { 
      title: 'Next Session', 
      value: 'Tomorrow', 
      icon: '📅'
    },
    { 
      title: 'Total Sessions', 
      value: '12', 
      progress: '+2',
      icon: '🎯'
    },
    { 
      title: 'Wellbeing Score', 
      value: '8.5', 
      progress: '+12',
      icon: '💪'
    },
    { 
      title: 'Goals Met', 
      value: '4/6', 
      progress: '66',
      icon: '🎉'
    }
   ];
   
   // Progression du parcours
   const journeyProgress = [
    { title: 'Profile Completion', value: 85 },
    { title: 'Goals Progress', value: 60 },
    { title: 'Session Attendance', value: 90 }
   ];
   
   // Actions rapides
   const quickActions = [
    {
        icon: '📅',
        title: 'Book Session',
        description: 'Schedule your next therapy session',
        href: route('patient.therapists')
    },
    {
        icon: '📝',
        title: 'Journal Entry',
        description: 'Write about your day',
        href: route('patient.wellness.journal')  // Modifié ici
    },
    {
        icon: '🎯',
        title: 'Update Goals',
        description: 'Track your progress',
        href: '#'
    }
];
   
   // Ressources
   const resources = [
    {
        title: 'Meditation Guide',
        description: 'Learn basic meditation techniques',
        href: route('patient.wellness.meditation')  
    },
    {
        title: 'Stress Management',
        description: 'Tips for managing daily stress',
        href: route('patient.wellness.stress')  
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
   
   /* Animation pour la modale de confirmation */
   .modal-enter-active,
   .modal-leave-active {
    transition: opacity 0.3s ease;
   }
   
   .modal-enter-from,
   .modal-leave-to {
    opacity: 0;
   }
   
   /* Style pour le bouton d'annulation au survol */
   .cancel-button {
    transition: all 0.2s ease-in-out;
   }
   
   .cancel-button:hover {
    transform: scale(1.05);
   }
   
   /* Animation pour l'alerte */
   .alert-enter-active,
   .alert-leave-active {
    transition: all 0.3s ease;
   }
   
   .alert-enter-from,
   .alert-leave-to {
    opacity: 0;
    transform: translateY(-20px);
   }
   </style>