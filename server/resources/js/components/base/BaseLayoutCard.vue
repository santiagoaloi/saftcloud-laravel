<template>
  <v-container fluid>
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
