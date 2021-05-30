<template>
  <v-main>
    <v-container fluid>
      <router-view />
    </v-container>
  </v-main>
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
