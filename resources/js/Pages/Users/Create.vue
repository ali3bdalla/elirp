<template>
  <app-layout>
    <div class='card border-left-primary shadow h-100'>
      <div class="card-header">
        Create New User
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
              <label for="username">Username</label>
              <input
                type="text"
                class="form-control"
                placeholder="Username"
                v-model="form.username"
              />
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
              <label for="email">E-mail Address</label>
              <input
                class="form-control w-100"
                type="email"
                v-model="form.email_address"
                placeholder="E-mail Address"
              />
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
              <label for="password">Password</label>
              <input
                type="password"
                class="form-control"
                v-model="form.password"
                placeholder="Password"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button
          class="btn btn-primary"
          @click="saveUser"
        >Save</button>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { useMutation } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { computed, watch, ref } from "vue";
export default {
  components: {
    AppLayout,
  },
  name: "Create",
  setup() {
    const err = ref({});
    const form = ref({ email_address: null, password: null, username: null });
    function saveUser() {
      const addUser = gql`
        mutation  {
          addUser(username: ${form.value.username},password: ${form.value.password},email: ${form.value.email_address}) {
            id
          }
        }
      `;
      console.log(addUser);
    }
    const errors = computed(function () {
      return err.value;
    });
    return {
      form,
      saveUser,
      errors,
    };
  },
};
</script>

<style>
</style>
