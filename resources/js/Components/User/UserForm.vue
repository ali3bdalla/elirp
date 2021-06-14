<template>
  <el-dialog
      title="Tips"
      :model-value="show"
      :custom-class="shadow"
      width="30%">
    <span>This is a message</span>
    <template #footer>
    <span class="dialog-footer">
<!--      <el-button @click="dialogVisible = false">Cancel</el-button>-->
<!--      <el-button type="primary" @click="dialogVisible = false">Confirm</el-button>-->
    </span>
    </template>
  </el-dialog>
</template>

<script>
export default {
  name: "UserForm",
  props: {
    show: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<style scoped>

</style>
