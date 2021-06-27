<template>
  <div>
    <data-grid-frame
      @pageChanged="pageChanged"
      :loading="loading"
      :items="users"
      :paginator-info="paginatorInfo"
    >
      <template v-slot:title>hello</template>
      <template v-slot:rows>
        <data-grid-column
          label="id"
          width="60"
        >
          <template v-slot:default="{ item }">
            {{ item.id }}
          </template>
        </data-grid-column>
        <data-grid-column label="Name">
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
        <data-grid-column label="E-mail Address">
          <template v-slot:default="{ item }">
            {{ item.email }}
          </template>
        </data-grid-column>
        <data-grid-column
          width="120"
          label="Status"
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
        <data-grid-column label="Created At">
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
import UserForm from "./UserForm";
import DataGridFrame from "../Frame/DataGridFrame";
import DataGridColumn from "../Frame/DataGridColumn";
import PrimaryButton from "../Button/PrimaryButton.vue";
import { useQuery, useResult } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { computed, watch, ref } from "vue";
export default {
  name: "UserTable",
  components: { DataGridColumn, PrimaryButton, DataGridFrame, UserForm },
  setup() {
    const paramters = ref({ page: 1 });

    const { result, loading } = useQuery(
      gql`
        query getUsers($page: Int!) {
          getUsers(page: $page) {
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
    const paginatorInfo = useResult(
      result,
      {},
      (data) => data.getUsers.paginatorInfo
    );
    function pageChanged(currentPage) {
      paramters.value = {
        page: currentPage,
      };
    }
    return {
      pageChanged,
      users,
      paginatorInfo,
      loading,
    };
  },
};
</script>
