<template>
 <base-dialog title="Your session has expired" noMaximize dense width="600" noActions v-model="dialogTImeoutWarning">
  <v-card class="mx-auto" width="300"> hello </v-card>
 </base-dialog>
</template>
<script>
import { store } from "@/store";
import { sync, get } from "vuex-pathify";
export default {
 name: "DialogSessionTimeoutWarning",

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("authentication", ["dialogTImeoutWarning"])
 }
};
</script>
