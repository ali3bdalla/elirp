<template>
  <div>
    <div v-if="isLoading">is Loading</div>
    <!-- <el-table
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
        :total="tableData.total"
      >
      </el-pagination>
    </div> -->
  </div>
</template>

<script>
import { useQuery } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { computed, watch, ref } from "vue";
function fetch(page) {
  return useQuery(gql`
      query {
        getUsers(page: ${page.value}) {
          data {
            id
            name
            email
            enabled
            created_at
            updated_at
          }
          paginatorInfo {
            count
            perPage
            currentPage
            total
            firstItem
            lastItem
          }
        }
      }
    `);
}
export default {
  name: "DataGridFrame",
  setup(props, context) {
    const page = ref(1);
    const isLoading = ref(true);
    // const tableData = ref({});
    const tableData = computed(function () {
      const f = fetch(page);
      return f.result.data;
    });

    return {
      tableData,
      isLoading,
    };
  },
  // props: {
  //   // dataGrid: {
  //   //   type: Object,
  //   //   required: true,
  //   // },
  // },
  // data() {
  //   return {
  //     fetching: true,
  //     tableData: {},
  //   };
  // },
  // created() {
  //   console.log(this.dataGrid);
  //   // this.fetch();
  // },
  // methods: {
  //   fetch() {
  //     // this.fetching = true
  //     // axios
  //     //     .get(this.url)
  //     //     .then((res) => {
  //     //       this.tableData = res.data
  //     //     })
  //     //     .finally(() => {
  //     //       this.fetching = false
  //     //     })
  //   },
  // },
};
</script>

<style scoped>
</style>
