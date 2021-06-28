<template>
  <app-layout>
    <template #title>
      Create {{title }}
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
          @click="saveContact(form,onSuccess)"
        >Save</button>
      </template>
    </document-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { saveContact } from "../../Api/contacts";
import { computed, watch, ref } from "vue";

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
    type: {
      default: "",
      type: String,
    },
  },
  name: "Create",
  setup(props, context) {
    const err = ref({});
    const form = ref({
      contact_id: null,
      document_number: null,
      order_number: null,
      issued_at: null,
      due_at: null,
      parent_id: null,
      footer: null,
      status: null,
      notes: null,
      items: [],
      type: props.type,
    });
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess() {
      Inertia.visit(props.url);
    }
    return {
      context,
      form,
      onSuccess,
      saveContact: saveContact,
      errors,
    };
  },
};
</script>

<style>
</style>
