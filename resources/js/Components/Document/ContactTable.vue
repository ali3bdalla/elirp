<template>
  <div>
    <div class="card-header">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <!-- <el-radio-group v-model="enabledStatus">
            <el-radio-button :label="1">All ({{totalitems}})</el-radio-button>
            <el-radio-button :label="2">Active ({{totalActiveitems}})</el-radio-button>
            <el-radio-button :label="3">In Active ({{totalInActiveitems}})</el-radio-button>
          </el-radio-group> -->
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
      @pageChanged="pageChanged"
      :loading="loading"
      :items="items"
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
          width="200"
          label="Name"
          props="name"
        >
          <template v-slot:default="{ item }">
            <div class="d-flex p-2 bd-highlight justify-items-center
            align-self-center
             justify-content-start">
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
          label="Phone"
          props="phone"
        >
          <template v-slot:default="{ item }">
            {{ item.phone }}
          </template>
        </data-grid-column>

        <data-grid-column
          label="Address"
          props="address"
        >
          <template v-slot:default="{ item }">
            {{ item.address }}
          </template>
        </data-grid-column>
        <data-grid-column
          label="reference"
          props="reference"
        >
          <template v-slot:default="{ item }">
            {{ item.reference }}
          </template>
        </data-grid-column>
        <data-grid-column
          label="Tax Number"
          props="tax_number"
        >
          <template v-slot:default="{ item }">
            {{ item.tax_number }}
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

                  <inertia-link :href="`${url}/${item.id}/edit`">
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
import { ref } from "vue";
export default {
  name: "ContactTable",
  components: { DataGridColumn, PrimaryButton, DataGridFrame },
  props: {
    url: {
      default: "",
      type: String,
    },
    isVendor: {
      default: "",
      type: String,
    },
    isCustomer: {
      default: "",
      type: String,
    },
  },
  setup(props) {
    console.log(props);
    const page = ref(1);
    const searching = ref("");
    const { result, loading } = useQuery(
      gql`
        query getContacts(
          $page: Int!
          $search: String!
          $isVendor: String
          $isCustomer: String
        ) {
          getContacts(
            page: $page
            search: $search
            is_vendor: $isVendor
            is_customer: $isCustomer
          ) {
            data {
              id
              name
              email
              tax_number
              phone
              address
              reference
            }
            paginatorInfo {
              count
              perPage
              currentPage
              total
            }
          }
        }
      `,
      {
        page: page,
        search: searching,
        isVendor: props.isVendor,
        isCustomer: props.isCustomer,
      }
    );
    const items = useResult(result, [], (data) => data.getContacts.data);

    const paginatorInfo = useResult(
      result,
      {},
      (data) => data.getContacts.paginatorInfo
    );

    function pageChanged(currentPage) {
      page.value = currentPage;
    }

    return {
      searching,
      pageChanged,
      items,
      paginatorInfo,
      loading,
    };
  },
};
</script>
