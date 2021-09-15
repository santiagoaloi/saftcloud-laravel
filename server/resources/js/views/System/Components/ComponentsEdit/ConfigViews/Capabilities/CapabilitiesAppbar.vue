<template>
 <div>
  <div class="d-flex justify-end align-center">
   <div class="d-flex">
    <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click.stop="dialogCapability = true">
     <v-icon class="mr-2" small> mdi-plus </v-icon>Add capability
    </v-btn>
   </div>
  </div>
  <v-divider class="mt-3"></v-divider>
 </div>
</template>

<script>
import { sync, call } from "vuex-pathify";
export default {
 name: "CapabilityAppbar",

 methods: {
  ...call("componentManagement/*")
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["dialogCapability"])
 }
};
</script>
