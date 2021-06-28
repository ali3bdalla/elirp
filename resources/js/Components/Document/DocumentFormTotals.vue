<template>
  <div class="row mt-5">
    <div class="col-md-4 col-sm-12 offset-md-8 border">
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
</template>

<script>
import { computed } from "vue-demi";
export default {
  name: "DocumentFormTotals",
  props: {
    items: {
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
    return {
      totals,
    };
  },
};
</script>

<style>
</style>
