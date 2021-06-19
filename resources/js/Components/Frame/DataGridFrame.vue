<template>
  <div>
    <el-table
        :data="tableData.data"
        v-loading="fetching"
        border
        size="medium"
        lazy
        :sortable="true"
        v-bind="$props"
    >
      <template v-slot:title>
        <slot name="title"></slot>
      </template>
      <slot name="rows"></slot>
      <slot name="footer"></slot>
    </el-table>
    <div class="py-3 flex items-center justify-center">
      <el-pagination
          :page-size="tableData.per_page"
          :background="true"
          small
          layout="prev, pager, next"
          :total="tableData.total">
      </el-pagination>
    </div>
  </div>
</template>

<script>
export default {
  name: "DataGridFrame",
  props: {
    url: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      fetching: true,
      tableData: {}
    }
  },
  created () {
    this.fetch()
  },
  methods: {
    fetch () {
      this.fetching = true
      axios
          .get(this.url)
          .then((res) => {
            this.tableData = res.data
          })
          .finally(() => {
            this.fetching = false
          })
    }
  }
}
</script>

<style scoped>

</style>
