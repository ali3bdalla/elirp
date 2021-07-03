<template>
  <div>
    <div class="card-header">
      <i class="fa fa-plus-circle"></i> {{  $page.props.locale.invoicing[`${title}`] }}
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="name"><i class="fab fa-product-hunt"></i> {{  $page.props.locale.app.name }}</label>
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
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="email"><i class="fas fa-mail"></i>{{$page.props.locale.app.email }}</label>
            <input
              class="form-control w-100"
              :class="{'is-invalid': $page.props.errors.email}"
              type="email"
              v-model="value.email"
              :placeholder="$page.props.locale.app.email"
            />
            <error-message-utility :error="$page.props.errors.email"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="reference"><i class="fab fa-product-hunt"></i> {{ $page.props.locale.invoicing.reference }}</label>
            <input
              type="text"
              class="form-control"
              :class="{'is-invalid': $page.props.errors.reference}"
              :placeholder="$page.props.locale.invoicing.reference"
              v-model="value.reference"
            />
            <error-message-utility :error="$page.props.errors.reference"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="phone"><i class="fas fa-phone"></i> {{$page.props.locale.app.phone}}</label>
            <input
              type="model_number"
              :class="{'is-invalid': $page.props.errors.phone}"
              class="form-control"
              v-model="value.phone"
              :placeholder="$page.props.locale.app.phone"
            />
            <error-message-utility :error="$page.props.errors.phone"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="website"><i class="fab fa-edit"></i> {{$page.props.locale.invoicing.website}}</label>
            <input
              type="url"
              :class="{'is-invalid': $page.props.errors.website}"
              class="form-control"
              v-model="value.website"
              :placeholder="$page.props.locale.invoicing.website"
            />
            <error-message-utility :error="$page.props.errors.website"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="form-group">
            <label for="tax_number"><i class="fas fa-tag"></i> {{$page.props.locale.invoicing.tax_number}}</label>
            <input
              type="text"
              :class="{'is-invalid': $page.props.errors.tax_number}"
              class="form-control"
              v-model="value.tax_number"
              :placeholder="$page.props.locale.invoicing.tax_number"
            />
            <error-message-utility :error="$page.props.errors.tax_number"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-12 col-sm-12">
          <div class="form-group">
            <label for="address"><i class="fas fa-audio-description"></i> {{$page.props.locale.invoicing.address}}</label>
            <textarea
              type="text"
              :class="{'is-invalid': $page.props.errors.address}"
              class="form-control"
              v-model="value.address"
              :placeholder="$page.props.locale.invoicing.address"
            ></textarea>
            <error-message-utility :error="$page.props.errors.address"></error-message-utility>
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
  name: "ContactForm",
  props: {
    title: {
      type: String,
      default: "",
    },
    value: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
</style>
