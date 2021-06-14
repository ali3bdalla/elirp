<template>
    <div class="bg-white shadow-md rounded">
      <user-form :show="true"></user-form>
      <el-table
          class="min-w-max w-full table-auto"
          :data="tableData.data"
          v-loading="fetching"
          border
          highlight-current-row
          current-row-key
          :row-class-name="(row,rowIndex) => 'border-b border-gray-200 bg-gray-50 hover:bg-gray-100 text-center'"
          :header-row-class-name="(row,rowIndex) =>
           'bg-gray-200 text-center text-gray-600 uppercase text-sm leading-normal'"
          :header-cell-class-name="(row,rowIndex) =>  'py-3 px-6 text-center'"
          :cell-class-name="(row, column, rowIndex, columnIndex) => 'py-3 px-6 text-center'"
          size="medium"
          tooltip-effect="dark"
          show-summary
          lazy
          sortable
          stripe
      >
        <el-table-column
            label="Date">
          <template #default="scope">
            <i class="el-icon-time"></i>
            <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
          </template>
        </el-table-column>
        <el-table-column
            label="Name">
          <template #default="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
            label="Operations">
          <template #default="scope">
            <el-button
                size="mini"
                @click="editUser(scope.$index, scope.row)">Edit</el-button>
            <el-popconfirm
                confirmButtonText='OK'
                cancelButtonText='No'
                icon="el-icon-info"
                iconColor="red"
                title="Are you sure to delete this?"
            >
              <template #reference>
                <el-button
                    size="mini"
                    type="danger"
                 >Disable</el-button>
              </template>
            </el-popconfirm>

            <el-button
                size="mini"
                type="success"
                @click="disableUser(scope.$index, scope.row)">Enable</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>

</template>

<script>


import UserForm from "./UserForm";
export default {
  name: "UserTable",
  components: {UserForm},
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
          .get(route('api.users.index'))
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
