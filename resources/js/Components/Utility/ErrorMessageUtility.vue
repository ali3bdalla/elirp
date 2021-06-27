<template>
  <div
    class="text-danger"
    v-if="error"
  >
    {{  error }}
  </div>
</template>

<script>
export default {
  name: "ErrorMessageUtility",
  props: {
    error: {
      type: [String, undefined, null],
      default: () => null,
    },
  },
};
</script>

<style>
</style>
