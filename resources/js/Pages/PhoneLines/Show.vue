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
    form.delete( route('phone-lines.destroy', id ), {
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
            <Breadcrumbs :data="breadcrumbs"/>
        </template>

        <div class="py-12">

            <div class="max-w-2xl mx-auto px-4">
                
                <div class="bg-white shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-8 bg-white border-b border-gray-200">

                        <header class="bg-white">
                            <div class="flex items-center justify-between">
                                <div class="my-4">
                                    <div class="mb-1 text-xl font-semibold tracking-tight text-gray-900">
                                        {{ data.number }}
                                    </div>
                                    {{ data.company }} - {{ data.modality?.name }}
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
                                                <div class="block px-4 py-2 text-xs text-gray-400">Phone line options</div>
                                                <DropdownLink v-if="$page.props.user.id!=9" :href="route('phone-lines.edit', data.id )">Editar</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="$page.props.user.id!=9" as="button" @click="confirmUserDeletion" class="dropdown-danger">Eliminar</DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>

                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                        <template #title>Eliminar Linea</template>
                                        <template #content>
                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                Eliminar Linea
                                            </DangerButton>
                                        </template>
                                    </DialogModal>

                                </div>
                            </div>
                        </header>


                        <div class="">

                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <!--caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white">
                                        {{ data.category?.name }}
                                    </caption-->
                                    <tbody>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Estatus de la linea</th>
                                            <td class="py-3 px-4">{{ data.status }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Número</th>
                                            <td class="py-3 px-4">{{ data.number }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Compañia</th>
                                            <td class="py-3 px-4">{{ data.company }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Plan</th>
                                            <td class="py-3 px-4">{{ data.modality?.name }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">ICCID</th>
                                            <td class="py-3 px-4">{{ data.iccid }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Tipo de linea</th>
                                            <td class="py-3 px-4">{{ data.scope }}</td>
                                        </tr>
                                        <tr class="bg-white">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Notas</th>
                                            <td class="py-3 px-4">{{ data.notes }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--p class="mt-1 text-sm font-normal text-gray-500">{{ data.notes }}</p-->
                            </div>

                        </div>

                        <h5 class="mt-4 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                            Asignacion de linea
                        </h5>

                        <div v-if="(data.current_equipment_responsive!=null)" class="text-gray-900 mb-4">

                        </div>

                        <div v-else class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    El equipo no tiene una asignación vigente, haz
                                    <a :href="route('equipment-responsives.create', {equipment: data.id} )" class="hover:underline font-bold text-gray-700">
                                        clic aquí
                                    </a>
                                    para asignarlo a una empleado con cargo laboral
                                </p>
                            </div>
                        </div>
                        
                        <div>
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
import Breadcrumbs from '@/Components/Go/Breadcrumbs.vue';

export default {
    components: {
        Breadcrumbs
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
            breadcrumbs: [
                { label: "Lineas", url: route('phone-lines') },
                { label: this.data.number },
            ]
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

