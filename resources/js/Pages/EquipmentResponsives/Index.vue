<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';

import { ref, onMounted } from 'vue';

DataTable.use(DataTablesLib);

const columns = [
  { data: 'id', title: 'ID' },
  { data: 'employee_name', title: 'Responsable' },
  { data: 'equipment_category_name', title: 'Equipo' },
  { data: 'start_at', title: 'F. Entrega' },
  { data: 'end_at', title: 'F. Recepción' },
];

let dt;
const dataFake = ref([]);
const table = ref();

// Get a DataTables API reference
onMounted(function () {
  dt = table.value.dt();

  dt.rows().every(function () {

    let row = this.data();
    let id = row.id;


    console.log( row.accessories );

    row.employee_name = `<table width="100%" class="table-inner">
      <tr>
        <th colspan="2" class="py-0">${row.employee_name}</th>
      </tr>  
      <tr>
        <td class="py-0">Planta</td>
        <td class="py-0">${row.employment_branch_name}</td>
      </tr>
      <tr>
        <td class="py-0" style="padding">Area</td>
        <td class="py-0">${row.employment_area_name}</td>
      </tr>
      <tr>
        <td class="py-0">Puesto</td>
        <td class="py-0">${row.employment_title_name}</td>
      </tr>
    </table>`;

    row.equipment_category_name = `<table width="100%" class="table-inner">
      <tr><th colspan="2">${row.equipment_category_name}</th></tr>  
      <tr>
        <td>Marca</td>
        <td>${row.equipment_brand_name}</td>
      </tr>
      <tr>
        <td>Modelo</td>
        <td>${row.equipment_model_name}</td>
      </tr>  
      <tr>
        <td>Accesorios</td>
        <td>${ row.accessories }</td>
      </tr>  
    </table>`;    

    let accessories = '';
    for( const property in row.accessories ){
      accessories += `<p class="px-2 py-1 border">${row.accessories[property]}</p>`;
    }
    row.accessories = `<div class="px-2 py-1">${accessories}</div>`;


  });

});


</script>

<style>
@import 'datatables.net-dt';
</style>

<template>
  <AppLayout title="Dashboard">

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Equipos</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

            <header class="bg-white mb-4">
              <div class="flex items-center justify-between">
                <div class="mt-6 mb-6">
                  <div class="mb-1 text-2xl">
                    Lista de Responsivas
                  </div>
                  <div class="text-gray-500">
                    Vista principal de responsivas
                    <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ data.length ?? '' }}</span>
                  </div>
                </div>
                <a href="/equipment-responsives/create" class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
                  <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                    <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                  </svg>
                  Nuevo
                </a>
              </div>
            </header>

            <DataTable
              class="table display"
              :columns="columns"
              :data="data"
              :options="{
              select: true
              }"
              ref="table"
            >
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Responsable</th>
                  <th>Equipo</th>
                  <th>Fecha inicio</th>
                  <th>Fecha finalización</th>
                </tr>
              </thead>
            </DataTable>
          </div>
        </div>
      </div>
    </div>

  </AppLayout>
</template>

<script>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
 
export default {
  setup () {
    const form = reactive({
    });

    function submit() {
      Inertia.post('/users', form)
    }

    return { form, submit }
  },

  components: {
  },
  props: {
    db: Object,
    data: Object,
    errors: Object,
  },
  methods: {
  },

}
</script>
