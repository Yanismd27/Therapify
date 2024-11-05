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
  
          <h1 class="text-3xl font-bold mb-2">Welcome back</h1>
          <p class="text-gray-600 mb-8">Please enter your details to sign in</p>
  
          <!-- Status Message -->
          <div v-if="status" class="mb-4 p-4 bg-green-50 rounded-xl text-green-600">
            {{ status }}
          </div>
  
          <form @submit.prevent="submit" class="space-y-6">
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
                autofocus
              />
              <InputError class="mt-2" :message="form.errors.email" />
            </div>
  
            <!-- Password Input -->
            <div>
              <div class="flex items-center justify-between">
                <InputLabel for="password" value="Password" class="text-gray-700 font-medium" />
                <Link
                  v-if="canResetPassword"
                  :href="route('password.request')"
                  class="text-sm text-purple-600 hover:text-purple-700"
                >
                  Forgot password?
                </Link>
              </div>
              <TextInput
                id="password"
                type="password"
                v-model="form.password"
                class="mt-2 w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-purple-500"
                required
              />
              <InputError class="mt-2" :message="form.errors.password" />
            </div>
  
            <!-- Remember Me -->
            <div class="flex items-center">
              <Checkbox name="remember" v-model:checked="form.remember" class="text-purple-600 focus:ring-purple-500" />
              <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </div>
  
            <!-- Submit Button -->
            <button
              type="submit"
              :disabled="form.processing"
              class="w-full px-6 py-3 bg-purple-600 text-white rounded-xl font-medium hover:bg-purple-700 transition-all disabled:opacity-50"
            >
              Sign in
            </button>
  
            <!-- Register Link -->
            <div class="text-center text-gray-600">
              Don't have an account?
              <Link :href="route('register')" class="text-purple-600 font-medium hover:text-purple-700">
                Sign up for free
              </Link>
            </div>
          </form>
        </div>
      </div>
  
      <!-- Right Side - Features -->
      <div class="hidden lg:block w-1/2 bg-gray-50 p-12">
        <div class="h-full rounded-2xl bg-white p-8 shadow-lg">
          <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Continue Your Journey</h2>
            <p class="text-gray-600">Access your therapy sessions and resources in one place</p>
          </div>
  
                 <!-- Feature Cards -->
                 <div class="space-y-6">
            <!-- Upcoming Session Card -->
            <div class="bg-gray-50 rounded-xl p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold">Next Session</h3>
                <span class="text-purple-600 text-sm font-medium">Today</span>
              </div>
              <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex-shrink-0"></div>
                <div class="ml-4">
                  <p class="font-medium">Dr. Sarah Wilson</p>
                  <p class="text-sm text-gray-500">2:00 PM - Online Session</p>
                </div>
              </div>
            </div>
  
            <!-- Resources Card -->
            <div class="bg-gray-50 rounded-xl p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold">Resources</h3>
                <span class="text-purple-600 text-sm font-medium">4 New</span>
              </div>
              <p class="text-gray-600 text-sm">
                Access your personalized therapy resources and exercises
              </p>
            </div>
  
            <!-- Progress Card -->
            <div class="bg-purple-50 rounded-xl p-6">
              <h3 class="font-semibold mb-2">Your Progress</h3>
              <div class="flex items-center">
                <div class="w-full bg-purple-200 rounded-full h-2">
                  <div class="bg-purple-600 h-2 rounded-full" style="width: 75%"></div>
                </div>
                <span class="ml-4 text-sm font-medium">75%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link, useForm } from '@inertiajs/vue3';
  import Checkbox from '@/Components/Checkbox.vue';
  import InputError from '@/Components/InputError.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import TextInput from '@/Components/TextInput.vue';
  
  const props = defineProps({
    canResetPassword: Boolean,
    status: String,
  });
  
  const form = useForm({
    email: '',
    password: '',
    remember: false,
  });
  
  const submit = () => {
    form.post(route('login'), {
      onFinish: () => form.reset('password'),
    });
  };
  </script>