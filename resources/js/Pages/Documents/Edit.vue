<template>
  <app-layout>
    <template #title>
      Update {{title }}
    </template>
    <template #actions>
      <inertia-link
        :href="url"
        class="btn btn-default"
      >
        Back to {{title }}s
      </inertia-link>
    </template>
    <document-form
      :type="type"
      :title="title"
      v-model="form"
      :value='form'
    >
      <template #form-footer>
        <button
          class="btn btn-primary"
          @click="update(form,id,onSuccess)"
        >Save</button>
      </template>
    </document-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { update } from "../../Api/documents";
import { computed, ref } from "vue";

import { Inertia } from "@inertiajs/inertia";
import DocumentForm from "../../Components/Document/DocumentForm.vue";
export default {
  components: {
    AppLayout,
    DocumentForm,
  },
  props: {
    url: {
      default: "",
      type: String,
    },
    title: {
      default: "",
      type: String,
    },
    document: {
      type: Object,
      required: true,
    },
  },
  name: "Create",
  setup(props, context) {
    const err = ref({});
    const form = ref(props.document);
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess() {
      Inertia.visit(props.url);
    }
    return {
      id: props.document.id,
      context,
      form,
      onSuccess,
      update,
      errors,
    };
  },
};
</script>

<style>
</style>
