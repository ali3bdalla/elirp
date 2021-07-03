<template>
  <div>
    <div class="card-header">
      <i class="fa fa-plus-circle"></i> {{ $page.props.locale.inventory.item }}
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="name"><i class="fab fa-product-hunt"></i> {{ $page.props.locale.app.name }}</label>
            <input
              type="text"
              class="form-control"
              :class="{'is-invalid': $page.props.errors.name}"
              :placeholder="$page.props.locale.app.name"
              v-model="value.name"
            />
            <error-message-utility :error="$page.props.errors.name"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="sku"><i class="fas fa-barcode"></i> {{$page.props.locale.inventory.sku}}</label>
            <input
              class="form-control w-100"
              :class="{'is-invalid': $page.props.errors.sku}"
              type="text"
              v-model="value.sku"
              :placeholder="$page.props.locale.inventory.sku"
            />
            <error-message-utility :error="$page.props.errors.sku"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="model_number"><i class="fas fa-random"></i> {{$page.props.locale.inventory.model_number}}</label>
            <input
              type="model_number"
              :class="{'is-invalid': $page.props.errors.model_number}"
              class="form-control"
              v-model="value.model_number"
              :placeholder="$page.props.locale.inventory.model_number"
            />
            <error-message-utility :error="$page.props.errors.model_number"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="model_name"><i class="fab fa-bandcamp"></i>{{$page.props.locale.inventory.model_name}}</label>
            <input
              type="text"
              :class="{'is-invalid': $page.props.errors.model_name}"
              class="form-control"
              v-model="value.model_name"
              :placeholder="$page.props.locale.inventory.model_name"
            />
            <error-message-utility :error="$page.props.errors.model_name"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="brand"><i class="fas fa-code-branch"></i> {{$page.props.locale.inventory.brand}}</label>
            <input
              type="text"
              :class="{'is-invalid': $page.props.errors.brand}"
              class="form-control"
              v-model="value.brand"
              :placeholder="$page.props.locale.inventory.brand"
            />
            <error-message-utility :error="$page.props.errors.brand"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="sale_price"><i class="fas fa-money-bill"></i> {{$page.props.locale.inventory.sale_price}}</label>
            <input
              type="number"
              :class="{'is-invalid': $page.props.errors.sale_price}"
              class="form-control"
              v-model="value.sale_price"
              :placeholder="$page.props.locale.inventory.sale_price"
            />
            <error-message-utility :error="$page.props.errors.sale_price"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="purchase_price"><i class="fas fa-money-bill-wave"></i>{{ $page.props.locale.inventory.purchase_price }}</label>
            <input
              type="number"
              :class="{'is-invalid': $page.props.errors.purchase_price}"
              class="form-control"
              v-model="value.purchase_price"
              :placeholder="$page.props.locale.inventory.purchase_price"
            />
            <error-message-utility :error="$page.props.errors.purchase_price"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="sale_price"><i class="fas fa-audio-description"></i> {{$page.props.locale.inventory.description}}</label>
            <textarea
              type="text"
              :class="{'is-invalid': $page.props.errors.description}"
              class="form-control"
              v-model="value.description"
              :placeholder="$page.props.locale.inventory.description"
            ></textarea>
            <error-message-utility :error="$page.props.errors.description"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="tags"><i class="fas fa-tags"></i> {{$page.props.locale.inventory.tags}}</label>
            <textarea
              :class="{'is-invalid': $page.props.errors.tags}"
              class="form-control"
              v-model="value.tags"
              :placeholder="$page.props.locale.inventory.tags"
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
