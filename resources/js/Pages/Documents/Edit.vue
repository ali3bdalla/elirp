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
      :show="true"
      :type="type"
      :title="title"
      v-model="form"
      :value='form'
    >
      <template #form-footer>
        <a
          class="btn btn-secondary mx-2"
          :href="route('documents.print',document.id)"
        ><i class="fas fa-print"></i> Print {{ title }}</a>

        <button
          class="btn btn-danger mx-2"
          v-if="showReturnButton()"
        ><i class="el-icon-refresh"></i> Returned</button>

        <button
          class="btn btn-success mx-2"
          v-if="showRecievedButton()"
          @click="confirmAction(received)"
        ><i class="el-icon-coin"></i> Received</button>

        <button
          class="btn btn-warning mx-2"
          v-if="showPaidButton()"
        ><i class="el-icon-money"></i> Paid</button>

        <!-- <button class="btn btn-primary mx-2"><i class="fas fa-cloud"></i> Billed {{ title }}</button>

        <a
          class="btn btn-info mx-2"
          :href="route('documents.print',document.id)"
        ><i class="fas fa-print"></i> Print {{ title }}</a> -->

        <!-- <a
          class="btn btn-danger mx-2"
          :href="route('documents.print',document.id)"
        ><i class="fas fa-close"></i> Cancel {{ title }}</a>
        <a
          class="btn btn-dark mx-2"
          :href="route('documents.print',document.id)"
        ><i class="fas fa-print"></i> Print {{ title }}</a> -->
      </template>
    </document-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { update, received } from "../../Api/documents";
import { computed, ref } from "vue";
import { askUser } from "./../../Plugins/alert";
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
      type: String,
      required: true,
    },
    document: {
      type: Object,
      required: true,
    },
  },
  name: "Edit",
  setup(props, context) {
    const err = ref({});
    const form = ref(props.document);
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess() {
      Inertia.visit(props.url);
    }
    function showRecievedButton() {
      return (
        props.type === "BILL" &&
        props.document.status !== "cancelled" &&
        !props.document.histories.find((p) => p.status == "received")
      );
    }
    function showPaidButton() {
      return (
        props.document.status !== "cancelled" &&
        !props.document.histories.find((p) => p.status == "paid") &&
        !props.document.histories.find((p) => p.status == "returned")
      );
    }
    function showReturnButton() {
      return (
        props.document.status !== "cancelled" &&
        props.document.histories.find((p) => p.status == "received") &&
        !props.document.histories.find((p) => p.status == "returned")
      );
    }

    function confirmAction(callback) {
      askUser().then((res) => {
        if (res.isConfirmed) {
          callback(props.document.id);
        }
      });
    }
    return {
      received,
      confirmAction,
      showReturnButton,
      showPaidButton,
      showRecievedButton,
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
