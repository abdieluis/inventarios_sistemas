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

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Periodos de Trabajo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto px-6">
                
                <div class="bg-white shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

                        <div class="mt-6 mb-6">
                            <div class="mb-1 text-xl">
                                <span v-if="(data.employee_number!=null)">
                                    {{ data.employee_number }} - 
                                </span>
                                {{ data.full_name }}
                            </div>
                            <div class="text-gray-500">
                                Asignación de Cargo Laboral
                            </div>
                        </div>

                        <form @submit.prevent="store" autocomplete="off">

                            <div class="mb-4">
                                <label for="countries" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white required">Planta</label>
                                <VueMultiselect
                                    v-model="form.branch"
                                    :options="db.branches"
                                    placeholder="Selecciona una planta"
                                    label="name"
                                    track-by="id"
                                ></VueMultiselect>
                                <div v-if="errors.branch" class="text-error">{{ errors.branch }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-0 text-sm font-medium text-gray-900 dark:text-white required">Área</label>
                                <VueMultiselect
                                    v-model="form.area"
                                    :options="db.employmentAreas"
                                    placeholder="Selecciona una área "
                                    label="name"
                                    track-by="id"
                                ></VueMultiselect>
                                <div v-if="errors.area" class="text-error">{{ errors.area }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-0 text-sm font-medium text-gray-900 dark:text-white required">Puesto</label>
                                <VueMultiselect
                                    v-model="form.title"
                                    :options="db.employmentTitles"
                                    placeholder="Selecciona un puesto"
                                    label="name"
                                    track-by="id"
                                ></VueMultiselect>
                                <div v-if="errors.title" class="text-error">{{ errors.title }}</div>
                            </div>

                            <div class="mb-4">
                                <label for="employee_number" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Fecha de inicio</label>
                                <input type="date" v-model="form.start_at" id="employee_number" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4" required>
                            </div>

                            <div class="mb-6 mt-6 text-right">
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

import VueMultiselect from 'vue-multiselect'

export default {
    components: {
        VueMultiselect
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
            form: useForm({
                branch: null,
                area: null,
                title: null,
                start_at: null,
            }),
        }
    },

    props: {
        data: Object,
        db: Object,
        errors: Object,
    },

    methods: {
        store() {
            this.form.post(`/go/employees/${this.data.id}/employments`)
        },
    }    

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

