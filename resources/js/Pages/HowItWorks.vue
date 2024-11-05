<template>
  <div class="min-h-screen bg-[#FAFAFA]">
    <!-- Navigation -->
    <nav class="w-full py-6 px-6 lg:px-12 border-b bg-white">
      <div class="flex justify-between items-center">
        <!-- Logo -->
        <Link :href="route('home')" class="flex items-center group">
          <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center transition-transform group-hover:scale-110">
            <div class="h-6 w-6 bg-white rounded-full"></div>
          </div>
          <span class="ml-3 text-xl font-bold tracking-tight">Therapify</span>
        </Link>
        
        <!-- Menu -->
        <div class="hidden lg:flex items-center space-x-10">
          <Link 
            v-for="item in menuItems" 
            :key="item.text"
            :href="item.href"
            class="text-gray-600 hover:text-gray-900 relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 hover:after:w-full after:bg-purple-600 after:transition-all"
          >
            {{ item.text }}
          </Link>
        </div>
        
        <!-- Auth Buttons -->
        <div class="hidden lg:flex items-center space-x-4">
          <Link 
            :href="route('login')"
            class="px-6 py-2 text-gray-700 hover:text-gray-900 transition-colors"
          >
            Sign In
          </Link>
          <Link 
            :href="route('register')"
            class="px-6 py-2.5 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-all transform hover:scale-105"
          >
            Get Started →
          </Link>
        </div>
 
        <!-- Mobile Menu Button -->
        <button 
          @click="mobileMenuOpen = !mobileMenuOpen"
          class="lg:hidden p-2 rounded-lg hover:bg-gray-100"
        >
          <span class="sr-only">Menu</span>
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
 
      <!-- Mobile Menu -->
      <div 
        v-show="mobileMenuOpen"
        class="lg:hidden absolute top-20 left-0 right-0 bg-white shadow-lg p-4 transition-all transform z-50"
        :class="mobileMenuOpen ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-4'"
      >
        <div class="space-y-4">
          <Link 
            v-for="item in menuItems" 
            :key="item.text"
            :href="item.href"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg"
          >
            {{ item.text }}
          </Link>
          <hr class="my-2">
          <Link 
            :href="route('login')"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg"
          >
            Sign In
          </Link>
          <Link 
            :href="route('register')"
            class="block px-4 py-2 bg-purple-600 text-white rounded-lg text-center hover:bg-purple-700"
          >
            Get Started
          </Link>
        </div>
      </div>
    </nav>
 
    <!-- Main Content -->
    <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
      <div class="relative">
        <!-- Hero Section -->
        <div class="max-w-3xl mx-auto text-center mb-20">
          <h1 class="text-5xl lg:text-7xl font-bold leading-tight tracking-tight text-gray-900 mb-8">
            Begin Your
            <span class="relative">
              <span class="text-purple-600">Journey</span>
              <svg class="absolute -bottom-2 left-0 w-full h-2 text-purple-200" viewBox="0 0 100 10">
                <path d="M0 5 Q 25 0, 50 5 T 100 5" fill="none" stroke="currentColor" stroke-width="2"/>
              </svg>
            </span>
            to Wellness
          </h1>
          <p class="text-xl text-gray-600">
            Discover how our platform makes mental healthcare accessible, personal, and effective
          </p>
        </div>
 
        <!-- Process Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
          <div v-for="(step, index) in mainSteps" 
               :key="index"
               class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-1 group">
            <div class="flex items-center space-x-4 mb-6">
              <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="text-2xl">{{ step.icon }}</span>
              </div>
              <span class="text-purple-600 font-medium">Step {{ index + 1 }}</span>
            </div>
            <h3 class="text-xl font-semibold mb-4">{{ step.title }}</h3>
            <p class="text-gray-600">{{ step.description }}</p>
          </div>
        </div>
 
        <!-- Feature Sections -->
        <div class="space-y-32">
          <!-- Matching Section -->
          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
              <div class="inline-flex items-center px-4 py-2 bg-purple-100 rounded-full text-purple-600 font-medium mb-4">
                <span class="mr-2">🎯</span> Perfect Match
              </div>
              <h2 class="text-4xl font-bold mb-6">Find Your Ideal Therapist</h2>
              <p class="text-xl text-gray-600 mb-8">
                Our intelligent matching system helps you connect with therapists who understand your unique needs and goals.
              </p>
              <ul class="space-y-4">
                <li v-for="(feature, index) in matchingFeatures" 
                    :key="index"
                    class="flex items-start">
                  <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1 mr-4">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                  </div>
                  <span>{{ feature }}</span>
                </li>
              </ul>
            </div>
            <div class="bg-gradient-to-br from-purple-100 to-blue-50 p-8 rounded-2xl">
              <div class="aspect-w-4 aspect-h-3 bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center space-x-4 mb-6">
                  <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <span class="text-3xl">👩‍⚕️</span>
                  </div>
                  <div>
                    <h4 class="font-semibold">Dr. Sarah Johnson</h4>
                    <p class="text-gray-500">Psychologist, PhD</p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Experience</p>
                    <p class="font-medium">10+ Years</p>
                  </div>
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Rating</p>
                    <div class="flex items-center">
                      <span class="text-yellow-400 mr-1">⭐</span>
                      <span class="font-medium">4.9</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
 
          <!-- Booking Section -->
          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1 bg-gradient-to-br from-purple-100 to-blue-50 p-8 rounded-2xl">
              <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="border-b pb-4 mb-4">
                  <h4 class="font-semibold mb-2">Book Your Session</h4>
                  <p class="text-gray-500 text-sm">Choose a time that works for you</p>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-6">
                  <div v-for="time in ['9:00', '10:00', '11:00']" 
                       :key="time"
                       class="px-3 py-2 bg-purple-50 text-purple-600 rounded-lg text-center text-sm cursor-pointer hover:bg-purple-100">
                    {{ time }}
                  </div>
                </div>
                <button class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition-colors">
                  Confirm Booking
                </button>
              </div>
            </div>
            <div class="order-1 lg:order-2 space-y-6">
              <div class="inline-flex items-center px-4 py-2 bg-purple-100 rounded-full text-purple-600 font-medium mb-4">
                <span class="mr-2">📅</span> Easy Scheduling
              </div>
              <h2 class="text-4xl font-bold mb-6">Flexible Booking System</h2>
              <p class="text-xl text-gray-600 mb-8">
                Book and manage your therapy sessions with ease. Choose from various time slots and session types.
              </p>
              <div class="grid sm:grid-cols-2 gap-6">
                <div v-for="(feature, index) in bookingFeatures" 
                     :key="index"
                     class="bg-white p-6 rounded-xl shadow-sm">
                  <h4 class="font-semibold mb-2">{{ feature.title }}</h4>
                  <p class="text-gray-600">{{ feature.description }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
 
        <!-- CTA Section -->
        <div class="mt-32 text-center bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl p-12 relative overflow-hidden">
          <div class="absolute inset-0 bg-pattern opacity-10"></div>
          <div class="relative z-10">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Start Your Journey?</h2>
            <p class="text-purple-100 text-xl mb-8 max-w-2xl mx-auto">
              Take the first step towards better mental health today. Our therapists are here to help.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
              <Link
                :href="route('register')"
                class="inline-flex px-8 py-4 bg-white text-purple-600 rounded-xl hover:bg-gray-50 transition-colors font-medium"
              >
                Get Started Now
              </Link>
              <Link
                :href="route('our-therapists')"
                class="inline-flex px-8 py-4 bg-purple-500 text-white rounded-xl hover:bg-purple-400 transition-colors font-medium"
              >
                Browse Therapists
              </Link>
            </div>
          </div>
        </div>
 
        <!-- Background Effects -->
        <div class="absolute top-1/2 right-0 -translate-y-1/2 w-96 h-96 bg-purple-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
        <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-blue-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
      </div>
    </div>
  </div>
 </template>
 
 <script setup>
 import { Link } from '@inertiajs/vue3';
 
 
 const mainSteps = [
  {
    icon: '🔍',
    title: 'Match',
    description: 'Find the perfect therapist using our smart matching system.'
  },
  {
    icon: '📅',
    title: 'Schedule',
    description: 'Book your sessions at times that work best for you.'
  },
  {
    icon: '💬',
    title: 'Connect',
    description: 'Meet your therapist through our secure video platform.'
  },
  {
    icon: '📈',
    title: 'Progress',
    description: 'Track your journey and see your improvement over time.'
  }
 ];
 
 const matchingFeatures = [
  'Advanced matching algorithm based on your preferences',
  'Detailed therapist profiles with verified credentials',
  'Read reviews from other clients',
  'Multiple specialties and treatment approaches'
 ];
 
 const bookingFeatures = [
  {
    title: 'Flexible Scheduling',
    description: 'Choose from various time slots that fit your schedule'
  },
  {
    title: 'Multiple Session Types',
    description: 'Video, audio, or chat sessions available'
  },
  {
    title: 'Easy Rescheduling',
    description: 'Change your appointment time with no hassle'
  },
  {
    title: 'Instant Confirmation',
    description: 'Get immediate confirmation for your bookings'
  }
 ];
 </script>
 
 <style scoped>
/* Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes scaleIn {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.fade-in-up {
  animation: fadeInUp 0.6s ease-out forwards;
}

.scale-in {
  animation: scaleIn 0.5s ease-out forwards;
}

/* Card transitions */
.card-hover {
  transition: all 0.3s ease;
}

.card-hover:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px -8px rgba(107, 33, 168, 0.15);
}

/* Gradient background for CTA */
.bg-gradient-custom {
  background: linear-gradient(135deg, #7e22ce 0%, #4f46e5 100%);
}

/* Pattern background */
.bg-pattern {
  background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0);
  background-size: 24px 24px;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: #d8b4fe;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #c084fc;
}

/* Responsive padding adjustments */
@media (max-width: 768px) {
  .section-padding {
    padding: 3rem 1.5rem;
  }
}

/* Custom shape divider */
.shape-divider {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 60px;
  overflow: hidden;
}

.shape-divider svg {
  position: relative;
  display: block;
  width: calc(100% + 1.3px);
  height: 60px;
}
</style>