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
          label="SKU"
          props="sku"
        >
          <template v-slot:default="{ item }">
            {{ item.sku }}
          </template>
        </data-grid-column>
        <data-grid-column
          label="Brand"
          props="brand"
        >
          <template v-slot:default="{ item }">
            {{ item.brand }}
          </template>
        </data-grid-column>

        <data-grid-column
          label="Model Name"
          props="model_name"
        >
          <template v-slot:default="{ item }">
            {{ item.model_name }}
          </template>
        </data-grid-column>
        <data-grid-column
          label="Model Number"
          props="model_number"
        >
          <template v-slot:default="{ item }">
            {{ item.model_number }}
          </template>
        </data-grid-column>
        <data-grid-column
          width="150"
          label="P.Price"
          props="purchase_price"
        >
          <template v-slot:default="{ item }">
            {{ item.purchase_price }}
          </template>
        </data-grid-column>
        <data-grid-column
          width="150"
          label="S.Price"
          props="sale_price"
        >
          <template v-slot:default="{ item }">
            {{ item.sale_price }}
          </template>
        </data-grid-column>
        <!-- <data-grid-column label="details">
          <template v-slot:default="{ item }">

            <div class="d-flex justify-items-between justify-content-between">

              <el-tag
                type="default"
                v-if="item.is_service"
              >
                Service
              </el-tag>
              <el-tag
                type="warrning"
                v-if="item.has_detail"
              >
                Has Detail
              </el-tag>
              <el-tag
                effect="dark"
                type="info"
                v-if="item.fixed_price"
              >
                Fixed Price
              </el-tag>

            </div>

          </template>
        </data-grid-column> -->

        <data-grid-column label="Option">
          <template v-slot:default="{ item }">
            <el-dropdown>
              <button class="btn btn-primary btn-sm">
                Manage
              </button>
              <template #dropdown>
                <el-dropdown-menu>

                  <inertia-link :href="route('items.edit',`${item.id}`)">
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
  name: "ItemTable",
  components: { DataGridColumn, PrimaryButton, DataGridFrame },
  setup() {
    const page = ref(1);
    const searching = ref("");
    const { result, loading } = useQuery(
      gql`
        query getItems($page: Int!, $search: String!) {
          getItems(page: $page, search: $search) {
            data {
              id
              sku
              purchase_price
              sale_price
              name
              model_number
              model_name
              brand
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
      }
    );
    const items = useResult(result, [], (data) => data.getItems.data);

    const paginatorInfo = useResult(
      result,
      {},
      (data) => data.getItems.paginatorInfo
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
