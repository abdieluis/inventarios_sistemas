<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Datos Externos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

                        <header class="bg-white mb-4">
                          <div class="flex items-center justify-between">
                            <div class="mt-6 mb-6">
                              <div class="mb-1 text-2xl">
                                  Datos Externos 
                              </div>
                              <div class="text-gray-500">
                                  Selecciona la lista de datos que deseas consultar
                              </div>
                            </div>
                          </div>
                        </header>

                        <div class="">
                          
                          <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">

                            <li v-for="item in data" class="py-3 sm:py-4">
                              <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                  <img class="w-8 h-8 rounded-sm" src="https://cdn-icons-png.flaticon.com/512/2224/2224395.png" alt="Neil image">
                                </div>
                                <div class="flex-1 min-w-0">
                                  <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ item.title }}
                                  </p>
                                  <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ item.description }}
                                  </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                  <a :href="item.url" class="hover:bg-orange-400 group flex items-center rounded-md bg-orange-500 text-white text-sm font-medium px-3 py-2 shadow-sm">
                                    ver
                                  </a>
                                </div>
                              </div>
                            </li>

                          </ul>
                        </div>

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
    data: Object,
  },
  methods: {
  },

}

</script>
