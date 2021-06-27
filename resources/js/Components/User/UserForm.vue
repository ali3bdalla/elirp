<template>
  <div class='card border-left-primary shadow h-100'>
    <div class="card-header">
      <i class="fa fa-plus-circle"></i> User Information
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="username"><i class="fa fa-user"></i> Username</label>
            <input
              type="text"
              class="form-control"
              :class="{'is-invalid': $page.props.errors.name}"
              placeholder="Username"
              v-model="value.name"
            />
            <error-message-utility :error="$page.props.errors.name"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="email"><i class="fa fa-at"></i> E-mail Address</label>
            <input
              class="form-control w-100"
              :class="{'is-invalid': $page.props.errors.email}"
              type="email"
              v-model="value.email"
              placeholder="E-mail Address"
            />
            <error-message-utility :error="$page.props.errors.email"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="password"><i class="fa fa-lock"></i> Password</label>
            <input
              type="password"
              :class="{'is-invalid': $page.props.errors.password}"
              class="form-control"
              v-model="value.password"
              placeholder="Password"
            />
            <error-message-utility :error="$page.props.errors.password"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="password"><i class="fa fa-lock"></i> Password Confirmation</label>
            <input
              type="password"
              :class="{'is-invalid': $page.props.errors.password_confirmation}"
              class="form-control"
              v-model="value.password_confirmation"
              placeholder="Password Confirmation"
            />
            <error-message-utility :error="$page.props.errors.password_confirmation"></error-message-utility>
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
  name: "UserForm",
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
