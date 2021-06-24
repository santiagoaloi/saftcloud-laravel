<template>
 <v-sheet class="rightPanelHeight transparent"> hello </v-sheet>
</template>

<script>
import axios from "axios";

import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsBasic",

 data: () => ({}),

 computed: {
  ...sync("theme", ["isDark"]),
  ...get("componentManagement", ["selectedComponent"])
 }
};
</script>
<style scoped>
.rightPanelHeight {
 height: calc(100vh - 165px);
 overflow-y: auto;
}
</style>
