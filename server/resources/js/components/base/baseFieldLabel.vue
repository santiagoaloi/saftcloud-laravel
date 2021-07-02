<template>
 <div class="ml-1 mb-1">
  <b class="grey--text text--darken-1"> {{ label | uppercase }}</b>
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
