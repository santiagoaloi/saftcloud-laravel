<template>
  <v-img
    max-height="100vh"
    src="storage/defaultbg.jpg"
    gradient="to top right, rgba(200,200,200,.33), rgba(25,32,72,.7)"
  >
    <v-main>
      <router-view />
    </v-main>
  </v-img>
</template>

<script>
import { store } from "@/store";

export default {
  name: "Secureview",
  data() {
    return {};
  },
  computed: {
    // profileBackground() {
    //   if (this.imageLoadingFailed) {
    //     return this.defaultBackground;
    //   } else {
    //     return `${store.state.sessionData.userProfile.background}`;
    //   }
    // }
  }
};
</script>
