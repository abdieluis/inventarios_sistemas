<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

/*
export default {

    setup () {
        const forms = reactive({
            first_name: null,
            last_name: null,
            email: null,
        })

        const form2 = useForm({
            first_name: null,
            last_name: null,
            email: null,
        });

        function submit() {
            Inertia.post('/users', form)
        }

        return { form, submit }

    },

    methods: {
        submit() {
            this.form.post(route("posts.store"));
        },
    },

}
*/

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Periodos de Trabajo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

                        <div class="mt-6 mb-6">
                            <div class="mb-1 text-2xl">
                                Nuevo Periodo
                            </div>
                            <div class="text-gray-500">
                                Completa los siguientes datos del periodo
                            </div>
                        </div>

                        <form @submit.prevent="store" autocomplete="off">

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="employee_number" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">No. Empleado</label>
                                        <input type="text" v-model="form.employee_number" id="employee_number" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4" required>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="first_name" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Nombre</label>
                                        <input type="text" v-model="form.full_name" id="first_name" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="countries" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Planta</label>
                                <select v-model="form.employment.branch" id="countries" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4" required>
                                    <option selected value="">Elige la planta</option>
                                    <option v-for="item in db.branches" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="countries" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Área</label>
                                <select v-model="form.employment.area" id="countries" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4" required>
                                    <option selected value="">Elige el área</option>
                                    <option v-for="item in db.employmentAreas" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="countries" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Puesto</label>
                                <select v-model="form.employment.title" id="countries" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4">
                                    <option selected value="">Elige el puesto</option>
                                    <option v-for="item in db.employmentTitles" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="employee_number" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Fecha Inicial</label>
                                        <input type="date" v-model="form.employee_number" id="employee_number" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4" required>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="phone" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Fecha Final</label>
                                        <input type="date" v-model="form.phone" id="phone" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4">
                                    </div>
                                </div>
                            </div>

                            
                            <div class="mb-6 mt-4 text-right">
                                <button type="button" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</button>
                                <button type="submit" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
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
            form: useForm({
                first_name: '',
                last_name: '',
                phone: '',
                address: '',
                employment: {
                    branch: '',
                    area: '',
                    title: '',
                }
            }),
        }
    },

    props: {
        db: Object,
    },

    methods: {
        store() {
            this.form.post('/go/employees')
        },
    },

}


/*

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
*/


</script>

