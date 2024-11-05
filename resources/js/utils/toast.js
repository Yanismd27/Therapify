// resources/js/utils/toast.js
import { useToast as useVueToast } from 'vue-toastification';

export const toast = {
  success(message) {
    const toast = useVueToast();
    toast.success(message, {
      position: "top-right",
      timeout: 3000,
      closeOnClick: true,
      pauseOnHover: true,
      draggable: true,
      draggablePercent: 0.6,
    });
  },
  error(message) {
    const toast = useVueToast();
    toast.error(message, {
      position: "top-right",
      timeout: 5000,
      closeOnClick: true,
      pauseOnHover: true,
      draggable: true,
      draggablePercent: 0.6,
    });
  },
  warning(message) {
    const toast = useVueToast();
    toast.warning(message, {
      position: "top-right",
      timeout: 4000,
      closeOnClick: true,
      pauseOnHover: true,
      draggable: true,
      draggablePercent: 0.6,
    });
  },
  info(message) {
    const toast = useVueToast();
    toast.info(message, {
      position: "top-right",
      timeout: 3000,
      closeOnClick: true,
      pauseOnHover: true,
      draggable: true,
      draggablePercent: 0.6,
    });
  }
};