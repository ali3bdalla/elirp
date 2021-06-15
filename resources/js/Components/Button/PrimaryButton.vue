<template>
    <el-button type="primary" v-bind="$props">
        <slot></slot>
    </el-button>
</template>

<script>
export default {
    name: "PrimaryButton",
};
</script>

<style scoped lang="scss">
.el-button--primary {
    background: red !important;
    border-color: red;
}
</style>
