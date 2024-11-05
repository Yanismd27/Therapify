<template>
    <div class="min-h-screen bg-[#FAFAFA] flex">
      <!-- Left Side - Form -->
      <div class="w-full lg:w-1/2 p-8 lg:p-12 flex items-center justify-center">
        <div class="w-full max-w-md">
          <!-- Logo -->
          <div class="flex items-center mb-12">
            <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center">
              <div class="h-6 w-6 bg-white rounded-full"></div>
            </div>
            <span class="ml-3 text-xl font-bold tracking-tight">Therapify</span>
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
                <div class="relative">
                  <TextInput
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    v-model="form.password"
                    class="mt-2 w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                    required
                    @input="checkPasswordStrength"
                  />
                  <button 
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                  >
                    <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
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
                      class="h-full transition-all duration-300"
                      :class="strengthBarColor"
                      :style="{ width: strengthScore + '%' }"
                    ></div>
                  </div>
                  
                  <!-- Password Requirements -->
                  <div class="mt-2 space-y-1">
                    <div class="text-sm" :class="requirements.length.met ? 'text-green-600' : 'text-gray-500'">
                      <span class="mr-1">{{ requirements.length.met ? '✓' : '○' }}</span>
                      At least 8 characters
                    </div>
                    <div class="text-sm" :class="requirements.number.met ? 'text-green-600' : 'text-gray-500'">
                      <span class="mr-1">{{ requirements.number.met ? '✓' : '○' }}</span>
                      Contains a number
                    </div>
                    <div class="text-sm" :class="requirements.special.met ? 'text-green-600' : 'text-gray-500'">
                      <span class="mr-1">{{ requirements.special.met ? '✓' : '○' }}</span>
                      Contains a special character
                    </div>
                    <div class="text-sm" :class="requirements.capital.met ? 'text-green-600' : 'text-gray-500'">
                      <span class="mr-1">{{ requirements.capital.met ? '✓' : '○' }}</span>
                      Contains a capital letter
                    </div>
                  </div>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
              </div>
  
              <!-- Confirm Password Input -->
              <div>
                <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-700 font-medium" />
                <div class="relative">
                  <TextInput
                    id="password_confirmation"
                    :type="showPasswordConfirm ? 'text' : 'password'"
                    v-model="form.password_confirmation"
                    class="mt-2 w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                    required
                  />
                  <button 
                    type="button"
                    @click="showPasswordConfirm = !showPasswordConfirm"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                  >
                    <svg v-if="showPasswordConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
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
                    'w-full px-6 py-3 bg-purple-600 text-white rounded-xl font-medium transition-all',
                    (form.processing || !passwordIsStrong) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-purple-700'
                  ]"
                >
                  Create Account
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
  import { Link, useForm } from '@inertiajs/vue3';
  import InputError from '@/Components/InputError.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import TextInput from '@/Components/TextInput.vue';
  import { ref, computed } from 'vue';
  
  const showPassword = ref(false);
  const showPasswordConfirm = ref(false);
  const requirements = ref({
    length: { met: false },
    number: { met: false },
    special: { met: false },
    capital: { met: false }
  });
  
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
  return strengthScore.value >= 60; // Au moins "Good" pour autoriser la soumission
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
</style>