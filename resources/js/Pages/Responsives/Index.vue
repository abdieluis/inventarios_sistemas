<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import DataTable from 'datatables.net-vue3';
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';
import VueMultiselect from 'vue-multiselect';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

DataTable.use(DataTablesLib);

const props = defineProps({
    db: Object,
    data: Object,
    errors: Object,
    filters: Object,
});

// Helper function to find the full object from the ID
const findOptionById = (options, id) => {
    if (!options || !id) return null;
    return options.find(option => option.id === id) || null;
};

const formFilters = ref({
    id: props.filters?.id ?? '',
    status: findOptionById(props.db?.status, props.filters?.status),
    branch_id: findOptionById(props.db?.branches, props.filters?.branch_id),
    area_id: findOptionById(props.db?.areas, props.filters?.area_id),
    category_id: findOptionById(props.db?.categories, props.filters?.category_id),
    brand_id: findOptionById(props.db?.brands, props.filters?.brand_id),
    model_id: findOptionById(props.db?.models, props.filters?.model_id),
    sku: props.filters?.sku ?? '',
    serial: props.filters?.serial ?? ''
});

// Function to apply filters
const applyFilters = () => {
    const inertiaFilters = {
        id: formFilters.value.id,
        sku: formFilters.value.sku,
        serial: formFilters.value.serial,
        status: formFilters.value.status?.id ?? null,
        branch_id: formFilters.value.branch_id?.id ?? null,
        area_id: formFilters.value.area_id?.id ?? null,
        category_id: formFilters.value.category_id?.id ?? null,
        brand_id: formFilters.value.brand_id?.id ?? null,
        model_id: formFilters.value.model_id?.id ?? null,
    };

    Inertia.get(route('responsives.index'), inertiaFilters, {
        preserveState: true,
        preserveScroll: true,
    });
};

// Function to clear filters
const clearFilters = () => {
    formFilters.value = {
        id: '',
        status: null,
        branch_id: null,
        area_id: null,
        category_id: null,
        brand_id: null,
        model_id: null,
        sku: '',
        serial: ''
    };
    applyFilters();
};

const columns = [
    { data: 'id', title: 'ID' },
    {
        data: 'employment',
        title: 'Responsable',
        render: function (data) {
            return `<table width="100%" class="table-inner">
                        <tr><th colspan="2" class="py-0">${data?.employee?.full_name ?? ''}</th></tr>
                        <tr><td class="text-gray-600">Planta</td><td class="text-gray-900">${data?.branch?.name ?? ''}</td></tr>
                        <tr><td class="text-gray-600">Area</td><td class="text-gray-900">${data?.area?.name ?? ''}</td></tr>
                        <tr><td class="text-gray-600">Puesto</td><td class="text-gray-900">${data?.title?.name ?? ''}</td></tr>
                    </table>`;
        }
    },
    {
        data: 'equipments',
        title: 'Equipos',
        render: function (data) {
            let equipmentsHtml = '';
            for (const equipment of data) {
                equipmentsHtml +=
                    `<table width="100%" class="table-inner">
                        <tr><th colspan="2">${equipment.data?.category.name ?? ''}</th></tr>
                        <tr><td class="text-gray-600">Placa</td><td class="text-gray-900">${equipment.data?.sku ?? ''}</td></tr>
                        <tr><td class="text-gray-600">Marca</td><td class="text-gray-900">${equipment.data?.brand?.name ?? ''}</td></tr>
                        <tr><td class="text-gray-600">Modelo</td><td class="text-gray-900">${equipment.data?.model?.name ?? ''}</td></tr>
                    </table>`;
            }
            return equipmentsHtml;
        }
    },
    {
        data: 'created_by',
        title: 'Linea',
        render: function (data, type, row) {
            let phonelines = '';
            for (const equipment of row.equipments) {
                phonelines += equipment.phoneline_id == null ? '' :
                    `<table width="100%" class="table-inner">
                        <tr><th colspan="2">${equipment.phoneline?.number ?? ''}</th></tr>
                        <tr><td class="text-gray-600">Compañia</td><td class="text-gray-900">${equipment.phoneline?.company ?? ''}</td></tr>
                        <tr><td class="text-gray-600">Plan</td><td class="text-gray-900">${equipment.phoneline?.modality.name ?? ''}</td></tr>
                        <tr><td class="text-gray-600">Modalidad</td><td class="text-gray-900">${equipment.phoneline?.scope ?? ''}</td></tr>
                    </table>`;
            }
            return phonelines;
        }
    },
    { data: 'start_at', title: 'F. Entrega' },
    { data: 'end_at', title: 'F. Recepción' },
    {
        data: 'action',
        title: 'Acción',
        render: function (data, type, row) {
            return `<a class="block text-gray-600 hover:text-gray-800 bg-indigo-200 hover:bg-indigo-300 focus:ring-1 focus:outline-none focus:ring-indigo-400 font-medium rounded-lg text-sm px-2 py-1.5 text-center" href="responsives/${row.id}">VER</a>`;
        }
    },
];
</script>

<style>
/* Corrige la importación de estilos de DataTables */
@import 'datatables.net-dt/css/jquery.dataTables.min.css';

/* Estilos personalizados para la tabla y el diseño */
.table-inner {
    border: none;
}

.table-inner tr th,
.table-inner tr td {
    border: none;
    padding: 2px 0;
}

table.dataTable {
    border-collapse: collapse;
}

table.dataTable th,
table.dataTable td {
    border: 1px solid #e2e8f0;
    padding: 8px;
}
</style>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <Header />
        </template>
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg grid grid-cols-1 md:grid-cols-4">
                    <div class="p-4 border-r border-gray-200 col-span-1">
                        <h2 class="text-xl font-semibold mb-4">FILTRAR</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="id" class="block text-sm font-medium text-gray-700">ID Responsiva</label>
                                <input type="text" v-model="formFilters.id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Estatus
                                    Responsiva</label>
                                <VueMultiselect v-model="formFilters.status" :options="db.status"
                                    placeholder="Selecciona una opción" label="name" track-by="id" :show-labels="false">
                                </VueMultiselect>
                            </div>
                            <div>
                                <label for="branch_id" class="block text-sm font-medium text-gray-700">Planta</label>
                                <VueMultiselect v-model="formFilters.branch_id" :options="db.branches"
                                    placeholder="Selecciona una opción" label="name" track-by="id" :show-labels="false">
                                </VueMultiselect>
                            </div>
                            <div>
                                <label for="area_id" class="block text-sm font-medium text-gray-700">Área</label>
                                <VueMultiselect v-model="formFilters.area_id" :options="db.areas"
                                    placeholder="Selecciona una opción" label="name" track-by="id" :show-labels="false">
                                </VueMultiselect>
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Equipo
                                    Categoría</label>
                                <VueMultiselect v-model="formFilters.category_id" :options="db.categories"
                                    placeholder="Selecciona una opción" label="name" track-by="id" :show-labels="false">
                                </VueMultiselect>
                            </div>
                            <div>
                                <label for="brand_id" class="block text-sm font-medium text-gray-700">Equipo
                                    Marca</label>
                                <VueMultiselect v-model="formFilters.brand_id" :options="db.brands"
                                    placeholder="Selecciona una opción" label="name" track-by="id" :show-labels="false">
                                </VueMultiselect>
                            </div>
                            <div>
                                <label for="model_id" class="block text-sm font-medium text-gray-700">Equipo
                                    Modelo</label>
                                <VueMultiselect v-model="formFilters.model_id" :options="db.models"
                                    placeholder="Selecciona una opción" label="name" track-by="id" :show-labels="false">
                                </VueMultiselect>
                            </div>
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700">Equipo Placa</label>
                                <input type="text" v-model="formFilters.sku"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="serial" class="block text-sm font-medium text-gray-700">Equipo Serie</label>
                                <input type="text" v-model="formFilters.serial"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-2">
                            <SecondaryButton @click="clearFilters">Limpiar</SecondaryButton>
                            <PrimaryButton @click="applyFilters">Filtrar</PrimaryButton>
                        </div>
                    </div>

                    <div class="flex-grow p-6 sm:px-12 bg-white border-b border-gray-200 col-span-3">
                        <header class="bg-white mb-4">
                            <div class="flex items-center justify-between">
                                <div class="mt-6 mb-6">
                                    <div class="mb-1 text-2xl">
                                        Lista de Responsivas
                                    </div>
                                    <div class="text-gray-500">
                                        Vista principal de responsivas
                                        <span
                                            class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{
                                                props.data.length ?? '' }}</span>
                                    </div>
                                </div>
                                <div class="inline-flex items-center space-x-2">
                                    <PrimaryButton @click="applyFilters">Filtrar</PrimaryButton>
                                    <a v-if="$page.props.user.id != 9" :href="route('responsives.create')"
                                        class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm ml-2">
                                        <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                                            <path
                                                d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                                        </svg>
                                        Nuevo
                                    </a>
                                </div>
                            </div>
                        </header>
                        <DataTable class="table display" :columns="columns" :data="props.data"
                            :options="{ select: false }" ref="table" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
