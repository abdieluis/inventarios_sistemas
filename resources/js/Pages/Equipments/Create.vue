<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import DialogModal from '@/Components/DialogModal.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <Breadcrumbs :data="breadcrumbs"/>
        </template>
        <div class="py-12 max-w-2xl mx-auto px-6">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-12 bg-white border-b border-gray-200">
                    
                    <div class="mt-6 mb-6">
                        <div class="mb-1 text-2xl">
                            Registro de Equipo
                        </div>
                        <div class="text-gray-500">
                            Completa los siguientes datos del Equipo
                        </div>
                    </div>

                    <form @submit.prevent="store" autocomplete="off">

                        <div class="">

                            <div class="mb-6">
                                <label for="category" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Tipo de Equipo</label>
                                <VueMultiselect
                                    v-model="form.category"
                                    :options="db.categories"
                                    placeholder="Selecciona una categoría "
                                    label="name"
                                    track-by="id"
                                    :show-labels="false"
                                ></VueMultiselect>
                                <div v-if="errors.category" class="text-error">{{ errors.category }}</div>
                            </div>

                            <!--div class="mb-4">
                                <label for="brand" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Marca / Modelo</label>
                                <VueMultiselect
                                    v-model="form.brandModel"
                                    :options="db.brandModel"
                                    placeholder="Selecciona una área "
                                    label="name"
                                    track-by="id"
                                ></VueMultiselect>
                                <div v-if="errors.brand" class="text-error">{{ errors.brand }}</div>
                            </div-->

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="brand" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Marca</label>
                                        <VueMultiselect
                                            v-model="form.brand"
                                            :options="db.brands"
                                            placeholder="Selecciona una marca"
                                            label="name"
                                            track-by="id"
                                            :show-labels="false"
                                        ></VueMultiselect>
                                        <div v-if="errors.brand" class="text-error">{{ errors.brand }}</div>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="model" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Modelo</label>
                                        <VueMultiselect
                                            v-model="form.model"
                                            :options="get_models( form.category, form.brand )"
                                            placeholder="Selecciona un modelo"
                                            label="name"
                                            track-by="id"
                                            :show-labels="false"
                                            :show-no-results="false"
                                            :show-no-options="false"
                                        ></VueMultiselect>
                                        <div v-if="errors.model" class="text-error">{{ errors.model }}</div>                                        
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="sku" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">No. de Placa</label>
                                        <input type="text" v-model="form.sku" id="sku" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3">
                                        <div v-if="errors.sku" class="text-error">{{ errors.sku }}</div>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="serial" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">No. de Serie</label>
                                        <input type="text" v-model="form.serial" id="serial" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3">
                                        <div v-if="errors.serial" class="text-error">{{ errors.serial }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white shadow-md rounded px-6 py-6 mb-6 flex flex-col">
                                <div class="mb-2 text-lg">Características especiales</div>

                                <div v-for="feature in db.features">
                                    <div v-if="show_feature(feature)" class="mb-4">

                                        <label class="block tracking-wide text-sm font-medium text-gray-900 mb-1">{{feature.name}}</label>

                                        <template v-if="feature.type == 'Lista desplegable'">
                                            <VueMultiselect 
                                                v-model="form.features[feature.id]"
                                                :options="feature.options"
                                                placeholder="Selecciona una opción"
                                                label="name"
                                                track-by="id" 
                                                :show-labels="false"
                                            ></VueMultiselect>
                                        </template> 

                                        <template v-else-if="feature.type == 'Checkbox'">
                                            <input type="checkbox" v-model="form.features[feature.id]" id="serial" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-5 px-3">
                                        </template> 

                                        <template v-else-if="feature.type == 'Valor Númerico'">
                                            <input type="number" v-model="form.features[feature.id]" id="serial" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3">
                                        </template> 

                                        <template v-else>
                                            <input type="text" v-model="form.features[feature.id]" id="serial" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3">
                                        </template> 

                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="owner" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Empresa propietaria</label>
                                <VueMultiselect
                                    v-model="form.owner"
                                    :options="db.owners"
                                    placeholder="Selecciona una área "
                                    label="name"
                                    track-by="id"
                                    :show-labels="false"
                                ></VueMultiselect>
                                <div v-if="errors.owner" class="text-error">{{ errors.owner }}</div>
                            </div>

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3">
                                        <label for="status" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Estado del equipo</label>
                                        <VueMultiselect
                                            v-model="form.lifecycle"
                                            :options="db.lifecycle"
                                            placeholder="Selecciona el estado del equipo"
                                            :show-labels="false"
                                        ></VueMultiselect>
                                        <div v-if="errors.lifecycle" class="text-error">{{ errors.lifecycle }}</div>
                                    </div>
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="status" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Disponibilidad</label>
                                        <VueMultiselect
                                            v-model="form.status"
                                            :options="db.status"
                                            placeholder="Selecciona la disponibilidad"
                                            :show-labels="false"
                                        ></VueMultiselect>
                                        <div v-if="errors.status" class="text-error">{{ errors.status }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="owner" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Año de compra del equipo</label>
                                <VueMultiselect
                                    v-model="form.purchase_year"
                                    :options="db.purchase_years"
                                    placeholder="Selecciona el año de compra"
                                    track-by="year"
                                    show-labels="false"
                                ></VueMultiselect>
                                <div v-if="errors.purchase_years" class="text-error">{{ errors.purchase_years }}</div>
                            </div>
                            <div class="mb-6">
                                <label for="notes" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Observaciones</label>
                                <textarea v-model="form.notes" id="notes" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3"></textarea>
                            </div>
                            <div class="mb-4 mt-4 text-right">
                                <a :href="route('equipments')" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</a>
                                <button type="submit" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
                            </div>
                        </div>
                    </form>
                    
                </div>

            </div>
        </div>

    </AppLayout>
</template>

<script>

import { useForm } from "@inertiajs/inertia-vue3";
import VueMultiselect from 'vue-multiselect';
import Breadcrumbs from '../../Components/Go/Breadcrumbs.vue';

export default {
    components: {
    VueMultiselect,
    Breadcrumbs
},

    //layout: AppLayout,
    remember: 'form',
        data() {
        return {
            form: useForm({
                category: null,
                brand: null,
                model: null,

                sku: null,
                serial: null,

                features: {},

                owner: null,
                status: null,
                lifecycle: null,
                notes: '',
                purchase_year: null,

            }),
            breadcrumbs: [
                { label: "Equipos", url: route('equipments') },
                { label: 'Nuevo' }
            ]
        }
    },

    props: {
        db: Object,
        errors: Object,
    },

    methods: {
        store() {
            this.form.post( route('equipments.store') );
        },

        show_feature( feature ){
            for( const category of feature.categories ){
                console.log( this.form.category?.id + ':' + category.id );
                if( category?.id == this.form.category?.id ){
                    return true;
                }
            }
            return false;
        },

        get_models( category, brand ){

            let options = [];
            if( category!=null && brand!=null ){
                for( const model of this.db.models ){
                    if( category?.id == model?.category_id && brand?.id == model?.brand_id ){
                        options.push( model );
                    }
                }
            }
            return options;

        }

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




