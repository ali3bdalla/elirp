<template>
  <app-layout>
    <template #title>
      {{ $page.props.locale.app.edit }} {{  $page.props.locale.invoicing[`${title}`] }}
    </template>
    <template #actions>
      <inertia-link
        :href="url"
        class="btn btn-default"
      >
        {{ $page.props.locale.app.back_to }} {{  $page.props.locale.app[`${title}s`] }}
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
          @click="updateContact(form,contactId,onSuccess)"
        >{{ $page.props.locale.app.save }}</button>
      </template>
    </contact-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { updateContact } from "../../Api/contacts";
import { computed, watch, ref } from "vue";

import { Inertia } from "@inertiajs/inertia";
import ContactForm from "../../Components/Contact/ContactForm.vue";
export default {
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
    contact: {
      required: true,
      type: Object,
    },
  },
  components: {
    AppLayout,
    ContactForm,
  },
  name: "Edit",
  setup(props, context) {
    const err = ref({});
    const form = ref(props.contact);
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess() {
      Inertia.visit(props.url);
    }
    return {
      contactId: props.contact.id,
      context,
      form,
      onSuccess,
      updateContact,
      errors,
    };
  },
};
</script>

<style>
</style>
