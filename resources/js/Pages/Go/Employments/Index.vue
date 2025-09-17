<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';

import { ref, onMounted } from 'vue';

DataTable.use(DataTablesLib);

const columns = [
  { data: 'id', title: 'ID' },
  { data: 'full_name', title: 'NOMBRE' },
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Empleados
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

                        <div class="mt-6 mb-6">
                            <div class="mb-1 text-2xl">
                                Lista de Empleados
                            </div>
                            <div class="text-gray-500">
                                Vista principal de empleados
                            </div>
                        </div>

                         <!-- Modal toggle -->
  <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="default-modal">
    Toggle modal
  </button>

  <!-- Main modal -->
  <div id="default-modal" aria-hidden="true" class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 h-modal md:h-full md:inset-0">
      <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                      Terms of Service
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="default-modal">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-6 space-y-6">
                  <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                      With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                  </p>
                  <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                      The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                  </p>
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <button data-modal-toggle="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                  <button data-modal-toggle="default-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">Decline</button>
              </div>
          </div>
      </div>
  </div>
                        
                        <DataTable
                          class="table display"
                          :columns="columns"
                          :data="posts"
                          :options="{
                            select: true
                          }"
                          ref="table"
                        >
                        <thead>
                            <tr>
                              <th>No Empleado</th>
                              <th>Nombre</th>
                            </tr>
                          </thead>
                        </DataTable>

                        <!--button class="btn" @click="add">Add new row</button><br />
                        <button class="btn" @click="update">Update selected rows</button><br />
                        <button class="btn" @click="remove">Delete selected rows</button-->
                        <!--DataTable
                          class="table display"
                          :columns="columns"
                          :data="dataFake"
                          :options="{
                            select: true
                          }"
                          ref="table"
                        >
                          <thead>
                            <tr>
                              <th>No Empleado</th>
                              <th>Nombre</th>
                            </tr>
                          </thead>
                        </DataTable-->

                        <header class="bg-white mb-4">
                          <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-slate-900">
                              Unidades en Taller
                              <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ posts.length ?? '' }}</span>
                            </h2>
                            <a href="/employees/create" class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
                              <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                                <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                              </svg>
                              Nuevo
                            </a>
                          </div>
                          <form class="group relative">
                            <svg width="20" height="20" fill="currentColor" class="absolute left-3 top-1/2 -mt-2.5 text-slate-400 pointer-events-none group-focus-within:text-blue-500" aria-hidden="true">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                            </svg>
                            <input class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 pl-10 ring-1 ring-slate-200 shadow-sm" type="text" aria-label="Filter projects" placeholder="Buscar unidad...">
                          </form>
                        </header>

                        <ul class="bg-white grid grid-cols-1 gap-4 text-sm leading-6 mb-4">
                          <li v-for="item in posts.data">
                            <div class="w-full">
                              <div class="border bg-slate-50 rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal <?php $item['prioridad'] == 1 ? 'border-red-400' : 'border-gray-400' ?>">
                                <div class="mb-8">
                                  <p class="text-sm text-gray-600 flex color-red">
                                    <i class="fa fa-info-circle mr-2"></i>Prioridad Alta
                                  </p>
                                  <div class="text-gray-900 font-bold text-xl mb-2">{{ item.full_name }}</div>
                                  <p class="text-gray-700 text-base">Lorem ipsum dolor sit amet.</p>
                                  <p class="text-gray-700 text-base">{{ item.full_name }}</p>
                                </div>
                                <div class="flex items-center">
                                  <img class="w-10 h-10 rounded-full mr-4" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="Avatar of Jonathan Reinink">
                                  <div class="text-sm">
                                    <p class="text-gray-900 leading-none">{{ item.full_name }}</p>
                                    <p class="text-gray-600">{{ item.full_name }}</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>

                          <li class="flex">
                            <a href="/employees/create" class="hover:border-blue-500 hover:border-solid hover:bg-white hover:text-blue-500 group w-full flex flex-col items-center justify-center rounded-md border-2 border-dashed border-slate-300 text-sm leading-6 text-slate-900 font-medium py-3">
                              <svg class="group-hover:text-blue-500 mb-1 text-slate-400" width="20" height="20" fill="currentColor" aria-hidden="true">
                                <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                              </svg>
                              Nuevo empleado
                            </a>
                          </li>
                        </ul>

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
      first_name: null,
      last_name: null,
      email: null,
    })

    function submit() {
      Inertia.post('/users', form)
    }

    return { form, submit }
  },


    components: {
    },
    props: {
        posts: Object,
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(route("employees.destroy", id));
        },
    },

}

</script>
