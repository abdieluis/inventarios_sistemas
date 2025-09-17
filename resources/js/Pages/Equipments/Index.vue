<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import DialogModal from '@/Components/DialogModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DataTable from 'datatables.net-vue3';
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';
import VueMultiselect from 'vue-multiselect';

DataTable.use(DataTablesLib);

const props = defineProps({
    data: Object,
    db: Object,
    errors: Object,
});

const table = ref();
const showFilters = ref(false);
const filters = ref({
    id: '',
    sku: '',
    serial: '',
    category: null,
    brand: null,
    model: null,
    status: null,
});

const columns = [
    { data: 'id', title: 'ID' },
    { data: 'category.name', title: 'Categoría', defaultContent: '' },
    { data: 'sku', title: 'Placa', defaultContent: '' },
    { data: 'brand.name', title: 'Marca', defaultContent: '' },
    { data: 'model.name', title: 'Modelo', defaultContent: '' },
    { data: 'serial', title: 'No. Serie', defaultContent: '' },
    {
        data: 'features',
        title: 'Características',
        render: function (data, type, row) {
            if (type === 'display' && data) {
                let featuresHtml = '';
                for (const property in data) {
                    featuresHtml += `<p class="px-2 py-1 border">${data[property].name}</p>`;
                }
                return `<div class="px-2 py-1">${featuresHtml}</div>`;
            }
            return '';
        },
    },
    { data: 'status', title: 'Estatus', defaultContent: '' },
    {
        data: 'action',
        title: 'Acción',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
            return `<a class="block text-gray-600 hover:text-gray-800 bg-indigo-200 hover:bg-indigo-300 focus:ring-1 focus:outline-none focus:ring-indigo-400 font-medium rounded-lg text-sm px-2 py-1.5 text-center" href="equipments/${row.id}">VER</a>`;
        },
    },
];

const openFilters = () => {
    showFilters.value = true;
};

const closeFilters = () => {
    showFilters.value = false;
};


// const finailzeResponsive = (id) => {
//   // Lógica para filtrar la tabla
//   console.log('Filtrando con:', filters.value);
// };
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <Header />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">
                        <header class="bg-white mb-4">
                            <div class="flex items-center justify-between">
                                <div class="mt-6 mb-6">
                                    <div class="mb-1 text-2xl">Lista de Equipos</div>
                                    <div class="text-gray-500">
                                        Vista principal de equipos
                                        <span
                                            class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{
                                            props.data.length ?? '' }}</span>
                                    </div>
                                </div>
                                <div class="inline-flex">
                                    <button
                                        class="hover:bg-teal-400 group flex items-center rounded-md bg-teal-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm"
                                        @click="openFilters">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="butt" stroke-linejoin="bevel" class="mr-2">
                                            <line x1="4" y1="21" x2="4" y2="14"></line>
                                            <line x1="4" y1="10" x2="4" y2="3"></line>
                                            <line x1="12" y1="21" x2="12" y2="12"></line>
                                            <line x1="12" y1="8" x2="12" y2="3"></line>
                                            <line x1="20" y1="21" x2="20" y2="16"></line>
                                            <line x1="20" y1="12" x2="20" y2="3"></line>
                                            <line x1="1" y1="14" x2="7" y2="14"></line>
                                            <line x1="9" y1="8" x2="15" y2="8"></line>
                                            <line x1="17" y1="16" x2="23" y2="16"></line>
                                        </svg>
                                        Filtrar
                                    </button>
                                    <a v-if="$page.props.user.id != 9" href="/equipments/create"
                                        class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="butt" stroke-linejoin="bevel" class="mr-2">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Nuevo
                                    </a>
                                </div>
                            </div>
                        </header>

                        <DataTable class="table display" :columns="columns" :data="props.data"
                            :options="{ select: false }" ref="table" />

                        <DialogModal :show="showFilters" max-width="xl" @close="closeFilters">
                            <template #title>Filtrar Equipos</template>
                            <template #content>
                                <div class="grid grid-cols-12 gap-4 mt-4">
                                    <div class="col-span-3 ...">
                                        <label for="end_at" class="block">ID</label>
                                        <input type="text" v-model="filters.id"
                                            class="block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded" />
                                    </div>
                                    <div class="col-span-3 ...">
                                        <label for="end_at" class="block">Placa</label>
                                        <input type="text" v-model="filters.sku"
                                            class="block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded" />
                                    </div>
                                    <div class="col-span-6 ...">
                                        <label for="end_at" class="block">Serie</label>
                                        <input type="text" v-model="filters.serial"
                                            class="block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded" />
                                    </div>
                                    <div class="col-span-6 ...">
                                        <label for="end_at" class="block">Categoría</label>
                                        <VueMultiselect v-model="filters.category" :options="props.db.categories"
                                            placeholder="Selecciona una opción" label="name" track-by="id"
                                            :show-labels="false"></VueMultiselect>
                                    </div>
                                    <div class="col-span-6 ...">
                                        <label for="end_at" class="block">Marca</label>
                                        <VueMultiselect v-model="filters.brand" :options="props.db.brands"
                                            placeholder="Selecciona una opción" label="name" track-by="id"
                                            :show-labels="false"></VueMultiselect>
                                    </div>
                                    <div class="col-span-6 ...">
                                        <label for="end_at" class="block">Modelo</label>
                                        <VueMultiselect v-model="filters.model" :options="props.db.models"
                                            placeholder="Selecciona una opción" label="name" track-by="id"
                                            :show-labels="false"></VueMultiselect>
                                    </div>
                                    <div class="col-span-6 ...">
                                        <label for="end_at" class="block">Estatus</label>
                                        <VueMultiselect v-model="filters.status" :options="props.db.status"
                                            placeholder="Selecciona una opción" :show-labels="false"></VueMultiselect>
                                    </div>
                                </div>
                            </template>

                            <template #footer>
                                <SecondaryButton @click="closeFilters">Cancelar</SecondaryButton>
                                <PrimaryButton class="ml-3" :class="{ 'opacity-25': filters.processing }"
                                    :disabled="filters.processing" @click="finailzeResponsive(data.id)">
                                    Filtrar
                                </PrimaryButton>
                            </template>
                        </DialogModal>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
@import 'datatables.net-dt';
</style>
