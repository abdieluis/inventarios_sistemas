<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';

DataTable.use(DataTablesLib);

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
    form.delete( route('equipment-features.destroy', id ), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        // onError: () => passwordInput.value.focus(),
        // onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
};

const columns = [
    { data: 'id', title: 'ID' },
    { data: 'name', title: 'Nombre' },
    { data: 'action', title: 'Acción' },
];

let dt;
const table = ref();

onMounted(function () {
    try {
        dt = table.value.dt();
        dt.rows().every(function () {
            let row = this.data();
            let id = row.id;
            let feature = row.feature_id;
            row.action = `<a class="block text-gray-600 hover:text-gray-800 bg-indigo-200 hover:bg-indigo-300 focus:ring-1 focus:outline-none focus:ring-indigo-400 font-medium rounded-lg text-sm px-2 py-1.5 text-center" href="${feature}/options/${id}">VER</a>`;
        });
    } catch(e){}
});

</script>

<style>
@import 'datatables.net-dt';
</style>

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
                                    <div class="mb-1 text-2xl font-semibold tracking-tight text-gray-900">
                                        {{ data?.name }}
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
                                                <div class="block px-4 py-2 text-xs text-gray-400">feature options</div>
                                                <DropdownLink v-if="true" :href="route('equipment-features.edit', data.id )">Editar</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="true" as="button" @click="confirmUserDeletion" class="dropdown-danger">Eliminar</DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>

                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                        <template #title>Eliminar Característica</template>
                                        <template #content>
                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                Eliminar Característica
                                            </DangerButton>
                                        </template>
                                    </DialogModal>

                                </div>
                            </div>
                        </header>

                        <div class="">
                            <div class="mb-1 text-xl text-gray-600">
                                Tipo de Característica
                            </div>
                            <p class="mb-6">
                                {{ data.type }}
                            </p>
                            <div class="mb-1 text-xl text-gray-600">
                                Categorías a las se aplica
                            </div>
                            <div v-if="data.categories?.length" class="mb-4">
                                <ul v-for="item in data.categories">
                                    <li>{{  item.name  }}</li>
                                </ul>
                            </div>
                            <div v-else class="mb-6">
                                No hay categorías seleccionadas
                            </div>

                            <div v-if="data.type == 'Lista desplegable'" >

                                <div class="flex items-center justify-between">
                                    <div class="mb-6 mt-2">
                                        <div class="mb-1 text-xl text-gray-600">
                                            Lista de opciones
                                        </div>
                                    </div>
                                    <a :href="route('equipment-features.options.create', data.id)" class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
                                        <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                                            <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                                        </svg>
                                        Agregar
                                    </a>
                                </div>

                                <DataTable
                                    class="table display"
                                    :columns="columns"
                                    :data="data.options"
                                    :options="{
                                        select: false
                                    }"
                                    ref="table"
                                />
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script>
import Breadcrumbs from '../../Components/Go/Breadcrumbs.vue';

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
                { label: "Caracaterísticas", url: route('equipment-features') },
                { label: this.data.name }
            ]
        }
    },

    props: {
        data: Object,
        errors: Object,
        db: Object,
    },

}

</script>

