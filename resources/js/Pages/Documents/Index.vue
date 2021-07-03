<template>
  <app-layout>
    <template #title>
      {{  $page.props.locale.app[`${title}s`] }}
    </template>
    <template #actions>
      <inertia-link
        :href="create_url"
        class='btn btn-success'
      >
        {{ $page.props.locale.app.add }} {{  $page.props.locale.invoicing[`${title}`] }}
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
