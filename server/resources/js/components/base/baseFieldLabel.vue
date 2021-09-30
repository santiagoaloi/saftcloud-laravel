<template>
  <div class="ml-1 mb-1">
    <div class="d-flex grey--text text--darken-1 font-weight-bold label-text">
      <span :class="`${color}--text`"> {{ lowerCase ? labelLowercase : labelUppercase }} </span>
      <div v-if="required" class="ml-1 pink--text text--accent-2">▪</div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'DefaultSnackbar',
    props: {
      label: {
        type: String,
        default: '',
      },
      required: {
        type: Boolean,
        default: false,
      },
      color: {
        type: String,
        default: null,
      },
      lowerCase: {
        type: Boolean,
        default: false,
      },
    },
    computed: {
      labelLowercase() {
        const value = this.label.toString();
        return value.toLowerCase();
      },
      labelUppercase() {
        const value = this.label.toString();
        return value.toUpperCase();
      },
    },
  };
</script>
<style scoped>
  .label-text {
    font-size: 12px;
  }
</style>
