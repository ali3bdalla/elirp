<template>
  <app-layout>
    <template #title>
      {{  title }}s List
    </template>
    <template #actions>
      <inertia-link
        :href="create_url"
        class='btn btn-success'
      >
        Create {{  title }}
      </inertia-link>
    </template>

    <document-table
      :url="url"
      :type="type"
    ></document-table>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import DocumentTable from "../../Components/Document/DocumentTable";
export default {
  name: "Index",
  props: {
    create_url: {
      default: "",
      type: String,
    },
    url: {
      default: "",
      type: String,
    },
    title: {
      default: "",
      type: String,
    },
    type: {
      default: "",
      type: String,
    },
  },
  components: { AppLayout, DocumentTable },
};
</script>

<style scoped>
</style>
