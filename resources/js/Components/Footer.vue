<template>
  <footer class="relative bg-white border-t mt-32">
    <div class="absolute inset-0 bg-white/80 backdrop-blur-sm"></div>
    
    <!-- Main Footer -->
    <div class="relative z-10 max-w-[1400px] mx-auto px-6 lg:px-12 py-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
        <!-- Brand Column -->
        <div class="lg:col-span-2">
          <div class="flex items-center mb-6">
            <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center">
              <div class="h-6 w-6 bg-white rounded-full"></div>
            </div>
            <span class="ml-3 text-xl font-bold tracking-tight">Therapify</span>
          </div>
          <p class="text-gray-600 mb-6 max-w-sm">
            Connecting you with licensed mental health professionals for a better, healthier life.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-purple-600 transform transition hover:scale-110" aria-label="LinkedIn">
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 0H5C2.239 0 0 2.239 0 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5V5c0-2.761-2.238-5-5-5zM8 19H5V8h3v11zM6.5 6.732c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zM20 19h-3v-5.604c0-3.368-4-3.113-4 0V19h-3V8h3v1.765c1.396-2.586 7-2.777 7 2.476V19z"/>
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-purple-600 transform transition hover:scale-110" aria-label="Twitter">
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
              </svg>
            </a>
          </div>
        </div>

        <div>
          <h3 class="text-gray-900 font-semibold mb-4">Company</h3>
          <ul class="space-y-3">
            <li>
              <Link :href="route('company.about')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                About Us
              </Link>
            </li>
            <li>
              <Link :href="route('company.contact')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Contact
              </Link>
            </li>
            <li>
              <Link :href="route('company.careers')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Careers
              </Link>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-gray-900 font-semibold mb-4">Legal</h3>
          <ul class="space-y-3">
            <li>
              <Link :href="route('legal.privacy')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Privacy Policy
              </Link>
            </li>
            <li>
              <Link :href="route('legal.terms')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Terms of Service
              </Link>
            </li>
            <li>
              <Link :href="route('legal.cookies')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Cookie Policy
              </Link>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-gray-900 font-semibold mb-4">Healthcare</h3>
          <ul class="space-y-3">
            <li>
              <Link :href="route('policies.patient')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Patient Policy
              </Link>
            </li>
            <li>
              <Link :href="route('policies.therapist')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Therapist Policy
              </Link>
            </li>
            <li>
              <Link :href="route('policies.appointment')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Appointment Policy
              </Link>
            </li>
            <li>
              <Link :href="route('policies.review')" 
                    class="text-gray-600 hover:text-purple-600 transition-colors duration-200">
                Review Policy
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Bottom Footer -->
    <div class="relative z-10 border-t">
      <div class="max-w-[1400px] mx-auto px-6 lg:px-12 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
          <div class="text-gray-500 text-sm">
            © {{ new Date().getFullYear() }} Therapify. All rights reserved.
          </div>
          <div class="flex flex-wrap justify-center md:justify-end gap-6">
            <Link :href="route('accessibility')" 
                  class="text-gray-500 hover:text-purple-600 text-sm transition-colors duration-200">
              Accessibility
            </Link>
            <Link :href="route('sitemap')" 
                  class="text-gray-500 hover:text-purple-600 text-sm transition-colors duration-200">
              Sitemap
            </Link>
          </div>
        </div>

        <!-- Healthcare Disclaimer -->
        <div class="mt-6 pt-6 border-t">
          <p class="text-gray-500 text-sm text-center max-w-4xl mx-auto">
            Disclaimer: Therapify is a platform connecting patients with mental health professionals. 
            We do not provide medical advice. The content on this site is for informational purposes only. 
            In case of emergency, please contact your local emergency services or crisis hotline immediately.
          </p>
          <div class="mt-4 flex flex-wrap justify-center gap-4">
            <a href="tel:3114" 
               class="text-purple-600 hover:text-purple-700 text-sm font-medium transition-colors duration-200">
              Crisis Hotline: 3114
            </a>
            <span class="text-gray-300 hidden sm:inline">|</span>
            <Link :href="route('emergency-resources')" 
                  class="text-purple-600 hover:text-purple-700 text-sm font-medium transition-colors duration-200">
              Emergency Resources
            </Link>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const selectedRegion = ref('fr');

const handleRegionChange = () => {
  console.log('Region changed to:', selectedRegion.value);
};
</script>

<style scoped>
footer {
  width: 100%;
  margin-top: auto;
}


.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 200ms;
}

.hover\:scale-110:hover {
  transform: scale(1.1);
}


a:focus, button:focus, select:focus {
  outline: 2px solid transparent;
  outline-offset: 2px;
  --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
  --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
  box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
  --tw-ring-color: rgba(147, 51, 234, 0.5);
}


select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
  background-position: right 0.25rem center;
  background-repeat: no-repeat;
  background-size: 1.25em 1.25em;
  padding-right: 2rem;
}

@media (max-width: 768px) {
  .grid-cols-1 {
    row-gap: 2rem;
  }
  
  .flex-wrap {
    flex-wrap: wrap;
  }
}
</style>