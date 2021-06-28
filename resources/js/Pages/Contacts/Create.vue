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
    <contact-form
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
    </contact-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { saveContact } from "../../Api/contacts";
import { computed, watch, ref } from "vue";

import { Inertia } from "@inertiajs/inertia";
import ContactForm from "../../Components/Contact/ContactForm.vue";
export default {
  components: {
    AppLayout,
    ContactForm,
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
    is_vendor: {
      default: "",
      type: String,
    },
    is_customer: {
      default: "",
      type: String,
    },
  },
  name: "Create",
  setup(props, context) {
    const err = ref({});
    const form = ref({
      name: null,
      reference: null,
      website: null,
      currency_code: "USD",
      tax_number: null,
      email: null,
      address: null,
      is_vendor: Boolean(props.is_vendor),
      is_customer: Boolean(props.is_customer),
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
