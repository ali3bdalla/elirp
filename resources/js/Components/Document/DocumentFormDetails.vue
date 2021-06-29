<template>
  <div class="mt-5">
    <div class="row">
      <div
        class="col-md-6 col-sm-12 "
        v-if="histories"
      >
        <div class="bg-primary text-white p-2 font-bold">
          History
        </div>
        <div
          class="border-bottom  p-2 font-bold d-flex justify-content-between
       justify-items-center"
          v-for="(history,index) in histories"
          :key="index"
        >
          <div class="w-25">
            {{  history.status }}
          </div>
          <div class="w-25">
            {{  history.description }}
          </div>
          <div class="w-25">
            {{  history.created_by ?  history.created_by.name : " " }}
          </div>
          <div class="w-25">
            {{  history.created_at }}
          </div>
        </div>

      </div>

      <div class="col-md-4 offset-md-2 col-sm-12">
        <div class="bg-primary text-white p-2 font-bold">
          Totals
        </div>
        <div
          class="border-bottom  p-2 font-bold d-flex justify-content-between
       justify-items-center"
          v-for="(total,index) in totals"
          :key="index"
        >
          <div>
            {{  total.name }}
          </div>
          <div class="font-bold text-bold bold text-lg">
            {{  total.amount }}
          </div>
        </div>

      </div>
    </div>
    <div class="row my-5">

      <div
        class="col-md-6 col-sm-12 text-center shadow"
        v-if="transactions && transactions.length"
      >
        <div class="bg-primary text-white p-2 font-bold">
          Accounting transactions
        </div>
        <div class="border-bottom  p-2 font-bold d-flex justify-content-between
       justify-items-center text-primary">
          <div class="w-25">
            Account
          </div>
          <div class="w-25">
            Debit
          </div>
          <div class="w-25">
            Credit
          </div>
          <div class="w-25">
            Date
          </div>
        </div>
        <div
          class="border-bottom  p-2 font-bold d-flex justify-content-between
       justify-items-center"
          v-for="(transaction,index) in transactions"
          :key="index"
        >
          <div class="w-25 text-lg">
            {{  transaction.account_name }}
          </div>
          <div class="w-25">
            <span v-if="transaction.type === 'DEBIT'">
              {{  transaction.amount }}
            </span>
          </div>
          <div class="w-25">
            <span v-if="transaction.type === 'CREDIT'">
              {{  transaction.amount }}
            </span>
          </div>
          <div class="w-25">
            {{  transaction.created_at }}
          </div>
        </div>

        <div class="border-bottom  p-2 font-bold d-flex justify-content-between
       justify-items-center shadow">
          <div class="w-25">

          </div>
          <div class="w-25">
            {{  totalDebit }}
          </div>
          <div class="w-25">
            {{  totalCredit }}
          </div>
          <div class="w-25">

          </div>
        </div>
      </div>

      <div
        class="col-md-6 col-sm-12 text-center  border-left-primary shadow"
        v-if="transactions && transactions.length"
      >
        <div class="bg-primary text-white p-2 font-bold">
          Inventory transactions
        </div>
        <div class="border-bottom  p-2 font-bold d-flex justify-content-between
       justify-items-center text-primary">
          <div class="w-25">
            Item
          </div>
          <div class="w-25">
            quantity
          </div>
          <div class="w-25">
            type
          </div>
          <div class="w-25">
            Date
          </div>
        </div>
        <div
          class="border-bottom  p-2 font-bold d-flex justify-content-between
       justify-items-center"
          v-for="(transaction,index) in inventoryTransactions"
          :key="index"
        >
          <div class="w-25 text-lg">
            {{  transaction.item.name }}
          </div>
          <div class="w-25">
            {{  transaction.quantity }}
          </div>
          <div class="w-25">
            {{  transaction.type }}
          </div>
          <div class="w-25">
            {{  transaction.created_at }}
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import { computed } from "vue-demi";
export default {
  name: "DocumentFormDetails",
  props: {
    items: {
      type: Array,
      default: () => [],
    },
    histories: {
      type: Array,
      default: () => [],
    },
    transactions: {
      type: Array,
      default: () => [],
    },
    inventoryTransactions: {
      type: Array,
      default: () => [],
    },
  },
  setup(props) {
    function sm(field) {
      return parseFloat(
        props.items.reduce((p, value) => {
          return parseFloat(p) + parseFloat(value[field]);
        }, 0)
      ).toFixed(2);
    }
    const totals = computed(function () {
      let t = [];
      t.push({
        name: "Total",
        amount: sm("total"),
      });
      t.push({
        name: "Discount",
        amount: sm("discount"),
      });
      t.push({
        name: "Subtotal",
        amount: sm("subtotal"),
      });

      return t;
    });
    const totalDebit = computed(function () {
      if (!props.transactions) return 0;
      return parseFloat(
        props.transactions.reduce((p, value) => {
          return (
            parseFloat(p) +
            (value.type === "DEBIT" ? parseFloat(value.amount) : 0)
          );
        }, 0)
      ).toFixed(2);
    });

    const totalCredit = computed(function () {
      if (!props.transactions) return 0;
      return parseFloat(
        props.transactions.reduce((p, value) => {
          return (
            parseFloat(p) +
            (value.type === "CREDIT" ? parseFloat(value.amount) : 0)
          );
        }, 0)
      ).toFixed(2);
    });
    return {
      totalDebit,
      totalCredit,
      totals,
    };
  },
};
</script>

<style>
</style>
