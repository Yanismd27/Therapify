<template>
    <div class="min-h-screen bg-[#FAFAFA] flex">
      <!-- Notification -->
      <transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="showNotification"
          :class="[
            'fixed top-4 right-4 z-50 rounded-lg p-4 shadow-lg max-w-sm w-full',
            notificationType === 'success' 
              ? 'bg-green-50 border border-green-100' 
              : 'bg-red-50 border border-red-100'
          ]"
        >
          <div class="flex items-start">
            <!-- Success Icon -->
            <div v-if="notificationType === 'success'" class="flex-shrink-0">
              <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <!-- Error Icon -->
            <div v-else class="flex-shrink-0">
              <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
  
            <div class="ml-3 w-0 flex-1">
              <p 
                :class="[
                  'text-sm font-medium',
                  notificationType === 'success' ? 'text-green-800' : 'text-red-800'
                ]"
              >
                {{ notificationMessage }}
              </p>
            </div>
  
            <!-- Close Button -->
            <div class="ml-4 flex-shrink-0 flex">
              <button
                @click="showNotification = false"
                class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none"
              >
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </transition>
  
      <!-- Left Side - Form -->
      <div class="w-full lg:w-1/2 p-8 lg:p-12 flex items-center justify-center">
        <div class="w-full max-w-md">
          <!-- Logo and Home Link -->
          <div class="flex items-center mb-12">
            <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center">
              <div class="h-6 w-6 bg-white rounded-full"></div>
            </div>
            <Link :href="route('home')" class="ml-3 text-xl font-bold tracking-tight hover:text-purple-600 transition-colors">
              Therapify
            </Link>
          </div>
  
          <h1 class="text-3xl font-bold mb-8">Create your account</h1>
  
          <form @submit.prevent="submit">
            <div class="space-y-6">
              <!-- Name Input -->
              <div>
                <InputLabel for="name" value="Full Name" class="text-gray-700 font-medium" />
                <TextInput
                  id="name"
                  type="text"
                  v-model="form.name"
                  class="mt-2 w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                  placeholder="Enter your full name"
                  required
                  autofocus
                />
                <InputError class="mt-2" :message="form.errors.name" />
              </div>
  
              <!-- Email Input -->
              <div>
                <InputLabel for="email" value="Email Address" class="text-gray-700 font-medium" />
                <TextInput
                  id="email"
                  type="email"
                  v-model="form.email"
                  class="mt-2 w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                  placeholder="you@example.com"
                  required
                />
                <InputError class="mt-2" :message="form.errors.email" />
              </div>
  
              <!-- Account Type Selection -->
              <div>
                <InputLabel value="I am a" class="text-gray-700 font-medium mb-2" />
                <div class="grid grid-cols-2 gap-4">
                  <button
                    type="button"
                    @click="form.role = 'patient'"
                    :class="[
                      'p-4 rounded-xl border-2 text-left hover:border-purple-500 transition-all',
                      form.role === 'patient' ? 'border-purple-500 bg-purple-50' : 'border-gray-200'
                    ]"
                  >
                    <div class="font-medium">Patient</div>
                    <div class="text-sm text-gray-500">Looking for therapy</div>
                  </button>
                  <button
                    type="button"
                    @click="form.role = 'therapist'"
                    :class="[
                      'p-4 rounded-xl border-2 text-left hover:border-purple-500 transition-all',
                      form.role === 'therapist' ? 'border-purple-500 bg-purple-50' : 'border-gray-200'
                    ]"
                  >
                    <div class="font-medium">Therapist</div>
                    <div class="text-sm text-gray-500">Providing therapy</div>
                  </button>
                </div>
              </div>
  
              <!-- Password Input -->
              <div>
                <InputLabel for="password" value="Password" class="text-gray-700 font-medium" />
                <div class="relative flex items-center">
                  <TextInput
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    v-model="form.password"
                    class="mt-2 w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                    required
                    @input="checkPasswordStrength"
                  />
                  <button 
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 h-full mt-2 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                  >
                    <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4l16 16" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 16.5C15.0104 17.4559 13.3088 18 11.5 18C6.52944 18 2.73867 15.0571 1.45808 11C2.02252 9.37087 2.9603 7.93014 4.16795 6.81802M8.5 5.5C9.45834 5.16626 10.4696 5 11.5 5C16.4706 5 20.2613 7.94291 21.5419 12C21.1339 13.1356 20.5261 14.1801 19.7482 15.0863" />
                    </svg>
                  </button>
                </div>
  
                <!-- Password Strength Indicator -->
                <div class="mt-2">
                  <div class="flex items-center justify-between mb-1">
                    <div class="text-sm text-gray-500">Password strength:</div>
                    <div class="text-sm" :class="strengthColor">{{ passwordStrength }}</div>
                  </div>
                  <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div 
                      class="h-full transition-all duration-300 ease-in-out"
                      :class="strengthBarColor"
                      :style="{ width: `${strengthScore}%` }"
                    ></div>
                  </div>
  
                  <!-- Password Requirements -->
                  <div class="mt-2 space-y-1">
                    <div v-for="(req, key) in requirements" 
                         :key="key" 
                         class="text-sm flex items-center space-x-2"
                         :class="req.met ? 'text-green-600' : 'text-gray-500'"
                    >
                      <span class="flex-shrink-0">{{ req.met ? '✓' : '○' }}</span>
                      <span>{{ getRequirementText(key) }}</span>
                    </div>
                  </div>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
              </div>
  
              <!-- Confirm Password Input -->
              <div>
                <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-700 font-medium" />
                <div class="relative flex items-center">
                  <TextInput
                    id="password_confirmation"
                    :type="showPasswordConfirm ? 'text' : 'password'"
                    v-model="form.password_confirmation"
                    class="mt-2 w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                    required
                  />
                  <button 
                    type="button"
                    @click="showPasswordConfirm = !showPasswordConfirm"
                    class="absolute right-3 h-full mt-2 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                  >
                    <svg v-if="showPasswordConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4l16 16" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 16.5C15.0104 17.4559 13.3088 18 11.5 18C6.52944 18 2.73867 15.0571 1.45808 11C2.02252 9.37087 2.9603 7.93014 4.16795 6.81802M8.5 5.5C9.45834 5.16626 10.4696 5 11.5 5C16.4706 5 20.2613 7.94291 21.5419 12C21.1339 13.1356 20.5261 14.1801 19.7482 15.0863" />
                    </svg>
                  </button>
                </div>
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
              </div>
  
              <!-- Submit Button -->
              <div class="pt-4">
                <button
                  type="submit"
                  :disabled="form.processing || !passwordIsStrong"
                  :class="[
                    'w-full px-6 py-3 bg-purple-600 text-white rounded-xl font-medium transition-all duration-200',
                    (form.processing || !passwordIsStrong) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-purple-700 hover:shadow-md active:transform active:scale-[0.99]'
                  ]"
                >
                  <span v-if="form.processing">Creating account...</span>
                  <span v-else>Create Account</span>
                </button>
              </div>
  
              <!-- Login Link -->
              <div class="text-center text-gray-600">
                Already have an account?
                <Link
                  :href="route('login')"
                  class="text-purple-600 font-medium hover:text-purple-700"
                >
                  Log in
                </Link>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Right Side - Features -->
    <div class="hidden lg:block w-1/2 bg-gray-50 p-12">
      <div class="h-full rounded-2xl bg-white p-8 shadow-lg">
        <h2 class="text-2xl font-bold mb-6">Why Choose Therapify?</h2>
        
        <div class="space-y-6">
          <div class="flex items-start space-x-4">
            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
              <span class="text-purple-600">✓</span>
            </div>
            <div>
              <h3 class="font-medium">Verified Professionals</h3>
              <p class="text-gray-600">All our therapists are licensed and verified</p>
            </div>
          </div>

          <div class="flex items-start space-x-4">
            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
              <span class="text-purple-600">✓</span>
            </div>
            <div>
              <h3 class="font-medium">Easy Scheduling</h3>
              <p class="text-gray-600">Book and manage appointments with ease</p>
            </div>
          </div>

          <div class="flex items-start space-x-4">
            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
              <span class="text-purple-600">✓</span>
            </div>
            <div>
              <h3 class="font-medium">Secure Sessions</h3>
              <p class="text-gray-600">Private and confidential therapy sessions</p>
            </div>
          </div>
        </div>

        <div class="mt-12 bg-gray-50 rounded-xl p-6">
          <div class="flex items-start space-x-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex-shrink-0"></div>
            <div>
              <p class="text-gray-600 italic">"Therapify made it easy for me to find the right therapist and start my journey to better mental health."</p>
              <p class="mt-2 font-medium">Sarah M.</p>
              <p class="text-sm text-gray-500">Patient since 2023</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

// Notification state
const showNotification = ref(false);
const notificationMessage = ref('');
const notificationType = ref('success');

const showPassword = ref(false);
const showPasswordConfirm = ref(false);
const requirements = ref({
  length: { met: false },
  number: { met: false },
  special: { met: false },
  capital: { met: false }
});

const getRequirementText = (key) => {
  const texts = {
    length: 'At least 8 characters',
    number: 'Contains a number',
    special: 'Contains a special character',
    capital: 'Contains a capital letter'
  };
  return texts[key];
};

const strengthScore = ref(0);
const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'patient'
});

const passwordStrength = computed(() => {
  if (strengthScore.value >= 100) return 'Very Strong';
  if (strengthScore.value >= 80) return 'Strong';
  if (strengthScore.value >= 60) return 'Good';
  if (strengthScore.value >= 40) return 'Fair';
  if (strengthScore.value > 0) return 'Weak';
  return 'Too Weak';
});

const passwordIsStrong = computed(() => {
  return strengthScore.value >= 60;
});

const strengthColor = computed(() => {
  if (strengthScore.value >= 100) return 'text-green-600';
  if (strengthScore.value >= 80) return 'text-green-500';
  if (strengthScore.value >= 60) return 'text-yellow-500';
  if (strengthScore.value >= 40) return 'text-orange-500';
  return 'text-red-500';
});

const strengthBarColor = computed(() => {
  if (strengthScore.value >= 100) return 'bg-green-600';
  if (strengthScore.value >= 80) return 'bg-green-500';
  if (strengthScore.value >= 60) return 'bg-yellow-500';
  if (strengthScore.value >= 40) return 'bg-orange-500';
  return 'bg-red-500';
});

const checkPasswordStrength = () => {
  const password = form.password;
  
  requirements.value.length.met = password.length >= 8;
  requirements.value.number.met = /\d/.test(password);
  requirements.value.special.met = /[!@#$%^&*(),.?":{}|<>]/.test(password);
  requirements.value.capital.met = /[A-Z]/.test(password);

  let score = 0;
  if (requirements.value.length.met) score += 25;
  if (requirements.value.number.met) score += 25;
  if (requirements.value.special.met) score += 25;
  if (requirements.value.capital.met) score += 25;

  strengthScore.value = score;
};

const submit = () => {
  if (!passwordIsStrong.value) {
    return;
  }
  
  form.post(route('register'), {
    onSuccess: () => {
      notificationMessage.value = 'Account created successfully! Redirecting...';
      notificationType.value = 'success';
      showNotification.value = true;
      
      setTimeout(() => {
        showNotification.value = false;
      }, 5000);
    },
    onError: () => {
      notificationMessage.value = 'Error creating account. Please try again.';
      notificationType.value = 'error';
      showNotification.value = true;
      
      setTimeout(() => {
        showNotification.value = false;
      }, 5000);
    },
    onFinish: () => {
      form.reset('password', 'password_confirmation');
      strengthScore.value = 0;
      requirements.value = {
        length: { met: false },
        number: { met: false },
        special: { met: false },
        capital: { met: false }
      };
    },
  });
};
</script>

<style scoped>
.focus-within\:border-purple-500:focus-within {
  border-color: #8B5CF6;
}

.focus-within\:ring-purple-500:focus-within {
  --tw-ring-color: #8B5CF6;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.password-requirements {
  animation: fadeIn 0.3s ease-out;
}

/* Add smooth transitions for interactive elements */
button {
  transition: all 0.2s ease-in-out;
}

.strength-bar-transition {
  transition: width 0.3s ease-in-out;
}

/* Notification animations */
.notification-enter-active,
.notification-leave-active {
  transition: all 0.3s ease;
}

.notification-enter-from,
.notification-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}

.close-button {
  transition: opacity 0.2s ease;
}

.close-button:hover {
  opacity: 0.7;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.notification {
  animation: fadeInDown 0.3s ease-out;
}
</style>