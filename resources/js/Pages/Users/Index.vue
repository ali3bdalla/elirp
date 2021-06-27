<template>
  <app-layout>
    <template #title>
      Users List
    </template>
    <template #actions>
      <inertia-link
        :href="route('users.create')"
        class='btn btn-success'
      >
        Create User
      </inertia-link>
    </template>

    <user-table></user-table>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import UserTable from "../../Components/User/UserTable";
export default {
  name: "Index",
  components: { AppLayout, UserTable },
};
</script>

<style scoped>
</style>
