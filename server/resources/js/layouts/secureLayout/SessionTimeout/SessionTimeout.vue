<template>
 <v-idle style="display:none" @idle="onidle" :loop="false" :duration="9999" />
</template>

<script>
import Vue from "vue";
import router from "@/router";
import { store } from "@/store";
import { sync } from "vuex-pathify";

export default {
 name: "SessionTimeout",

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("authentication", ["hasSessionExpired"])
 },

 methods: {
  onidle(time) {
   router.push("/login");
   this.hasSessionExpired = true;
   store.set("authentication/session", {});
  }
 }
};
</script>
