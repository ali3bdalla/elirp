<template>
  <div>
    <table class="table table-striped table-bordered text-center ">
      <thead class="bg-primary text-white">
        <tr>
          <th scope="col">{{ $page.props.locale.inventory.sku }}</th>
          <th scope="col">{{ $page.props.locale.inventory.item }}</th>
          <th scope="col">{{ $page.props.locale.invoicing.price }}</th>
          <th scope="col">{{ $page.props.locale.invoicing.quantity }}</th>
          <th scope="col">{{ $page.props.locale.invoicing.total }}</th>
          <th scope="col">{{ $page.props.locale.invoicing.discount }}</th>
          <th scope="col">{{ $page.props.locale.invoicing.subtotal }}</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item,index) in documentItems"
          :key="index"
        >
          <td>
            <span v-if="show">
              {{ item.sku }}
            </span>
            <span v-else>
              {{ item.item.sku }}
            </span>
          </td>
          <td>
            <span v-if="show">
              {{ item.name }}
            </span>
            <span v-else>
              {{ item.item.name }}
            </span>
          </td>
          <td>
            <div class="form-group">
              <input
                :disabled="show"
                @change="updateTotal(item,index)"
                type="text"
                :class="{'is-invalid': $page.props.errors[`items.${index}.price`]}"
                class="form-control"
                v-model="item.price"
                :placeholder="$page.props.locale.invoicing.price"
              />
              <error-message-utility :error="$page.props.errors[`items.${index}.price`]"></error-message-utility>
            </div>
          </td>
          <td>
            <input
              :disabled="show"
              type="text"
              @change="updateTotal(item,index)"
              :class="{'is-invalid': $page.props.errors[`items.${index}.quantity`]}"
              class="form-control"
              v-model="item.quantity"
              :placeholder="$page.props.locale.invoicing.quantity"
            />
            <error-message-utility :error="$page.props.errors[`items.${index}.quantity`]"></error-message-utility>
          </td>
          <td>
            <input
              type="text"
              :disabled="true"
              :class="{'is-invalid': $page.props.errors[`items.${index}.total`]}"
              class="form-control"
              v-model="item.total"
              :placeholder="$page.props.locale.invoicing.total"
            />
            <error-message-utility :error="$page.props.errors[`items.${index}.total`]"></error-message-utility>
          </td>
          <td>
            <input
              :disabled="show"
              type="text"
              @change="updateSubtotal(item,index)"
              :class="{'is-invalid': $page.props.errors[`items.${index}.discount`]}"
              class="form-control"
              v-model="item.discount"
              :placeholder="$page.props.locale.invoicing.discount"
            />
            <error-message-utility :error="$page.props.errors[`items.${index}.discount`]"></error-message-utility>
          </td>
          <td>
            <input
              :disabled="true"
              type="text"
              :class="{'is-invalid': $page.props.errors[`items.${index}.subtotal`]}"
              class="form-control"
              v-model="item.subtotal"
              placeholder="subtotal"
            />
            <error-message-utility :error="$page.props.errors[`items.${index}.subtotal`]"></error-message-utility>
          </td>

        </tr>
        <tr v-if="!show">
          <td colspan="6">
            <el-select
              ref="addDocumentItemSelect"
              @change="itemSelected"
              v-model="selectedItem"
              filterable
              :remote="true"
              :remoteMethod="filterItems"
              class="form-control"
              popper-class="shadow"
              :placeholder="$page.props.locale.inventory.item"
            >
              <el-option
                v-for="item in items"
                :key="item.id"
                :label="`${item.name} - ${item.sku} - ${item.model_number}`"
                :value="item.id"
              >
                <div>
                  <span style="float: left">{{ item.name }}</span>
                  <span style="float: right; color: #8492a6; font-size: 15px">{{ item.sku }} - {{ item.phone }} - {{item.model_number}}</span>
                </div>
              </el-option>
            </el-select>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import ErrorMessageUtility from "./../../Components/Utility/ErrorMessageUtility";
import { useQuery, useResult } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { ref, watch } from "vue";
export default {
  components: {
    ErrorMessageUtility,
  },
  name: "DocumentFormItems",
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    type: {
      type: String,
      required: true,
    },
    items: {
      type: [Array, null],
      default: () => [],
    },
  },
  setup(props, context) {
    const itemSearch = ref("");
    const selectedItem = ref(null);
    const addDocumentItemSelect = ref(null);
    const documentItems = ref(props.items);
    const { result, loading } = useQuery(
      gql`
        query documentFormItems($itemSearch: String) {
          getItems(page: 1, search: $itemSearch) {
            data {
              id
              name
              sku
              purchase_price
              sale_price
              model_number
              model_name
            }
          }
        }
      `,
      {
        itemSearch: itemSearch,
      }
    );

    watch(documentItems, function (value) {
      context.emit("input", value);
    });
    function filterItems(e) {
      itemSearch.value = e;
    }
    function itemSelected(itemId) {
      const item = items.value.find((p) => p.id === itemId);
      const isExists = documentItems.value.find((p) => p.item_id === itemId);
      if (!isExists && item) {
        let price = parseFloat(item.purchase_price).toFixed(2);
        if (props.type == "INVOICE")
          price = parseFloat(item.sale_price).toFixed(2);

        documentItems.value.push({
          quantity: 1,
          name: item.name,
          discount: 0,
          total: price,
          subtotal: price,
          price: price,
          item_id: item.id,
          item: item,
        });
      }

      selectedItem.value = null;
      addDocumentItemSelect.value.focus();
    }
    const items = useResult(result, [], (data) => data.getItems.data);
    function updateTotal(documentItem, index) {
      const total =
        parseFloat(documentItem.quantity) * parseFloat(documentItem.price);
      documentItem.total = parseFloat(total).toFixed(2);
      updateSubtotal(documentItem, index);
    }

    function updateSubtotal(documentItem, index) {
      const subtotal =
        parseFloat(documentItem.total) - parseFloat(documentItem.discount);
      documentItem.subtotal = parseFloat(subtotal).toFixed(2);
      documentItems.value[index] = documentItem;
    }

    return {
      addDocumentItemSelect,
      updateTotal,
      updateSubtotal,
      items,
      documentItems,
      itemSelected,
      filterItems,
      selectedItem,
    };
  },
};
</script>

<style scoped>
.form-control {
  text-align: center;
}
</style>
