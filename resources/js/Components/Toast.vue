<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    data: {
        type: Object,
        default: {
            status: '',
            message: ''
        },
    },
});

const emit = defineEmits(['close']);

watch(() => props.show, () => {
    if (props.show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = null;
    }
});

const close = () => {

    emit( 'close' );

    if( props.closeable ) {
        emit( 'close' );
    }

};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div v-show="show" class="inset-0 overflow-y-auto z-50">

                <!--transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
                        <div class="absolute inset-0 bg-gray-500 opacity-75" />
                    </div>
                </transition-->
                
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div>
                        <div v-if="data?.status=='success'">
                            <div id="toast-bottom-right" class="flex fixed right-6 bottom-5 items-center p-4 space-x-4 w-full max-w-xs bg-emerald-500 rounded-lg divide-x divide-gray-200 shadow justify-between" role="alert">
                                <div class="text-sm font-normal text-white">{{ data?.message }}</div>
                                <div class="flex items-center ml-auto space-x-2 pl-4">
                                    <a class="text-sm font-medium px-2 py-1.5 text-amber-100 bg-transparent hover:underline rounded-lg" href="#">Nuevo</a>
                                    <button type="button" class="bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" @click="close">
                                        <span class="sr-only">Close</span>
                                        <svg aria-hidden="true" class="w-5 h-5" fill="#474747" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-if="data?.status=='error'">
                            <div id="toast-bottom-right" class="flex absolute right-6 bottom-5 items-center p-4 space-x-4 w-full max-w-xs bg-red-500 rounded-lg divide-x divide-gray-200 shadow" role="alert">
                                <div class="text-sm font-normal text-white">{{ data?.message }}</div>
                                <div class="flex items-center ml-auto space-x-2 pl-4">
                                    <a class="text-sm font-medium px-2 py-1.5 text-amber-100 bg-transparent hover:underline rounded-lg" href="#">Nuevo</a>
                                    <button type="button" class="bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-undo" aria-label="Close" v-on:click="openToast=false">
                                        <span class="sr-only">Close</span>
                                        <svg aria-hidden="true" class="w-5 h-5 color" fill="#474747" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                </transition>

            </div>
        </transition>
    </teleport>
</template>
