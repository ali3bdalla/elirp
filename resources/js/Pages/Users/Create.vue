<template>
  <app-layout>
    <template #title>
      Create User
    </template>
    <template #actions>
      <inertia-link
        :href="route('users.index')"
        class="btn btn-default"
      >
        Users
      </inertia-link>
    </template>
    <user-form
      v-model="form"
      :value='form'
    >
      <template #form-footer>
        <button
          class="btn btn-primary"
          @click="saveUser(form,onSuccess)"
        >Save</button>
      </template>
    </user-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { useMutation } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { saveUser } from "../../Api/users";
import { computed, watch, ref } from "vue";

import { Inertia } from "@inertiajs/inertia";
import UserForm from "../../Components/User/UserForm.vue";
export default {
  components: {
    AppLayout,
    UserForm,
  },
  name: "Create",
  setup(_, context) {
    const err = ref({});
    const form = ref({
      email: null,
      password: null,
      password_confirmation: null,
      name: null,
    });
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess() {
      Inertia.visit(route("users.index"));
    }
    return {
      context,
      form,
      onSuccess,
      saveUser: saveUser,
      errors,
    };
  },
};
</script>

<style>
</style>
