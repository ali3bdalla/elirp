<template>
  <div>
    <div class="card-header">
      <i class="fa fa-plus-circle"></i> Item Information
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="name"><i class="fab fa-product-hunt"></i> name</label>
            <input
              type="text"
              class="form-control"
              :class="{'is-invalid': $page.props.errors.name}"
              placeholder="name"
              v-model="value.name"
            />
            <error-message-utility :error="$page.props.errors.name"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="sku"><i class="fas fa-barcode"></i> sku</label>
            <input
              class="form-control w-100"
              :class="{'is-invalid': $page.props.errors.sku}"
              type="text"
              v-model="value.sku"
              placeholder="sku"
            />
            <error-message-utility :error="$page.props.errors.sku"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="model_number"><i class="fas fa-random"></i> Model Number</label>
            <input
              type="model_number"
              :class="{'is-invalid': $page.props.errors.model_number}"
              class="form-control"
              v-model="value.model_number"
              placeholder="Model Number"
            />
            <error-message-utility :error="$page.props.errors.model_number"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="model_name"><i class="fab fa-bandcamp"></i> Model Name</label>
            <input
              type="text"
              :class="{'is-invalid': $page.props.errors.model_name}"
              class="form-control"
              v-model="value.model_name"
              placeholder="Model Name"
            />
            <error-message-utility :error="$page.props.errors.model_name"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="brand"><i class="fas fa-code-branch"></i> Brand</label>
            <input
              type="text"
              :class="{'is-invalid': $page.props.errors.brand}"
              class="form-control"
              v-model="value.brand"
              placeholder="Brand"
            />
            <error-message-utility :error="$page.props.errors.brand"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="sale_price"><i class="fas fa-money-bill"></i> Sale Price</label>
            <input
              type="number"
              :class="{'is-invalid': $page.props.errors.sale_price}"
              class="form-control"
              v-model="value.sale_price"
              placeholder="Sale Price"
            />
            <error-message-utility :error="$page.props.errors.sale_price"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="purchase_price"><i class="fas fa-money-bill-wave"></i> Purchase Price</label>
            <input
              type="number"
              :class="{'is-invalid': $page.props.errors.purchase_price}"
              class="form-control"
              v-model="value.purchase_price"
              placeholder="Purchase Price"
            />
            <error-message-utility :error="$page.props.errors.purchase_price"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="sale_price"><i class="fas fa-audio-description"></i> Description</label>
            <textarea
              type="text"
              :class="{'is-invalid': $page.props.errors.description}"
              class="form-control"
              v-model="value.description"
              placeholder="Description"
            ></textarea>
            <error-message-utility :error="$page.props.errors.description"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="tags"><i class="fas fa-tags"></i> Tags</label>
            <textarea
              :class="{'is-invalid': $page.props.errors.tags}"
              class="form-control"
              v-model="value.tags"
              placeholder="Tags"
            ></textarea>
            <error-message-utility :error="$page.props.errors.tags"></error-message-utility>
          </div>
        </div>

      </div>
    </div>
    <div class="card-footer">
      <slot name="form-footer">
      </slot>
    </div>
  </div>
</template>

<script>
import ErrorMessageUtility from "./../../Components/Utility/ErrorMessageUtility";
export default {
  components: {
    ErrorMessageUtility,
  },
  name: "ItemForm",
  props: {
    value: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
</style>
