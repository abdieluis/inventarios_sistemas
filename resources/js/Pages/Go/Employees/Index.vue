<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Header from './Components/Header.vue';

// Importaciones
import DataTable from 'datatables.net-vue3';
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';
// Asegúrate de importar el CSS correctamente
import 'datatables.net-dt/css/jquery.dataTables.min.css';

// 1. Usa defineProps para recibir los datos
const props = defineProps({
    data: Object,
    employmentTitles: Array,
});

console.log(props);

DataTable.use(DataTablesLib);

const columns = [
    { data: 'employee_number', title: 'No. Empleado', defaultContent: '' },
    { data: 'full_name', title: 'Nombre' },
    { data: 'current_employment.branch.name', title: 'Planta', defaultContent: '' },
    { data: 'current_employment.area.name', title: 'Área', defaultContent: '' },
    { data: 'current_employment.title.name', title: 'Puesto', defaultContent: '' },
    {
        data: 'id',
        title: 'ACCIÓN',
        render: function (data) {
            // Corrige la URL para que apunte a la ruta correcta con el prefijo "go"
            return `<a class="block text-gray-600 hover:text-gray-800 bg-indigo-200 hover:bg-indigo-300 focus:ring-1 focus:outline-none focus:ring-indigo-400 font-medium rounded-lg text-sm px-2 py-1.5 text-center" href="/go/employees/${data}">VER</a>`;
        }
    },
];

// No necesitas onMounted para esto
// Ya que :data="props.data" y el render se encargan de llenar la tabla.

</script>

<style>
@import 'datatables.net-dt/css/jquery.dataTables.min.css';
</style>

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
                                    <div class="mb-1 text-2xl">
                                        Lista de Empleados
                                    </div>
                                    <div class="text-gray-500">
                                        Vista principal de Empleados
                                        <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ props.data.length ?? '' }}</span>
                                    </div>
                                </div>
                                <a v-if="$page.props.user.id != 9" :href="route('employees.create')"
                                    class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
                                    <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                                        <path
                                            d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                                    </svg>
                                    Nuevo
                                </a>
                            </div>
                        </header>
                        <DataTable class="table display" :columns="columns" :data="props.data" :options="{ select: false }" ref="table" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
