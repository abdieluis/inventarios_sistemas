<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';


const confirmingUserDeletion = ref(false);

const passwordInput = ref(null);
const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    //setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteItem = ( id ) => {
    form.delete( route('employees.destroy', id ), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        // onError: () => passwordInput.value.focus(),
        // onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
};

</script>

<template>
    <AppLayout title="Dashboard">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Responsivas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto px-4">
                
                <div class="bg-white shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-8 bg-white border-b border-gray-200">

                        <header class="bg-white">
                            <div class="flex items-center justify-between">
                                <div class="my-4">
                                    <div class="mb-1 text-xl font-semibold tracking-tight text-gray-900">
                                        {{ data.equipment.category?.name }}, {{ data.equipment.brand?.name }} {{ data.equipment.model }}
                                    </div>
                                    <div class="text-gray-500">
                                        <span v-if="(data.employee_number!=null)">
                                            {{ data.employment.employee.employee_number }} - 
                                        </span>
                                        {{ data.employment.employee.full_name }}
                                    </div>
                                </div>
                                <div class="relative inline-block text-left">

                                    <Dropdown width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#474747" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <div class="w-48">
                                                <div class="block px-4 py-2 text-xs text-gray-400">Employee options</div>
                                                <DropdownLink v-if="true" :href="route('equipment-responsives.edit', data.id )">Editar</DropdownLink>
                                                <DropdownLink v-if="true" :href="route('employees.create')">Duplicar</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="true" :href="route('equipment-responsives.create', {employee: data.id} )">Finalizar responsiva</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="true" as="button" @click="confirmUserDeletion" class="dropdown-danger">Eliminar</DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>

                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                        <template #title>Eliminar empleado</template>
                                        <template #content>
                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                Eliminar empleado
                                            </DangerButton>
                                        </template>
                                    </DialogModal>

                                </div>
                            </div>
                        </header>


                        <div class="text-gray-900 mb-4">
                            {{ data }}
                        </div>

                        
                        <h5 class="mt-4 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                            Equipo
                        </h5>
                        <div v-if="(data.equipment!=null)" class="text-gray-900 mb-4">
                            {{ data.equipment }}
                        </div>

                        <div v-else="(data.current_employment!=null)" class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    SIN EQUIPO
                                </p>
                            </div>
                        </div>


                        <h5 class="mt-4 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                            Responsable
                        </h5>
                        <div v-if="(data.equipment!=null)" class="text-gray-900 mb-4">
                            {{ data.employment }}
                        </div>

                        <div v-else="(data.current_employment!=null)" class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    SIN EQUIPO
                                </p>
                            </div>
                        </div>

                        
                        <div>
                            <!--a href="#" class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
                                <svg class="w-3 h-3 mr-2" aria-hidden="true" focusable="false" data-prefix="far" data-icon="question-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052-72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.659c0-35.745 27.1-50.034 47.579-61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246-21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.666 2.124l-27.824-21.098c-5.107-3.872-6.251-11.066-2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42-42 18.841-42 42-42 42 18.841 42 42z"></path></svg>
                                {{ data.phone }}, {{ data.address }}
                            </a-->
                            <span class="inline-flex items-center text-sm font-normal text-gray-500">
                                {{ data.phone }}, {{ data.address }}
                            </span>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </AppLayout>
</template>


<script>
import Multiselect from 'vue-multiselect'

export default {
    components: {
        Multiselect
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
            openMenu: false
        }
    },

    props: {
        base_url: String,
        data: Object,
        errors: Object,
        db: Object,
    },

}

</script>

