<template>
 <div class="ml-1 mb-1">
  <h6 class="grey--text text--darken-1">
   {{ label | uppercase }}
  </h6>
 </div>
</template>

<script>
export default {
 name: "DefaultSnackbar",
 props: ["label"],
 filters: {
  uppercase: function(value) {
   if (!value) return "";
   value = value.toString();
   return value.toUpperCase();
  }
 }
};
</script>
