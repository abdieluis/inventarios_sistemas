<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
</script>

<template>
  <div class="flex items-center justify-between">
    <div class="">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Empleados</h2>
    </div>
    <div class="relative inline-block text-left">
      <Dropdown width="48">
        <template #trigger>
          <span class="inline-flex rounded-md">
            <button type="button" class="inline-flex items-center px-3 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-50 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
            </button>
          </span>
        </template>
        <template #content>
          <div class="w-48">
            <div class="block px-4 py-2 text-xs text-gray-400">Equipment Options</div>
            <DropdownLink v-if="true" :href="route('branches' )">Plantas</DropdownLink>
            <DropdownLink v-if="true" :href="route('employment-areas' )">Áreas</DropdownLink>
            <DropdownLink v-if="true" :href="route('employment-titles')">Puestos</DropdownLink>
            <div class="border-t border-gray-100"></div>
            <DropdownLink v-if="true" href="#">Ajustes</DropdownLink>
          </div>
        </template>
      </Dropdown>
    </div>
  </div>
</template>

<script>
export default {
  components: {
  },
  data() {
  },
}
</script>