<template>
  <app-layout>
    <template #title>
      Update User
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
          @click="updateUser(form,userId,onSuccess)"
        >Update</button>
      </template>
    </user-form>

  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { useMutation } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { updateUser } from "../../Api/users";
import { computed, watch, ref } from "vue";

import { Inertia } from "@inertiajs/inertia";
import UserForm from "../../Components/User/UserForm.vue";
export default {
  props: {
    user: {
      required: true,
      type: Object,
    },
  },
  components: {
    AppLayout,
    UserForm,
  },
  name: "Edit",
  setup(props, context) {
    const err = ref({});
    const form = ref({
      email: props.user.email,
      password: null,
      password_confirmation: null,
      name: props.user.name,
    });
    const errors = computed(function () {
      return err.value;
    });
    function onSuccess() {
      Inertia.visit(route("users.index"));
    }
    return {
      userId: props.user.id,
      context,
      form,
      onSuccess,
      updateUser: updateUser,
      errors,
    };
  },
};
</script>

<style>
</style>
