<template>
  <div class="min-h-screen flex flex-col bg-[#FAFAFA]">
    <main class="flex-grow">
      <nav class="w-full py-6 px-6 lg:px-12">
        <div class="flex justify-between items-center">
          <!-- Logo -->
          <div class="flex items-center group">
            <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center transition-transform group-hover:scale-110">
              <div class="h-6 w-6 bg-white rounded-full"></div>
            </div>
            <span class="ml-3 text-xl font-bold tracking-tight">Therapify</span>
          </div>
          
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
              class="px-6 py-2.5 bg-black text-white rounded-full hover:bg-gray-800 transition-all transform hover:scale-105"
            >
              Get Started →
            </Link>
          </div>
  
          <button 
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="lg:hidden"
          >
            <span class="sr-only">Menu</span>
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>

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
              class="block px-4 py-2 bg-black text-white rounded-lg text-center"
            >
              Get Started
            </Link>
          </div>
        </div>
      </nav>
  

      <div class="max-w-[1400px] mx-auto px-6 lg:px-12 pt-12">
        <div class="relative">

          <div class="max-w-3xl mx-auto text-center mb-16">
            <h1 class="text-5xl lg:text-7xl font-bold leading-tight tracking-tight text-gray-900 mb-8">
              Find Your Perfect
              <span class="relative">
                <span class="text-purple-600">Match</span>
                <svg class="absolute -bottom-2 left-0 w-full h-2 text-purple-200" viewBox="0 0 100 10">
                  <path class="wavy-path" d="M0 5 Q 25 0, 50 5 T 100 5" fill="none" stroke="currentColor" stroke-width="2"/>
                </svg>
              </span>
              in Mental Health Care
            </h1>
            <p class="text-xl text-gray-600 mb-12">
              Connect with verified therapists, schedule sessions, and start your journey to better mental health - all in one place.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
              <Link
                :href="route('register')"
                class="px-8 py-4 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-all transform hover:scale-105 hover:shadow-lg"
              >
                Find Your Therapist
              </Link>
              <Link
                :href="route('how-it-works')"
                class="px-8 py-4 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all transform hover:scale-105"
              >
                How It Works
              </Link>
            </div>
          </div>
  
          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-32">
            <div 
              v-for="(feature, index) in features"
              :key="feature.title"
              class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all transform hover:-translate-y-1"
            >
              <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                <span class="text-purple-600 text-xl">{{ feature.icon }}</span>
              </div>
              <h3 class="text-xl font-semibold mb-2">{{ feature.title }}</h3>
              <p class="text-gray-600">{{ feature.description }}</p>
            </div>
          </div>
  
          <div class="absolute top-1/2 right-0 -translate-y-1/2 w-96 h-96 bg-purple-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
          <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-blue-200 rounded-full filter blur-3xl opacity-30 -z-10"></div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';

const mobileMenuOpen = ref(false);

const menuItems = [
  { text: 'Home', href: route('home') },
  { text: 'Our Therapists', href: route('our-therapists') },
  { text: 'How it Works', href: route('how-it-works') },
];

const features = [
  {
    icon: '👥',
    title: 'Verified Therapists',
    description: 'Connect with licensed and thoroughly vetted mental health professionals.'
  },
  {
    icon: '📅',
    title: 'Easy Scheduling',
    description: 'Book and manage your therapy sessions with just a few clicks.'
  },
  {
    icon: '🤖',
    title: 'AI Support',
    description: 'Get 24/7 assistance and guidance between your therapy sessions.'
  }
];
</script>

<style>
@keyframes waveFloat {
  0% {
    d: path("M0 5 Q 25 3, 50 5 T 100 5");
  }
  25% {
    d: path("M0 5 Q 25 7, 50 5 T 100 5");
  }
  50% {
    d: path("M0 5 Q 25 6, 50 4 T 100 5");
  }
  75% {
    d: path("M0 5 Q 25 4, 50 6 T 100 5");
  }
  100% {
    d: path("M0 5 Q 25 3, 50 5 T 100 5");
  }
}

.wavy-path {
  animation: waveFloat 3s cubic-bezier(0.445, 0.05, 0.55, 0.95) infinite;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
  animation: fadeIn 0.6s ease-out forwards;
}

.animation-delay-200 { animation-delay: 200ms; }
.animation-delay-400 { animation-delay: 400ms; }
.animation-delay-600 { animation-delay: 600ms; }
.animation-delay-800 { animation-delay: 800ms; }
.animation-delay-1000 { animation-delay: 1000ms; }
</style>