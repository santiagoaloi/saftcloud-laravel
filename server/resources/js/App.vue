<template>
  <v-fade-transition mode="out-in">
    <!-- <keep-alive> -->
    <component :is="layout"> </component>
    <!-- </keep-alive> -->
  </v-fade-transition>
</template>

<script>
import config from "./configs";

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
