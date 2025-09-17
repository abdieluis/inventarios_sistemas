<template>

    <div class="flex items-center">   
        <label for="voice-search" class="sr-only">Buscar</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input
                type="search"
                id="search" 
                ref="search"
                v-model="search"
                :class="{ 'transition-border': search }"
                autocomplete="off"
                name="search"
                @keyup.esc="search = null"
                @blur="search = null"
                placeholder="Buscar por nombre, no. empleado, planta, área, puesto"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            />
        </div>
    </div>
    
</template>
 
<script>
    import { defineComponent } from "vue";
 
    export default defineComponent({
        props: {
            // any route name from laravel routes (ideally index route is what you'd search through)
            routeName: String,
        },
 
        data() {
            return {
                // page.props.search will come from the backend after search has returned.
                search: this.$inertia.page.props.search || null,
            };
        },
 
        watch: {
            search() {
                if (this.search) {
                    // if you type something in the search input
                    this.searchMethod();
                } else {
                    // else just give us the plain ol' paginated list - route('stories.index')
                    this.$inertia.get(route(this.routeName));
                }
            },
        },
 
        methods: {
            searchMethod: _.debounce(function () {
                this.$inertia.get(
                    route(this.routeName),
                    { search: this.search },
                    { preserveState: true }
                );
            }, 500),
        },
    });
</script>