<template>
  <div>
    <div class="card-header">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <el-radio-group v-model="enabledStatus">
            <el-radio-button :label="1">All ({{totalUsers}})</el-radio-button>
            <el-radio-button :label="2">Active ({{totalActiveUsers}})</el-radio-button>
            <el-radio-button :label="3">In Active ({{totalInActiveUsers}})</el-radio-button>
          </el-radio-group>
        </div>

        <div>
          <input
            type="text"
            class="form-control form-control-sm"
            placeholder="search..."
            v-model="searching"
          />
        </div>
      </div>
    </div>
    <data-grid-frame
      @sort-change="sortChanged"
      @pageChanged="pageChanged"
      :loading="loading"
      :items="users"
      :paginator-info="paginatorInfo"
    >
      <template v-slot:title>hello</template>
      <template v-slot:rows>
        <data-grid-column
          label="id"
          props="id"
          width="100"
        >
          <template v-slot:default="{ item }">
            {{ item.id }}
          </template>
        </data-grid-column>
        <data-grid-column
          label="Name"
          props="name"
        >
          <template v-slot:default="{ item }">
            <div class="d-flex p-2 bd-highlight justify-items-center
            align-self-center
             justify-content-start">
              <el-avatar
                shape="circle"
                size="small"
                :src="item.profile_photo_url"
                :alt="item.name"
              ></el-avatar>
              <div class="ml-2">
                {{ item.name }}
              </div>
            </div>
          </template>
        </data-grid-column>
        <data-grid-column
          label="E-mail Address"
          props="email"
        >
          <template v-slot:default="{ item }">
            {{ item.email }}
          </template>
        </data-grid-column>
        <data-grid-column
          width="120"
          label="Status"
          props="enabled"
        >
          <template v-slot:default="{ item }">
            <el-tag
              type="success"
              effect="dark"
              v-if="item.enabled"
            >
              Active
            </el-tag>
            <el-tag
              effect="dark"
              type="danger"
              v-else
            >
              Disabled
            </el-tag>
          </template>
        </data-grid-column>
        <data-grid-column
          label="Created At"
          props="created_at"
        >
          <template v-slot:default="{ item }">
            {{ item.created_at }}
          </template>
        </data-grid-column>
        <data-grid-column label="Option">
          <template v-slot:default="{ item }">
            <el-dropdown>
              <button class="btn btn-primary btn-sm">
                Manage
              </button>
              <template #dropdown>
                <el-dropdown-menu>

                  <inertia-link :href="route('users.edit',`${item.id}`)">
                    <el-dropdown-item>Edit</el-dropdown-item>
                  </inertia-link>

                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </template>
        </data-grid-column>
      </template>
    </data-grid-frame>
  </div>
</template>

<script>
import DataGridFrame from "../Frame/DataGridFrame";
import DataGridColumn from "../Frame/DataGridColumn";
import PrimaryButton from "../Button/PrimaryButton.vue";
import { useQuery, useResult } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { computed, watch, ref } from "vue";
import { trim } from "lodash";
export default {
  name: "UserTable",
  components: { DataGridColumn, PrimaryButton, DataGridFrame },
  setup() {
    const paramters = ref({ page: 1, enabled: 1, search: "" });
    const enabledStatus = ref(1);
    const searching = ref("");
    const { result, loading } = useQuery(
      gql`
        query getUsers($page: Int!, $enabled: Int!, $search: String!) {
          totalActiveUsers
          totalInActiveUsers
          getUsers(page: $page, enabled: $enabled, search: $search) {
            data {
              id
              name
              email
              enabled
              profile_photo_url
              created_at
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
      `,
      paramters
    );
    const users = useResult(result, [], (data) => data.getUsers.data);
    const totalInActiveUsers = useResult(
      result,
      null,
      (data) => data.totalInActiveUsers
    );
    const totalActiveUsers = useResult(
      result,
      null,
      (data) => data.totalActiveUsers
    );
    const totalUsers = useResult(result, 0, (data) => {
      return (
        parseInt(data.totalInActiveUsers) + parseInt(data.totalActiveUsers)
      );
    });
    const paginatorInfo = useResult(
      result,
      {},
      (data) => data.getUsers.paginatorInfo
    );
    watch(enabledStatus, function (value) {
      let params = paramters.value;
      params.enabled = value;
      paramters.value = params;
    });
    function pageChanged(currentPage) {
      let params = paramters.value;
      params.page = currentPage;
      paramters.value = params;
    }

    function sortChanged(attribute, order) {
    }
    watch(searching, function (value) {
      let params = paramters.value;
      params.search = trim(value);
      paramters.value = params;
    });

    return {
      searching,
      sortChanged,
      totalInActiveUsers,
      totalActiveUsers,
      totalUsers,
      paramters,
      pageChanged,
      enabledStatus,
      users,
      paginatorInfo,
      loading,
    };
  },
};
</script>
