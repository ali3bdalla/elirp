<template>
  <app-layout>
    <user-table></user-table>
  </app-layout> 
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import UserTable from "../../Components/User/UserTable";
export default {
  name: "Index",
  components: {AppLayout,UserTable}
}
</script>

<style scoped>

</style>
