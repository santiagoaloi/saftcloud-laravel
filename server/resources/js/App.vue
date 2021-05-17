<template>
  <v-fade-transition mode="out-in">
    <component :is="layout"> </component>
  </v-fade-transition>
</template>

<script>
import config from "./configs";
import { store } from "@/store";
import { get } from "vuex-pathify";

import axios from "axios";

export default {
  name: "AppVue",

  data() {
    return {};
  },

  computed: {
    layout() {
      return this.$route.meta.layout;
    }
  },

  head: {
    link: [
      // adds config/icons into the html head tag
      ...config.icons.map(href => ({ rel: "stylesheet", href }))
    ]
  },

  created() {
    window.getApp = this;
  },

  methods: {}
};
</script>
