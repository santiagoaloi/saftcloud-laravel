<template>
  <v-main>
    <keep-alive>
      <v-fade-transition hide-on-leave>
        <router-view />
      </v-fade-transition>
    </keep-alive>
  </v-main>
</template>

<script>
export default {
  name: "Publicview"
};
</script>
