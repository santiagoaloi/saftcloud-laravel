<template>
 <div>
  <v-app-bar color="transparent" absolute app flat height="80">
   <v-container style="background-color:transparent" class="py-0 px-0 px-sm-2 fill-height">
    <div
     data-aos="fade"
     data-aos-anchor-placement="center-bottom"
     data-aos-delay="300"
     data-aos-once="true"
     data-aos-easing="linear"
     data-aos-duration="400"
    >
     <router-link to="/" class="d-flex align-center text-decoration-none">
      <img class="mr-4" src="storage/logo2.png" height="40" />
      <span class="font-weight-black headline white--text"> SaftCloud</span>
     </router-link>
    </div>

    <v-spacer></v-spacer>

    <v-btn rounded to="/" height="36" class="mr-3" color="primary" dark><v-icon left> mdi-home</v-icon>Back to homepage</v-btn>

    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on, attrs }">
      <v-btn v-on="on" @click="isDark = !isDark" fab class="mr-3" color="white" text dark small plain>
       <v-icon v-if="isDark">mdi-lightbulb-on-outline</v-icon>
       <v-icon v-else>mdi-lightbulb-outline</v-icon></v-btn
      >
     </template>
     <span> {{ isDark ? " Light mode" : "Dark mode" }}</span>
    </v-tooltip>
   </v-container>
  </v-app-bar>
 </div>
</template>

<script>
import { sync, get, call } from "vuex-pathify";

export default {
 name: "PublicAppbar",

 data() {
  return {};
 },

 computed: {
  ...sync("theme", ["isDark"])
 }
};
</script>

<style scoped lang="scss">
::v-deep [data-v-46ca8032] .v-toolbar__content,
.v-toolbar__extension[data-v-46ca8032] {
 border-bottom: 0px solid #ccc;
}
</style>
