<template>
  <app-layout>
    <template #title>
      {{ $page.props.locale.app.add }} {{  $page.props.locale.invoicing[`${title}`] }}
    </template>
    <template #actions>
      <inertia-link
        :href="url"
        class="btn btn-default"
      >
        {{ $page.props.locale.app.back_to }} {{  $page.props.locale.app[`${title}s`] }}
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
          @click="save(form,onSuccess)"
        > {{ $page.props.locale.app.save }}</button>
      </template>
    </document-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { save } from "../../Api/documents";
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
    type: {
      default: "",
      type: String,
    },
    document_number: {
      required: true,
      type: String,
    },
  },
  name: "Create",
  setup(props, context) {
    const err = ref({});
    const form = ref({
      contact_id: null,
      document_number: props.document_number,
      order_number: null,
      issued_at: new Date(),
      due_at: new Date(new Date().setMonth(new Date().getMonth() + 1)),
      parent_id: null,
      footer: null,
      currency_code: "USD",
      currency_rate: 1,
      status: "draft",
      notes: null,
      items: [],
      type: props.type,
    });
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess(e) {
      Inertia.visit(`${props.url}/${e.id}/edit`);
    }
    return {
      context,
      form,
      onSuccess,
      save,
      errors,
    };
  },
};
</script>

<style>
</style>
