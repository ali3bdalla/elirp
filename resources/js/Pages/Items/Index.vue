<template>
  <app-layout>
    <template #title>
      {{  $page.props.locale.app.items }}
    </template>
    <template #actions>
      <inertia-link
        :href="route('items.create')"
        class='btn btn-success'
      >
        {{  $page.props.locale.app.add }} {{  $page.props.locale.inventory.item }}
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
