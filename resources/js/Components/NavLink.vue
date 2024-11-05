<template>
    <Link
      :href="href"
      :class="[
        'inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors duration-200',
        {
          'text-purple-600 relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-purple-600': isActive,
          'text-gray-600 hover:text-gray-900 relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 hover:after:w-full after:bg-purple-600 after:transition-all duration-300': !isActive
        }
      ]"
    >
      <slot />
    </Link>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  import { computed } from 'vue';
  
  const props = defineProps({
    href: {
      type: String,
      required: true
    },
    active: {
      type: Boolean,
      default: false
    }
  });
  
  const isActive = computed(() => props.active);
  </script>
  <style scoped>
  /* Hover animation for underline */
  .after\:transition-all {
    transition-property: width;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
  }
  
  /* Active state animation */
  .text-purple-600.after\:w-full:after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: currentColor;
    transform-origin: center;
    animation: slideIn 0.3s ease-out forwards;
  }
  
  @keyframes slideIn {
    from {
      transform: scaleX(0);
    }
    to {
      transform: scaleX(1);
    }
  }
  </style>