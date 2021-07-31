<template>
 <div class="ml-1 mb-1">
  <div class="d-flex grey--text text--darken-1 label-text">
   {{ label | uppercase }}
   <div v-if="required" class="ml-1 pink--text text--accent-2">▪</div>
  </div>
 </div>
</template>

<script>
export default {
 name: "DefaultSnackbar",
 props: {
  label: {
   type: String,
   default: ""
  },
  required: {
   type: Boolean,
   default: false
  }
 },
 filters: {
  uppercase: function(value) {
   if (!value) return "";
   value = value.toString();
   return value.toUpperCase();
  }
 }
};
</script>
<style scoped>
.label-text {
 font-size: 12px;
}
</style>
