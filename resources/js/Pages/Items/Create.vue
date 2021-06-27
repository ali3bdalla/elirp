<template>
  <app-layout>
    <template #title>
      Create Item
    </template>
    <template #actions>
      <inertia-link
        :href="route('items.index')"
        class="btn btn-default"
      >
        Back to Items
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
        >Save</button>
      </template>
    </item-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { useMutation } from "@vue/apollo-composable";
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
