<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';

import { ref, onMounted } from 'vue';

DataTable.use(DataTablesLib);

const columns = [
  { data: 'id', title: 'ID' },
  { data: 'category_name', title: 'Categoría' },
  { data: 'sku', title: 'Placa' },
  { data: 'brand_name', title: 'Marca' },
  { data: 'model', title: 'Modelo' },
  { data: 'serial', title: 'No. Serie' },
  { data: 'features', title: 'Caracteristicas' },
  { data: 'status', title: 'Estatus' },
  { data: 'employee_name', title: 'Responsable' },
];

let dt;
const table = ref();

onMounted(function () {
  dt = table.value.dt();

  dt.rows().every(function () {
    let row = this.data();
    let id = row.id;

    let features = '';
    for( const property in row.features ){
      features += `<p class="px-2 py-1 border">${property}: ${row.features[property]}</p>`;
    }
    row.features = `<div class="px-2 py-1">${features}</div>`;
  });

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
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

            <header class="bg-white mb-4">
              <div class="flex items-center justify-between">
                <div class="mt-6 mb-6">
                  <div class="mb-1 text-2xl">
                    Lista de Equipos
                  </div>
                  <div class="text-gray-500">
                    Vista principal de equipos
                    <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ data.length ?? '' }}</span>
                  </div>
                </div>
                <a href="/equipments/create" class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
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
            />
          </div>
        </div>
      </div>
    </div>

  </AppLayout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Breadcrumbs from '@/Components/Go/Breadcrumbs.vue';

export default {
    components: {
      Breadcrumbs
  },
    data() {
        return {
            breadcrumbs: [
                { label: "Equipos", url: route('equipments') },
                { label: "Características", url: route('equipment-features') },
                { label: this.data.name, url: route('equipment-features.show',this.data.id) },
                { label: this.data.option.name },
            ]
        }
    },

    props: {
        data: Object,
        db: Object,
        errors: Object,
    },

    methods: {
    },

}
</script>
