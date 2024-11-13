import { useToast as useVueToast } from 'vue-toastification';
import { h } from 'vue';
import './toast.css';

const commonStyles = {
    toastClassName: 'custom-toast',
    bodyClassName: ['custom-toast-body'],
    hideProgressBar: true,
    showCloseButtonOnHover: false,
    closeButton: "button",
    icon: true,
    position: "top-right",
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    closeOnClick: true,
};

const icons = {
    success: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`,
    error: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`,
    warning: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`,
    info: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`
};

const toast = {
    success(message) {
        const toast = useVueToast();
        toast.success(message, {
            ...commonStyles,
            icon: h('div', {
                className: 'custom-toast-icon success',
                innerHTML: icons.success
            }),
            toastClassName: 'custom-toast custom-toast-success',
            timeout: 3000,
        });
    },

    error(message) {
        const toast = useVueToast();
        toast.error(message, {
            ...commonStyles,
            icon: h('div', {
                className: 'custom-toast-icon error',
                innerHTML: icons.error
            }),
            toastClassName: 'custom-toast custom-toast-error',
            timeout: 5000,
        });
    },

    warning(message) {
        const toast = useVueToast();
        toast.warning(message, {
            ...commonStyles,
            icon: h('div', {
                className: 'custom-toast-icon warning',
                innerHTML: icons.warning
            }),
            toastClassName: 'custom-toast custom-toast-warning',
            timeout: 4000,
        });
    },

    info(message) {
        const toast = useVueToast();
        toast.info(message, {
            ...commonStyles,
            icon: h('div', {
                className: 'custom-toast-icon info',
                innerHTML: icons.info
            }),
            toastClassName: 'custom-toast custom-toast-info',
            timeout: 3000,
        });
    }
};

export default toast;

export { toast };