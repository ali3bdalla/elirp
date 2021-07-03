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
          v-if="showReturnInvoiceButton()"
          @click="confirmAction(invoiceReturn)"
        ><i class="el-icon-refresh"></i> Return</button>
        <button
          class="btn btn-danger mx-2"
          v-if="showReturnBillButton()"
          @click="confirmAction(billReturn)"
        ><i class="el-icon-refresh"></i> Return</button>
        <button
          class="btn btn-warning mx-2"
          v-if="showRefundButton()"
          @click="confirmAction(refunded)"
        ><i class="el-icon-back"></i> Refund</button>

        <button
          class="btn btn-success mx-2"
          v-if="showDeliveredButton()"
          @click="confirmAction(delivered)"
        ><i class="el-icon-coin"></i> Deliver</button>

        <button
          class="btn btn-success mx-2"
          v-if="showRecievedButton()"
          @click="confirmAction(received)"
        ><i class="el-icon-coin"></i> Receive</button>

        <button
          class="btn btn-warning mx-2"
          v-if="showPaidButton()"
          @click="confirmAction(paid)"
        ><i class="el-icon-money"></i> Pay</button>

      </template>
    </document-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import {
  delivered,
  received,
  paid,
  refunded,
  billReturn,
  invoiceReturn,
} from "../../Api/documents";
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
        !props.document.histories.find((p) => p.status == "received") &&
        !props.document.histories.find((p) => p.status == "refunded")
      );
    }
    function showDeliveredButton() {
      return (
        props.type === "INVOICE" &&
        props.document.status !== "cancelled" &&
        !props.document.histories.find((p) => p.status == "delivered") &&
        !props.document.histories.find((p) => p.status == "refunded")
      );
    }
    function showPaidButton() {
      return (
        props.document.status !== "cancelled" &&
        !props.document.histories.find((p) => p.status == "paid") &&
        !props.document.histories.find((p) => p.status == "returned")
      );
    }
    function showReturnBillButton() {
      return (
        props.document.type === "BILL" &&
        props.document.status !== "cancelled" &&
        props.document.histories.find((p) => p.status == "received") &&
        !props.document.histories.find((p) => p.status == "returned")
      );
    }

    function showReturnInvoiceButton() {
      return (
        props.document.type === "INVOICE" &&
        props.document.status !== "cancelled" &&
        props.document.histories.find((p) => p.status == "delivered") &&
        !props.document.histories.find((p) => p.status == "returned")
      );
    }

    function showRefundButton() {
      return (
        props.document.status !== "cancelled" &&
        props.document.histories.find((p) => p.status == "paid") &&
        !props.document.histories.find((p) => p.status == "refunded")
      );
    }

    function confirmAction(callback) {
      askUser().then((res) => {
        if (res.isConfirmed) {
          callback(props.document.id,function(){
            location.reload()
          });
        }
      });
    }
    return {
      billReturn,
      invoiceReturn,
      delivered,
      refunded,
      paid,
      received,
      confirmAction,
      showReturnInvoiceButton,
      showDeliveredButton,
      showReturnBillButton,
      showRefundButton,
      showPaidButton,
      showRecievedButton,
      id: props.document.id,
      context,
      form,
      onSuccess,

      errors,
    };
  },
};
</script>

<style>
</style>
