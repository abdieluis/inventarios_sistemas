<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';

import { ref, onMounted } from 'vue';

DataTable.use(DataTablesLib);

const columns = [
  { data: 'id', title: 'ID' },
  { data: 'name', title: 'NOMBRE' },
  { data: 'email', title: 'CORREO' },
];

let counter = 0;
let dt;
const dataFake = ref([]);
const table = ref();

// Initial data
for (let i = 0; i < 5; i++) {
  add();
}

// Get a DataTables API reference
onMounted(function () {
  dt = table.value.dt();
});

// Add new rows - note how the data object in Vue is changed and the DataTable will reflect
// those changes, rather than using the DataTables API to manipulate the rows.
function add() {
  dataFake.value.push({
    id: 'ID-' + counter,
    full_name: 'NAME-' + counter,
  });

  counter += 1;
}

// For each selected row just add an indicator to show that it's data has been updated
function update() {
  dt.rows({ selected: true }).every(function () {
    let row = this.data();
    row.id += ' Updated';
    row.full_name += ' Updated';
  });
}

// For each selected row find the data object in `data` array and remove it
function remove() {
  dt.rows({ selected: true }).every(function () {
    let idx = dataFake.value.indexOf(this.data());
    dataFake.value.splice(idx, 1);
  });
}

</script>

<style>
@import 'datatables.net-dt';
</style>

<template>
  <AppLayout title="Dashboard">

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

            <header class="bg-white mb-4">
              <div class="flex items-center justify-between">
                <div class="mt-6 mb-6">
                <div class="mb-1 text-2xl">
                  Lista de Usuarios
                </div>
                <div class="text-gray-500">
                  Vista principal de usuarios
                  <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ data.length ?? '' }}</span>
                </div>
                </div>
                <a href="/users/create" class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
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
                  <th>NOMBRE</th>
                  <th>CORREO</th>
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
      name: null,
      email: null,
      password: null,
    });
    function submit() {
      Inertia.post('/users', form)
    }
    return { form, submit }
  },

  components: {
  },
  props: {
    data: Object,
  },
  methods: {
    destroy(id) {
      this.$inertia.delete(route("employees.destroy", id));
    },
  },

}

</script>
