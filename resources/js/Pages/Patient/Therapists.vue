<template>
  <Head title="Find a Therapist" />

  <AuthenticatedLayout>
    <div class="min-h-screen bg-gradient-to-b from-[#FAFAFA] to-white">
      <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
        <div class="relative">
          
          <div class="max-w-3xl mx-auto text-center mb-16 animate-fade-in">
            <span class="text-purple-600 font-medium mb-4 inline-block px-4 py-1 bg-purple-50 rounded-full">Our Therapists</span>
            <h1 class="text-4xl lg:text-5xl font-bold leading-tight tracking-tight text-gray-900 mb-4 mt-2">
              Find Your Perfect
              <span class="relative">
                <span class="text-purple-600">Match</span>
                <svg class="absolute -bottom-2 left-0 w-full h-2 text-purple-200" viewBox="0 0 100 12">
                  <path class="wavy-path" d="M0 6 Q 25 2, 50 6 T 100 6" fill="none" stroke="currentColor" stroke-width="2"/>
                </svg>
              </span>
            </h1>
            <p class="text-xl text-gray-600 mb-8">
              Browse our network of qualified therapists and find the right one for you.
            </p>

            <div class="flex flex-col md:flex-row gap-4 max-w-2xl mx-auto mb-12 filter drop-shadow-sm">
              <div class="flex-grow relative group">
                <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 group-focus-within:text-purple-500">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                  </svg>
                </span>
                <input
                  type="text"
                  v-model="search"
                  placeholder="Search by name, specialty, or keywords..."
                  class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-shadow hover:shadow-sm"
                  @input="handleSearch"
                />
              </div>
              <div class="md:w-1/3">
                <select
                  v-model="selectedSpecialty"
                  class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500 transition-shadow hover:shadow-sm appearance-none bg-white"
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

          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div v-if="filteredTherapists.length === 0" 
                 class="col-span-full text-center text-gray-500 py-12 bg-white/50 rounded-xl backdrop-blur-sm">
              <span class="text-4xl mb-4 block">🔍</span>
              <p class="text-lg">No therapists found matching your criteria.</p>
            </div>

            <div v-for="therapist in filteredTherapists" 
                 :key="therapist.id"
                 class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all p-6 relative overflow-hidden hover:-translate-y-1 duration-300">
              <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 opacity-0 group-hover:opacity-100 rounded-full -translate-x-16 -translate-y-16 transition-all duration-300"></div>
              
              <div class="flex items-start space-x-4 mb-4 relative">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-50 rounded-full flex items-center justify-center flex-shrink-0 ring-2 ring-purple-100">
                  <span class="text-2xl text-purple-600 font-semibold">
                    {{ therapist.user?.name?.[0] || '?' }}
                  </span>
                </div>
                <div>
                  <h3 class="text-xl font-semibold group-hover:text-purple-600 transition-colors">{{ therapist.user?.name }}</h3>
                  <p class="text-purple-600">{{ therapist.specialty }}</p>
                  <div class="flex items-center mt-1">
                    <div class="flex items-center">
                      <span v-if="therapist.average_rating" class="text-yellow-400 mr-1">⭐</span>
                      <span v-if="therapist.average_rating" class="font-medium">{{ therapist.average_rating }}</span>
                      <span v-else class="text-sm px-2 py-0.5 bg-purple-50 text-purple-600 rounded-full">New</span>
                    </div>
                    <span class="mx-2 text-gray-300">•</span>
                    <span class="text-gray-500">{{ therapist.experience }}</span>
                  </div>
                </div>
              </div>

              <p class="text-gray-600 mb-4 line-clamp-3 relative">
                {{ therapist.bio || 'No bio available' }}
              </p>

              <div class="space-y-2 mb-4">
                <div v-if="therapist.education" class="text-sm text-gray-600 flex items-start gap-2">
                  <svg class="w-4 h-4 mt-0.5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                  </svg>
                  <span><strong>Education:</strong> {{ therapist.education }}</span>
                </div>
                <div class="text-sm text-gray-600 flex items-start gap-2">
                  <svg class="w-4 h-4 mt-0.5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                  </svg>
                  <span><strong>License:</strong> {{ therapist.license_number }}</span>
                </div>
              </div>

              <div class="flex items-center border-t pt-4 relative">
                <div class="flex-1">
                  <div class="text-sm text-gray-500">Session Price</div>
                  <div class="font-medium text-lg">{{ formatPrice(therapist.hourly_rate) }}</div>
                </div>
                <button 
                  @click="bookAppointment(therapist)"
                  class="px-6 py-2.5 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-all transform hover:scale-105 hover:shadow-md"
                >
                  Book Session
                </button>
              </div>
            </div>
          </div>

          <div class="absolute top-1/2 right-0 -translate-y-1/2 w-96 h-96 bg-purple-200 rounded-full filter blur-3xl opacity-20 -z-10 animate-pulse"></div>
          <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-blue-200 rounded-full filter blur-3xl opacity-20 -z-10 animate-pulse" style="animation-delay: 1s;"></div>
        </div>
      </div>
    </div>

    <Modal :show="showBookingModal" @close="closeBookingModal">
      <div class="p-6">
        <h2 class="text-2xl font-semibold mb-6 flex items-center">
          <span class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </span>
          Book a Session
        </h2>
        
        <div v-if="selectedTherapist" class="space-y-6">
          <div class="flex items-center p-4 bg-purple-50 rounded-xl">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-50 rounded-full flex items-center justify-center mr-4 ring-2 ring-purple-100">
              <span class="text-xl text-purple-600 font-semibold">
                {{ selectedTherapist.user?.name?.[0] }}
              </span>
            </div>
            <div>
              <h3 class="font-medium">{{ selectedTherapist.user?.name }}</h3>
              <p class="text-sm text-purple-600">{{ selectedTherapist.specialty }}</p>
            </div>
          </div>

          <div class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Select Date</label>
              <input 
                type="date" 
                v-model="bookingDate"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                :min="minDate"
              />
              <div v-if="form.errors.scheduled_at" class="text-red-500 text-sm mt-1">
                {{ form.errors.scheduled_at }}
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Available Time Slots</label>
              <div class="grid grid-cols-3 gap-2">
                <button 
                  v-for="time in availableTimeSlots" 
                  :key="time"
                  @click="selectedTime = time"
                  :class="[
                    'px-4 py-2.5 rounded-lg text-sm font-medium transition-all',
                    selectedTime === time 
                      ? 'bg-purple-600 text-white shadow-sm' 
                      : 'bg-gray-50 text-gray-700 hover:bg-gray-100'
                  ]"
                >
                  {{ time }}
                </button>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Session Type</label>
              <div class="grid grid-cols-3 gap-2">
                <button
                  v-for="type in ['video', 'audio', 'chat']"
                  :key="type"
                  @click="sessionType = type"
                  :class="[
                    'px-4 py-2.5 rounded-lg text-sm font-medium transition-all flex items-center justify-center',
                    sessionType === type
                      ? 'bg-purple-600 text-white shadow-sm'
                      : 'bg-gray-50 text-gray-700 hover:bg-gray-100'
                  ]"
                >
                  <svg v-if="type === 'video'" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                  </svg>
                  <svg v-if="type === 'audio'" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                  </svg>
                  <svg v-if="type === 'chat'" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 1-7.547 1-9 1s-7.235-1-9-1c-1.674 0-3-1.326-3-3s1.326-3 3-3c1.765 0 7.547 1 9 1s7.235-1 9-1c1.674 0 3 1.326 3 3s-1.326 3-3 3z" />
                  </svg>
                  {{ type.charAt(0).toUpperCase() + type.slice(1) }}
                </button>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
              <textarea 
                v-model="notes"
                rows="3"
                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                placeholder="Any specific concerns or topics you'd like to discuss..."
              ></textarea>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg space-y-3">
              <div class="flex justify-between items-center">
                <span class="text-gray-600">Session Fee</span>
                <span class="font-medium text-lg">{{ formatPrice(selectedTherapist.hourly_rate) }}</span>
              </div>
              <div class="flex justify-between items-center text-sm text-gray-500">
                <span>Duration</span>
                <span>50 minutes</span>
              </div>
              <div class="pt-2 border-t">
                <div class="flex justify-between items-center font-medium">
                  <span>Total</span>
                  <span class="text-lg">{{ formatPrice(selectedTherapist.hourly_rate) }}</span>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6">
            <button 
              @click="confirmBooking"
              class="w-full px-6 py-3 bg-purple-600 text-white rounded-xl font-medium hover:bg-purple-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed hover:shadow-md transform hover:scale-[1.02] active:scale-[0.98]"
              :disabled="!isBookingValid"
            >
              Confirm Booking
            </button>
            <p class="text-center text-sm text-gray-500 mt-3">
              You can reschedule or cancel up to 24 hours before the session
            </p>
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
import toast from '@/Utils/toast';

const props = defineProps({
  therapists: {
    type: Array,
    default: () => []
  }
});

const search = ref('');
const selectedSpecialty = ref('');
const showBookingModal = ref(false);
const selectedTherapist = ref(null);
const bookingDate = ref('');
const selectedTime = ref('');
const sessionType = ref('video');
const notes = ref('');

const form = useForm({
  therapist_id: null,
  scheduled_at: null,
  type: sessionType.value,
  notes: ''
});

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
  return Array.from(specialtiesSet).sort();
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

const availableTimeSlots = [
  '9:00 AM', '10:00 AM', '11:00 AM',
  '2:00 PM', '3:00 PM', '4:00 PM'
];

const handleSearch = () => {
  // Implemented if needed
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

const confirmBooking = () => {
  if (!isBookingValid.value) {
    toast.error("Veuillez remplir tous les champs requis");
    return;
  }

  const selectedDateTime = new Date(`${bookingDate.value} ${selectedTime.value}`);
  form.therapist_id = selectedTherapist.value.id;
  form.scheduled_at = selectedDateTime.toISOString();
  form.type = sessionType.value;
  form.notes = notes.value;

  form.post(route('appointments.store'), {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      toast.success("Rendez-vous programmé avec succès");
      closeBookingModal();
      window.location.href = route('appointments.index');
    },
    onError: (errors) => {
      toast.error("Erreur lors de la réservation");
      console.error('Booking errors:', errors);
    }
  });
};
</script>

<style scoped>
@keyframes waveFloat {
  0% {
    d: path("M0 6 Q 25 2, 50 6 T 100 6");
  }
  25% {
    d: path("M0 6 Q 25 10, 50 6 T 100 6");
  }
  50% {
    d: path("M0 6 Q 25 8, 50 3 T 100 6");
  }
  75% {
    d: path("M0 6 Q 25 4, 50 9 T 100 6");
  }
  100% {
    d: path("M0 6 Q 25 2, 50 6 T 100 6");
  }
}

.wavy-path {
  animation: waveFloat 3.5s cubic-bezier(0.445, 0.05, 0.55, 0.95) infinite;
}

@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out forwards;
}

@keyframes pulse {
  0%, 100% { opacity: 0.2; }
  50% { opacity: 0.3; }
}

.animate-pulse {
  animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>