<template>
  <v-fade-transition hide-on-leave>
    <component :is="layout"> </component>
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
<style>
.v-toolbar__content,
.v-toolbar__extension {
  padding: 0px 0px !important;
}
</style>
