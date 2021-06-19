<template>
  <el-dialog
      :model-value="show"
      custom-class="shadow"
      title="Tips"
      width="30%">
    <span>This is a message</span>
    <template #footer>
    <span class="dialog-footer">
          <el-button @click="show = false">Cancel</el-button>
            <el-button type="primary" @click="show = false">Confirm</el-button>
    </span>
    </template>
  </el-dialog>
</template>

<script>
export default {
  name: "FormLayout"
}
</script>

<style scoped>

</style>
