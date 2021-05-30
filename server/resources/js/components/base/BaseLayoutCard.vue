<template>
  <v-container style="background-color:rgb(250, 251, 252)" fluid>
    <slot />
  </v-container>
</template>
<script>
export default {
  name: "BaseLayoutCard",
  inheritAttrs: false,

  props: {
    level: {
      type: [Number, String],
      default: 1
    },
    transparent: {
      type: Boolean,
      default: false
    }
  }
};
</script>
