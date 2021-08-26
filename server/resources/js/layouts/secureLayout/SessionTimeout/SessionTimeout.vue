<template>
 <v-idle style="display:none" @idle="onidle" :loop="false" :duration="300" />
</template>

<script>
import Vue from "vue";
import router from "@/router";
import { store } from "@/store";
import { sync, get, call } from "vuex-pathify";

export default {
 name: "SessionTimeout",

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("authentication", ["hasSessionExpired"])
 },

 methods: {
  onidle(time) {
   router.push("/login");
   store.set("authentication/session", {});
   this.hasSessionExpired = true;
  }
 }
};
</script>
