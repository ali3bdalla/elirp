<template>
  <app-layout>
    <template #title>
      Items List
    </template>
    <template #actions>
      <inertia-link
        :href="route('items.create')"
        class='btn btn-success'
      >
        Create Item
      </inertia-link>
    </template>

    <item-table></item-table>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import ItemTable from "../../Components/Item/ItemTable";
export default {
  name: "Index",
  components: { AppLayout, ItemTable },
};
</script>

<style scoped>
</style>
