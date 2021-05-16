<template>
  <v-main>
    <v-img
      style="margin-top:-80px;"
      height="100vh"
      src="storage/11.png"
      gradient="to top right, rgba(0,0,0,.1), rgba(0,0,0,.5)"
    >
      <router-view />
    </v-img>
  </v-main>
</template>

<script>
import globalMixin from "@/mixins/globalMixin";

export default {
  name: "Loginview",
  mixins: [globalMixin],
  computed: {
    loginBackground() {
      return {
        "background-image": `url(storage/11.png)`,
        "background-repeat": "no-repeat",
        "background-size": "cover",
        "background-attachment": "fixed"
      };
    }
  }
};
</script>
