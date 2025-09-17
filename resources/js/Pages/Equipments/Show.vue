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
    form.delete( route('equipments.destroy', id ), {
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
                                        {{ data.category?.name }}
                                    </div>
                                    {{ data.brand?.name }} {{ data.model?.name }}
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
                                                <div class="block px-4 py-2 text-xs text-gray-400">Opciones de equipo</div>
                                                <DropdownLink v-if="$page.props.user.id!=9" :href="route('equipments.edit', data.id )">Editar</DropdownLink>
                                                <DropdownLink v-if="$page.props.user.id!=9" :href="route('equipments.create')">Duplicar</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="$page.props.user.id!=9" :href="route('responsives.create', {employee: data.id} )">Crear responsiva</DropdownLink>
                                                <DropdownLink v-if="false" :href="route('equipments.employments', data.id )">Cargos anteriores ({{ data.responsive_equipments?.length ?? 0 }})</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="$page.props.user.id!=9" as="button" @click="confirmUserDeletion" class="dropdown-danger">Eliminar</DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>

                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                        <template #title>Eliminar Equipo</template>
                                        <template #content>
                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                Eliminar Equipo
                                            </DangerButton>
                                        </template>
                                    </DialogModal>

                                </div>
                            </div>
                        </header>

                        <div class="">

                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white">
                                        {{ data.status }}
                                    </caption>
                                    <tbody>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Tipo de Equipo</th>
                                            <td class="py-3 px-4">{{ data.category?.name }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Marca</th>
                                            <td class="py-3 px-4">{{ data.brand?.name }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Modelo</th>
                                            <td class="py-3 px-4">{{ data.model?.name }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Placa</th>
                                            <td class="py-3 px-4">{{ data.sku }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">No. de Serie</th>
                                            <td class="py-3 px-4">{{ data.serial }}</td>
                                        </tr>

                                        <!--tr class="bg-white dark:bg-gray-800">
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Características</th>
                                            <td class="py-4 px-6">
                                                <p v-for="feature in data.features">
                                                    {{ feature.name }}: 
                                                    {{ feature.name }}
                                                </p>
                                            </td>
                                        </tr-->

                                        <tr class="bg-white border-b" v-for="feature in data.features">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-700 whitespace-nowrap">{{ db.features[feature.feature_id] }}</th>
                                            <td class="py-3 px-4">{{ feature.name }}</td>
                                        </tr>

                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Estado del equipo</th>
                                            <td class="py-3 px-4">{{ data.lifecycle }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Año de compra</th>
                                            <td class="py-3 px-4">{{ data.purchase_year }}</td>
                                        </tr>

                                        <tr class="bg-white border-b">
                                            <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Propietario</th>
                                            <td class="py-3 px-4">{{ data.owner?.name }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <p class="m-4 text-sm font-normal text-gray-500"><span class="font-bold text-gray-900">Notas: </span>{{ data.notes }}</p>

                        </div>

                        <h5 class="mt-6 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                            Responsable actual del equipo
                        </h5>
                        
                        <div v-if="(data.current_responsive)" class="text-gray-900 mb-4">
                            <div class="mb-8">
                                <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-2">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <!--caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white">
                                            Puesto laboral vigente
                                        </caption-->
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Empleado</th>
                                                <td class="py-3 px-4">{{ data.current_responsive?.employment?.employee?.full_name }}</td>
                                            </tr>

                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Planta</th>
                                                <td class="py-3 px-4">{{ data.current_responsive?.employment?.branch?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Área</th>
                                                <td class="py-3 px-4">{{ data.current_responsive?.employment?.area?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Puesto</th>
                                                <td class="py-3 px-4">{{ data.current_responsive?.employment?.title?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Desde</th>
                                                <td class="py-3 px-4">{{ new Date(data.current_responsive?.start_at).toLocaleDateString("es-MX") }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Hasta</th>
                                                <td class="py-3 px-4">{{ data.current_responsive?.end_at ?? 'ACTUAL' }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <a :href="route( 'equipment-responsives.show', data.current_responsive?.id )" class="font-sm text-gray-600 underline my-2">Ver responsiva</a>
                            </div>
                        </div>

                        <div v-else class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    El equipo no tiene una asignación vigente, haz
                                    <a :href="route('responsives.create', {equipment: data.id} )" class="hover:underline font-bold text-gray-700">
                                        clic aquí
                                    </a>
                                    para asignarlo a una empleado con puesto laboral
                                </p>
                            </div>
                        </div>
                        

                        <h5 class="mt-6 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                            Historico de responsivas
                        </h5>

                        <div v-if="(data.responsive_equipments.length)" class="text-gray-900 mb-4">
                            <div class="mb-8">
                                <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-2">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <tbody>
                                            <tr v-for="responsive_equipments in data.responsive_equipments" class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">
                                                    <a :href="route( 'responsives.show', responsive_equipments.responsive?.id )" class="font-sm text-gray-600 underline my-2">
                                                        {{ responsive_equipments }}
                                                    </a>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    El equipo no tiene responsivas anteriores
                                </p>
                            </div>
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
                { label: "Equipos", url: route('equipments') },
                { label: `${this.data.category?.name} ${this.data.brand?.name} ${this.data.model?.name}` },
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

