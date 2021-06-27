<template>
  <div>
    <el-table
      :data="items"
      v-loading="loading"
      border
      size="large"
      lazy
      :sortable="`custom`"
      v-bind="$props"
      row-class-name=" text-center"
      header-row-class-name="bg-dark text-center"
      header-cell-class-name="bg-primary  text-white text-normal font-bold text-center p-2"
      cell-class-name="text-center text-md"
    >
      <template v-slot:title>
        <slot name="title"></slot>
      </template>
      <slot name="rows"></slot>
      <slot name="footer"></slot>
    </el-table>
    <div class="py-3 flex items-center justify-center">
      <el-pagination
        :page-size="paginatorInfo.perPage"
        :background="true"
        small
        @current-change="pageChanged"
        layout="prev, pager, next"
        :total="paginatorInfo.total"
      >
      </el-pagination>
    </div>
  </div>
</template>

<script>
export default {
  name: "DataGridFrame",
  props: {
    items: {
      type: Array,
      required: true,
    },
    loading: {
      required: true,
      type: Boolean,
    },
    paginatorInfo: {
      type: Object,
      required: true,
    },
  },
  setup(_, context) {
    function pageChanged(page) {
      context.emit("pageChanged", page);
    }
    return {
      pageChanged,
    };
  },
};
</script>

<style scoped>
</style>
