<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';


</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Empleados
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-4 lg:px-6">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">
                      
                        <header class="bg-white">
                            <div class="flex items-center justify-between">
                                <div class="mt-6 mb-6">
                                    <div class="mb-1 text-2xl">
                                        {{ data.full_name }}
                                    </div>
                                    <div class="text-gray-500">
                                        Cargos asignados
                                        <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ data.employments?.length ?? '0' }}</span>
                                    </div>
                                </div>
                                <div class="relative inline-block text-left">

                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                    Opciones
                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#474747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="5" r="1"></circle>
                                                        <circle cx="12" cy="19" r="1"></circle>
                                                    </svg>                                                        
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <div class="w-48">
                                                <div class="block px-4 py-2 text-xs text-gray-400">Employee options</div>
                                                <DropdownLink v-if="true" :href="route('employees.edit', data.id )">Editar</DropdownLink>
                                                <DropdownLink v-if="true" :href="route('employees.create')">Duplicar</DropdownLink>
                                                <div class="border-t border-gray-100" />
                                                <DropdownLink v-if="true" :href="route('employees.employments', data.id )">Cargos anteriores</DropdownLink>
                                                <div class="border-t border-gray-100" />
                                                <DropdownLink v-if="true" as="button" @click="confirmUserDeletion" class="dropdown-danger">Eliminar</DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>

                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                        <template #title>Eliminar Empleado</template>
                                        <template #content>
                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                Eliminar Empleado
                                            </DangerButton>
                                        </template>
                                    </DialogModal>

                                </div>
                            </div>
                        </header>

                        <div v-for="employment in data.employments" class="mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">

                                <div class="flex items-center justify-between">
                                    <div class="mb-1 text-base font-semibold text-gray-900">
                                        {{ employment.branch?.name }}
                                    </div>
                                    <div class="relative inline-block text-left">

                                        <Dropdown align="right" width="48">
                                            <template #trigger>
                                                <span class="inline-flex rounded-md">
                                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#474747" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                    </button>
                                                </span>
                                            </template>
                                            <template #content>
                                                <div class="w-48">
                                                    <DropdownLink v-if="true" :href="route('employees.edit', data.id )">Asignar equipo</DropdownLink>
                                                    <div class="border-t border-gray-100" />
                                                    <DropdownLink v-if="true" as="button" @click="confirmUserDeletion" class="dropdown-danger">Finalizar cargo</DropdownLink>
                                                </div>
                                            </template>
                                        </Dropdown>

                                        <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                            <template #title>Eliminar Empleado</template>
                                            <template #content>
                                                ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                            </template>
                                            <template #footer>
                                                <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                                <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                    Eliminar Empleado
                                                </DangerButton>
                                            </template>
                                        </DialogModal>

                                    </div>
                                </div>

                                <div class="text-gray-500">
                                  <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ employment.area?.name }}, {{ employment.title?.name }}</p>
                                  <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Desde: {{ employment.start_at }}, Hasta: {{ employment.end_at ?? 'ACTUAL' }}</p>
                                </div>
                              
                                <h5 class="mt-4 mb-1 text-base font-semibold text-gray-900 md:text-lg"> Equipos Asignados</h5>
                                <div v-for="equipment_responsive in employment.equipment_responsives" class="mb-4">
                                    <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                        <p class="">{{ equipment_responsive.start_at }}</p>
                                        <p class="">{{ equipment_responsive.end_at }}</p>

                                        <p class="">Tipo: {{ equipment_responsive.equipment.category.name }}</p>
                                        <p class="">Marca: {{ equipment_responsive.equipment.brand.name }}</p>
                                        <p class="">{{ equipment_responsive.equipment.owner.name }}</p>

                                        <p class="">{{ equipment_responsive.equipment.lifecycle }}</p>
                                        <p class="">{{ equipment_responsive.equipment.sku }}</p>
                                        <p class="">{{ equipment_responsive.equipment.model }}</p>

                                        <p class="">{{ equipment_responsive.equipment.serial }}</p>
                                        <p class="">{{ equipment_responsive.equipment.features }}</p>
                                        <p class="">{{ equipment_responsive.equipment.notes }}</p>

                                    </div>

                                </div>

                                <div>
                                    <a href="#" class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
                                        <svg class="w-3 h-3 mr-2" aria-hidden="true" focusable="false" data-prefix="far" data-icon="question-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052-72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.659c0-35.745 27.1-50.034 47.579-61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246-21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.666 2.124l-27.824-21.098c-5.107-3.872-6.251-11.066-2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42-42 18.841-42 42-42 42 18.841 42 42z"></path></svg>
                                        {{ employment.area?.name }}, {{ employment.title?.name }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="flex">
                          <a href="employments/create" class="hover:border-blue-500 hover:border-solid hover:bg-white hover:text-blue-500 group w-full flex flex-col items-center justify-center rounded-md border-2 border-dashed border-slate-300 text-sm leading-6 text-slate-900 font-medium py-3">
                            <svg class="group-hover:text-blue-400 mb-1 text-slate-400" width="20" height="20" fill="currentColor" aria-hidden="true">
                              <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                            </svg>
                            Nuevo empleo
                          </a>
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
    data: Object,
  },
  methods: {
    destroy(id) {
      this.$inertia.delete(route("employees.destroy", id));
    },
  },

}

</script>
