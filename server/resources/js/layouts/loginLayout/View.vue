<template>
 <v-main>
  <v-img style="margin-top:-80px;" :aspectRatio="3" gradient="to top right, rgba(0,0,0,.1), rgba(0,0,0,.2)" min-height="100vh" src="storage/11.png">
   <v-container fill-height>
    <router-view />
   </v-container>
  </v-img>
 </v-main>
</template>

<script>
export default {
 name: "Loginview"
};
</script>
