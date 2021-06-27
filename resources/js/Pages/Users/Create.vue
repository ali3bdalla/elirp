<template>
  <app-layout>
    <div class='card border-left-primary shadow h-100'>
      <div class="card-header">
        <i class="fa fa-plus-circle"></i> Create New User
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
              <label for="username"><i class="fa fa-user"></i> Username</label>
              <input
                type="text"
                class="form-control border"
                :class="{'is-invalid': $page.props.errors.name}"
                placeholder="Username"
                v-model="form.name"
              />
              <error-message-utility :error="$page.props.errors.name"></error-message-utility>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
              <label for="email"><i class="fa fa-at"></i> E-mail Address</label>
              <input
                class="form-control w-100"
                :class="{'is-invalid': $page.props.errors.email}"
                type="email"
                v-model="form.email"
                placeholder="E-mail Address"
              />
              <error-message-utility :error="$page.props.errors.email"></error-message-utility>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
              <label for="password"><i class="fa fa-lock"></i> Password</label>
              <input
                type="password"
                :class="{'is-invalid': $page.props.errors.password}"
                class="form-control"
                v-model="form.password"
                placeholder="Password"
              />
              <error-message-utility :error="$page.props.errors.password"></error-message-utility>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button
          class="btn btn-primary"
          @click="saveUser(context,form)"
        >Save</button>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { useMutation } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { saveUser } from "../../Api/users";
import { computed, watch, ref } from "vue";
import ErrorMessageUtility from "./../../Components/Utility/ErrorMessageUtility";
export default {
  components: {
    AppLayout,
    ErrorMessageUtility,
  },
  name: "Create",
  setup(_, context) {
    const err = ref({});
    const form = ref({ email: null, password: null, name: null });
    const errors = computed(function () {
      return err.value;
    });

    return {
      context,
      form,
      saveUser: saveUser,
      errors,
    };
  },
};
</script>

<style>
</style>
