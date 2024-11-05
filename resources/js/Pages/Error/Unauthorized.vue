<template>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
      <div class="bg-white max-w-md w-full rounded-2xl shadow-lg p-8 text-center">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
          <div class="h-12 w-12 bg-purple-600 rounded-full flex items-center justify-center">
            <div class="h-8 w-8 bg-white rounded-full"></div>
          </div>
        </div>
  
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Access Denied</h1>
        <p class="text-gray-600 mb-8">{{ message || 'You are not authorized to access this page.' }}</p>
  
        <div class="space-y-4">
          <Link
            :href="route('dashboard')"
            class="block w-full px-6 py-3 bg-purple-600 text-white rounded-xl font-medium hover:bg-purple-700 transition-all"
          >
            Return to Dashboard
          </Link>
          
          <Link
            :href="route('login')"
            class="block w-full px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-all"
          >
            Sign in with different account
          </Link>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  
  defineProps({
    message: {
      type: String,
      default: ''
    }
  });
  </script>