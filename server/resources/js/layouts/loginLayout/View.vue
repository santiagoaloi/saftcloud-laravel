<template>
  <v-main :style="loginBackground">
    <router-view />
  </v-main>
</template>

<script>
import globalMixin from "@/mixins/globalMixin";

export default {
  name: "Loginview",
  mixins: [globalMixin],

  computed: {
    viewHeight() {
      return this.screenHeight - this.$vuetify.application.top * 2;
    },

    loginBackground() {
      return {
        "background-image": `linear-gradient(rgba(100, 100, 100, 0.5),rgba(0, 0, 0, 0.8)), url(storage/login.jpg)`,
        "background-repeat": "no-repeat",
        "background-size": "cover",
        "background-attachment": "fixed"
      };
    }
  }
};
</script>
