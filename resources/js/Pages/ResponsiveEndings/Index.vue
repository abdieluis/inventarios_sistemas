<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Header from './Components/Header.vue';
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';
import 'datatables.net-dt';

import { ref, onMounted } from 'vue';

DataTable.use(DataTablesLib);

const columns = [
  { data: 'id', title: 'ID' },
  { data: 'name', title: 'Nombre' },
  { data: 'action', title: 'Acción' },
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
    row.action = `<a class="block text-gray-600 hover:text-gray-800 bg-indigo-200 hover:bg-indigo-300 focus:ring-1 focus:outline-none focus:ring-indigo-400 font-medium rounded-lg text-sm px-2 py-1.5 text-center" href="responsive-endings/${id}">VER</a>`;
  });

});

</script>

<style>
@import 'datatables.net-dt';
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
                    Motivos de Finalización de Responsivas
                  </div>
                  <div class="text-gray-500">
                    Vista principal de motivos de finalización de responsivas
                    <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ data.length ?? '' }}</span>
                  </div>
                </div>
                <a v-if="$page.props.user.id!=9" :href="route('responsive-endings.create')" class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
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
                select: false
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
