<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Header from './Components/Header.vue';

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
                  <div class="mb-1 text-2xl">
                    Lista de Reportes
                  </div>
                  <div class="text-gray-500">
                    Vista principal de reportes
                    <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800"></span>
                  </div>
                </div>
                <div class=" inline-flex">
                </div>
              </div>
            </header>

            <table class="w-full text-sm text-left text-gray-500">
              <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-stone-100">
                Reportes
              </caption>
              <tbody>
                  <tr class="bg-white border-b">
                      <td scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Usuarios</td>
                      <td class="py-3 px-4">
                        <div class="text-blue-600 text-sm text-rigth text-right">
                          <a :href="route( 'reports.users' )">DESCARGAR</a>
                        </div>
                      </td>
                  </tr>
                  <tr class="bg-white border-b">
                      <td scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Empleados</td>
                      <td class="py-3 px-4">
                        <div class="text-blue-600 text-sm text-rigth text-right">
                          <a :href="route( 'reports.employees' )">DESCARGAR</a>
                        </div>
                      </td>
                  </tr>
                  <tr class="bg-white border-b">
                      <td scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Equipos</td>
                      <td class="py-3 px-4">
                        <div class="text-blue-600 text-sm text-rigth text-right">
                          <a :href="route( 'reports.equipments' )">DESCARGAR</a>
                        </div>
                      </td>
                  </tr>
                  <tr class="bg-white border-b">
                      <td scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Lineas Teléfonicas</td>
                      <td class="py-3 px-4">
                        <div class="text-blue-600 text-sm text-rigth text-right">
                          <a :href="route( 'reports.phonelines' )">DESCARGAR</a>
                        </div>
                      </td>
                  </tr>
                  <tr class="bg-white border-b">
                      <td scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Responsivas</td>
                      <td class="py-3 px-4">
                        <div class="text-blue-600 text-sm text-rigth text-right">
                          <a :href="route( 'reports.responsives' )">DESCARGAR</a>
                        </div>
                      </td>
                  </tr>
              </tbody>
          </table>


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
