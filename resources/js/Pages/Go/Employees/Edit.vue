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
            <div class="max-w-2xl mx-auto sm:px-4 lg:px-6">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

                        <div class="mt-6 mb-6">
                            <div class="mb-1 text-2xl">{{ data.full_name }}</div>
                            <div class="text-gray-500">Actualiza los datos del Empleado</div>
                        </div>

                        <form @submit.prevent="update" autocomplete="off">

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="first_name"
                                            class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Nombre(s)</label>
                                        <input type="text" v-model="form.first_name" id="first_name"
                                            class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4"
                                            required>
                                        <div v-if="errors.first_name" class="text-error">{{ errors.first_name }}</div>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="last_name"
                                            class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Apellido(s)</label>
                                        <input type="text" v-model="form.last_name" id="last_name"
                                            class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4"
                                            required>
                                        <div v-if="errors.last_name" class="text-error">{{ errors.last_name }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="employee_number"
                                            class="block tracking-wide text-sm font-medium text-gray-900 mb-1">No.
                                            Empleado</label>
                                        <input type="text" v-model="form.employee_number" id="employee_number"
                                            class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4"
                                            required>
                                        <div v-if="errors.employee_number" class="text-error">{{ errors.employee_number
                                            }}</div>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="phone"
                                            class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Teléfono</label>
                                        <input type="text" v-model="form.phone" id="phone"
                                            class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4"
                                            required>
                                        <div v-if="errors.phone" class="text-error">{{ errors.phone }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="employee_number"
                                            class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Planta</label>
                                        <input type="text" v-model="form.employee_number" id="employee_plant"
                                            class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4"
                                            required>
                                        <div v-if="errors.employee_number" class="text-error">{{ errors.employee_number
                                            }}</div>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="phone"
                                            class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Puesto</label>
                                        <input type="text" v-model="form.phone" id="employee_position"
                                            class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4"
                                            required>
                                        <div v-if="errors.phone" class="text-error">{{ errors.phone }}</div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="mb-6">
                                <label for="address"
                                    class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Dirección</label>
                                <textarea v-model="form.address" id="address"
                                    class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4"
                                    required></textarea>
                                <div v-if="errors.address" class="text-error">{{ errors.address }}</div>
                            </div>

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="employee_number"
                                            class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Identificación</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label for="id-file"
                                                class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                <div v-show="(form.file_id == null)"
                                                    class="flex flex-col items-center justify-center text-center pt-5 pb-6">
                                                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                        </path>
                                                    </svg>
                                                    <p class="my-2 text-sm text-gray-500 font-semibold">Haz clic para
                                                        seleccionar</p>
                                                    <p class="text-xs text-gray-500">Imagen o Pdf (MAX. 2MB)</p>
                                                </div>
                                                <div v-show="(form.file_id != null)"
                                                    class="flex flex-col items-center justify-center text-center pt-5 pb-6">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                        viewBox="0 0 24 24" fill="none" stroke="#d97706"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M13 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V9l-7-7z" />
                                                        <path d="M13 3v6h6" />
                                                    </svg>
                                                    <p class="my-2 text-sm text-amber-600 font-semibold">{{
                                                        form.file_id?.name
                                                        }}</p>
                                                    <p class="text-xs text-amber-600">{{ form.file_id?.type }}</p>
                                                </div>
                                                <input id="id-file" type="file" class="hidden"
                                                    @input="form.file_id = $event.target.files[0]"
                                                    accept="image/png, image/gif, image/jpeg, application/pdf" />
                                            </label>
                                        </div>
                                        <div v-if="errors.file_id" class="text-error">{{ errors.file_id }}</div>
                                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                            {{ form.progress.percentage }}%
                                        </progress>
                                    </div>

                                    <div class="md:w-1/2 px-3">
                                        <label for="employee_number"
                                            class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Comprobante
                                            de
                                            domicilio</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label for="address-file"
                                                class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                <div v-show="(form.file_address == null)"
                                                    class="flex flex-col items-center justify-center text-center pt-5 pb-6">
                                                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                        </path>
                                                    </svg>
                                                    <p class="my-2 text-sm text-gray-500 font-semibold">Haz clic para
                                                        seleccionar</p>
                                                    <p class="text-xs text-gray-500">Imagen o Pdf (MAX. 2MB)</p>
                                                </div>
                                                <div v-show="(form.file_address != null)"
                                                    class="flex flex-col items-center justify-center text-center pt-5 pb-6">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                        viewBox="0 0 24 24" fill="none" stroke="#d97706"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M13 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V9l-7-7z" />
                                                        <path d="M13 3v6h6" />
                                                    </svg>
                                                    <p class="my-2 text-sm text-amber-600 font-semibold">{{
                                                        form.file_address?.name }}</p>
                                                    <p class="text-xs text-amber-600">{{ form.file_address?.type }}</p>
                                                </div>
                                                <input id="address-file" type="file" class="hidden"
                                                    @input="form.file_address = $event.target.files[0]"
                                                    accept="image/png, image/gif, image/jpeg, application/pdf" />
                                            </label>
                                        </div>
                                        <div v-if="errors.file_address" class="text-error">{{ errors.file_address }}
                                        </div>
                                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                            {{ form.progress.percentage }}%
                                        </progress>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6 mt-4 text-right">
                                <a :href="route('employees.show', data.id)"
                                    class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</a>
                                <button type="submit"
                                    class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    components: {
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
            form: useForm(this.data),
        }
    },

    props: {
        data: Object,
        errors: Object,
        db: Object,
    },
    mounted() {
        console.log('Props completas:', this.$props);
        console.log('Prop "data":', this.data);
        console.log('Prop "errors":', this.errors);
        console.log('Prop "db":', this.db);
    },

    methods: {
        update() {
            this.form.put(route('employees.update', this.data.id))
        },
    },

}


</script>
