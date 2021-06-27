<template>
  <app-layout>
    <template #title>
      Update Item
    </template>
    <template #actions>
      <inertia-link
        :href="route('items.index')"
        class="btn btn-default"
      >
        back to items
      </inertia-link>
    </template>
    <item-form
      v-model="form"
      :value='form'
    >
      <template #form-footer>
        <button
          class="btn btn-primary"
          @click="updateItem(form,itemId,onSuccess)"
        >Update</button>
      </template>
    </item-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { updateItem } from "../../Api/items";
import { computed, watch, ref } from "vue";

import { Inertia } from "@inertiajs/inertia";
import ItemForm from "../../Components/Item/ItemForm.vue";
export default {
  props: {
    item: {
      required: true,
      type: Object,
    },
  },
  components: {
    AppLayout,
    ItemForm,
  },
  name: "Edit",
  setup(props, context) {
    const err = ref({});
    const form = ref(props.item);
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess() {
      Inertia.visit(route("items.index"));
    }
    return {
      itemId: props.item.id,
      context,
      form,
      onSuccess,
      updateItem: updateItem,
      errors,
    };
  },
};
</script>

<style>
</style>
