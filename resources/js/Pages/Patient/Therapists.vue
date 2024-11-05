<template>
  <Head title="Find a Therapist" />

  <AuthenticatedLayout>
    <div class="min-h-screen bg-[#FAFAFA]">
      <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
        <div class="relative">
          <!-- Hero Section -->
          <div class="max-w-3xl mx-auto text-center mb-16">
            <h1 class="text-4xl lg:text-5xl font-bold leading-tight tracking-tight text-gray-900 mb-4">
              Find Your Perfect
              <span class="relative">
                <span class="text-purple-600">Match</span>
                <svg class="absolute -bottom-2 left-0 w-full h-2 text-purple-200" viewBox="0 0 100 10">
                  <path d="M0 5 Q 25 0, 50 5 T 100 5" fill="none" stroke="currentColor" stroke-width="2"/>
                </svg>
              </span>
            </h1>
            <p class="text-xl text-gray-600 mb-8">
              Browse our network of qualified therapists and find the right one for you.
            </p>

            <!-- Search and Filter -->
            <div class="flex flex-col md:flex-row gap-4 max-w-2xl mx-auto mb-12">
              <div class="flex-grow">
                <input
                  type="text"
                  v-model="search"
                  placeholder="Search by name, specialty, or keywords..."
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                  @input="handleSearch"
                />
              </div>
              <div class="md:w-1/3">
                <select
                  v-model="selectedSpecialty"
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                  @change="handleSearch"
                >
                  <option value="">All Specialties</option>
                  <option v-for="specialty in specialties" :key="specialty" :value="specialty">
                    {{ specialty }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- Therapists Grid -->
          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-if="filteredTherapists.length === 0" class="col-span-full text-center text-gray-500 py-12">
              No therapists found matching your criteria.
            </div>

            <div v-for="therapist in filteredTherapists" :key="therapist.id"
                 class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all p-6">
              <div class="flex items-start space-x-4 mb-4">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                  <span class="text-2xl text-purple-600">
                    {{ therapist.user?.name?.[0] || '?' }}
                  </span>
                </div>
                <div>
                  <h3 class="text-xl font-semibold">{{ therapist.user?.name }}</h3>
                  <p class="text-purple-600">{{ therapist.specialty }}</p>
                  <div class="flex items-center mt-1">
                    <div class="flex items-center">
                      <span v-if="therapist.average_rating" class="text-yellow-400 mr-1">⭐</span>
                      <span v-if="therapist.average_rating" class="font-medium">{{ therapist.average_rating }}</span>
                      <span v-else class="text-gray-500">New</span>
                    </div>
                    <span class="mx-2">•</span>
                    <span class="text-gray-500">{{ therapist.experience }}</span>
                  </div>
                </div>
              </div>

              <p class="text-gray-600 mb-4 line-clamp-3">
                {{ therapist.bio || 'No bio available' }}
              </p>

              <div class="space-y-2 mb-4">
                <div v-if="therapist.education" class="text-sm text-gray-600">
                  <strong>Education:</strong> {{ therapist.education }}
                </div>
                <div class="text-sm text-gray-600">
                  <strong>License:</strong> {{ therapist.license_number }}
                </div>
              </div>

              <div class="flex items-center border-t pt-4">
                <div class="flex-1">
                  <div class="text-sm text-gray-500">Session Price</div>
                  <div class="font-medium">{{ formatPrice(therapist.hourly_rate) }}</div>
                </div>
                <button 
                  @click="bookAppointment(therapist)"
                  class="px-4 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-colors"
                >
                  Book Session
                </button>
              </div>
            </div>
          </div>

          <!-- Background Effects -->
          <div class="absolute top-1/2 right-0 -translate-y-1/2 w-96 h-96 bg-purple-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
          <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-blue-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
        </div>
      </div>
    </div>

    <!-- Booking Modal -->
    <Modal :show="showBookingModal" @close="closeBookingModal">
      <div class="p-6">
        <h2 class="text-2xl font-semibold mb-4">Book a Session</h2>
        <div v-if="selectedTherapist" class="mb-6">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
              {{ selectedTherapist.user?.name?.[0] }}
            </div>
            <div>
              <h3 class="font-medium">{{ selectedTherapist.user?.name }}</h3>
              <p class="text-sm text-gray-500">{{ selectedTherapist.specialty }}</p>
            </div>
          </div>

          <div class="space-y-4">
            <!-- Date Selection -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Select Date</label>
              <input 
                type="date" 
                v-model="bookingDate"
                class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                :min="minDate"
              />
              <div v-if="form.errors.scheduled_at" class="text-red-500 text-sm mt-1">
  {{ form.errors.scheduled_at }}
</div>
            </div>

            <!-- Time Slots -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Available Time Slots</label>
              <div class="grid grid-cols-3 gap-2">
                <button 
                  v-for="time in availableTimeSlots" 
                  :key="time"
                  @click="selectedTime = time"
                  :class="[
                    'px-4 py-2 rounded-lg text-sm font-medium',
                    selectedTime === time 
                      ? 'bg-purple-600 text-white' 
                      : 'bg-gray-50 text-gray-700 hover:bg-gray-100'
                  ]"
                >
                  {{ time }}
                </button>
              </div>
            </div>

            <!-- Session Type -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Session Type</label>
              <select 
                v-model="sessionType"
                class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
              >
                <option value="video">Video Call</option>
                <option value="audio">Audio Call</option>
                <option value="chat">Chat Session</option>
              </select>
            </div>

            <!-- Notes -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
              <textarea 
                v-model="notes"
                rows="3"
                class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                placeholder="Any specific concerns or topics you'd like to discuss..."
              ></textarea>
            </div>

            <!-- Price Summary -->
            <div class="bg-gray-50 p-4 rounded-lg">
              <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Session Fee</span>
                <span class="font-medium">{{ formatPrice(selectedTherapist.hourly_rate) }}</span>
              </div>
              <p class="text-sm text-gray-500">Standard session (50 minutes)</p>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mt-6">
            <button 
              @click="confirmBooking"
              class="w-full px-6 py-3 bg-purple-600 text-white rounded-xl font-medium hover:bg-purple-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
              :disabled="!isBookingValid"
            >
              Book Session
            </button>
          </div>
        </div>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { useToast } from 'vue-toastification';

// Créer l'instance toast correctement
const toast = useToast();

// Tester le toast au montage du composant
onMounted(() => {
 console.log('Component mounted, testing toast...');
 toast.success("Composant chargé");
});

const props = defineProps({
 therapists: {
   type: Array,
   default: () => []
 }
});

// States
const search = ref('');
const selectedSpecialty = ref('');
const showBookingModal = ref(false);
const selectedTherapist = ref(null);
const bookingDate = ref('');
const selectedTime = ref('');
const sessionType = ref('video');
const notes = ref('');

// Form handling
const form = useForm({
 therapist_id: null,
 scheduled_at: null,
 type: sessionType.value,
 notes: ''
});

// Computed
const filteredTherapists = computed(() => {
 return props.therapists.filter(therapist => {
   const matchesSearch = !search.value || 
     therapist.user.name.toLowerCase().includes(search.value.toLowerCase()) ||
     (therapist.specialty && therapist.specialty.toLowerCase().includes(search.value.toLowerCase()));
   
   const matchesSpecialty = !selectedSpecialty.value || 
     therapist.specialty === selectedSpecialty.value;
   
   return matchesSearch && matchesSpecialty;
 });
});

const specialties = computed(() => {
 const specialtiesSet = new Set(props.therapists.map(t => t.specialty).filter(Boolean));
 return Array.from(specialtiesSet);
});

const minDate = computed(() => {
 const today = new Date();
 return today.toISOString().split('T')[0];
});

const isBookingValid = computed(() => {
 const now = new Date();
 const selectedDate = bookingDate.value && selectedTime.value 
   ? new Date(`${bookingDate.value} ${selectedTime.value}`) 
   : null;
 
 return bookingDate.value && 
        selectedTime.value && 
        sessionType.value && 
        selectedTherapist.value &&
        selectedDate > now;
});

// Time slots
const availableTimeSlots = [
 '9:00 AM', '10:00 AM', '11:00 AM',
 '2:00 PM', '3:00 PM', '4:00 PM'
];

// Methods
const handleSearch = () => {
 // La recherche est gérée automatiquement par le computed filteredTherapists
};

const formatPrice = (price) => {
 if (!price) return 'N/A';
 return new Intl.NumberFormat('en-US', {
   style: 'currency',
   currency: 'USD'
 }).format(price);
};

const bookAppointment = (therapist) => {
 selectedTherapist.value = therapist;
 showBookingModal.value = true;
};

const closeBookingModal = () => {
 showBookingModal.value = false;
 selectedTherapist.value = null;
 bookingDate.value = '';
 selectedTime.value = '';
 sessionType.value = 'video';
 notes.value = '';
 form.reset();
};

const parseTime = (timeStr) => {
 const [time, period] = timeStr.split(' ');
 const [hours, minutes] = time.split(':');
 let hour = parseInt(hours);
 
 if (period === 'PM' && hour !== 12) {
   hour += 12;
 } else if (period === 'AM' && hour === 12) {
   hour = 0;
 }
 
 return { hour, minutes: parseInt(minutes) };
};

const confirmBooking = () => {
  if (!isBookingValid.value) {
    toast.error("Veuillez remplir tous les champs requis");
    return;
  }

  // Format date and time
  const [hours, minutes] = selectedTime.value.match(/(\d+):(\d+)/).slice(1);
  let hour = parseInt(hours);
  const isPM = selectedTime.value.includes('PM');
  
  if (isPM && hour !== 12) hour += 12;
  if (!isPM && hour === 12) hour = 0;

  const scheduledDate = new Date(bookingDate.value);
  scheduledDate.setHours(hour);
  scheduledDate.setMinutes(parseInt(minutes));

  console.log('Préparation des données pour la réservation:', {
    therapist_id: selectedTherapist.value.id,
    scheduled_at: scheduledDate.toISOString(),
    type: sessionType.value,
    notes: notes.value
  });

  toast.info("Traitement de la réservation...");

  form.post(route('appointments.store'), {
    therapist_id: selectedTherapist.value.id,
    scheduled_at: scheduledDate.toISOString(),
    type: sessionType.value,
    notes: notes.value
  }, {
    preserveScroll: true,
    onSuccess: () => {
      console.log('Réservation réussie');
      toast.success("Rendez-vous programmé avec succès");
      closeBookingModal();
      router.get(route('appointments.index'));
    },
    onError: (errors) => {
      console.error('Erreurs de réservation:', errors);
      toast.error("Erreur lors de la réservation");
    }
  });
};
</script>