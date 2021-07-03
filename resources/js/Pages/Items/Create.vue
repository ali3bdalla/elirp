<template>
  <app-layout>
    <template #title>
      {{ $page.props.locale.app.add }} {{ $page.props.locale.inventory.item }}
    </template>
    <template #actions>
      <inertia-link
        :href="route('items.index')"
        class="btn btn-default"
      >
        {{ $page.props.locale.app.back_to }} {{ $page.props.locale.app.items }}
      </inertia-link>
    </template>
    <item-form
      v-model="form"
      :value='form'
    >
      <template #form-footer>
        <button
          class="btn btn-primary"
          @click="saveItem(form,onSuccess)"
        >{{ $page.props.locale.app.save }}</button>
      </template>
    </item-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";

import gql from "graphql-tag";
import { saveItem } from "../../Api/items";
import { computed, watch, ref } from "vue";

import { Inertia } from "@inertiajs/inertia";
import ItemForm from "../../Components/Item/ItemForm.vue";
export default {
  components: {
    AppLayout,
    ItemForm,
  },
  name: "Create",
  setup(_, context) {
    const err = ref({});
    const form = ref({
      sku: null,
      model_number: null,
      model_name: null,
      name: null,
      brand: null,
      sale_price: null,
      purchase_price: null,
      description: null,
      tags: null,
    });
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess() {
      Inertia.visit(route("items.index"));
    }
    return {
      context,
      form,
      onSuccess,
      saveItem: saveItem,
      errors,
    };
  },
};
</script>

<style>
</style>
