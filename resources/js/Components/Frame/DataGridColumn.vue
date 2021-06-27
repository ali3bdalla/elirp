<template>
  <el-table-column
    sortable="custom"
    v-bind="$props"
  >
    <template #default="props">
      <slot
        name="default"
        :item="props.row"
      ></slot>
    </template>
  </el-table-column>
</template>

<script>
export default {
  name: "DataGridColumn",
  props: {
    label: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
</style>
