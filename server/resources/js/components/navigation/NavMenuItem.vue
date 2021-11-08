<template>
  <div>
    <v-list-item
      v-if="!menuItem.items"
      :input-value="menuItem.value"
      :to="menuItem.link"
      :exact="menuItem.exact"
      :disabled="menuItem.disabled"
      link
    >
      <div class="d-flex">
        <v-list-item-icon class="mr-1">
          <v-icon :class="{ 'grey--text': menuItem.disabled }">
            {{ menuItem.icon ? menuItem.icon : 'mdi-folder-outline' }}
          </v-icon>
        </v-list-item-icon>
        <v-list-item-content class="ml-2">
          <v-list-item-title>
            {{ menuItem.title || menuItem.name }}
          </v-list-item-title>
        </v-list-item-content>
      </div>
    </v-list-item>

    <v-list-group
      v-else
      ref="group"
      no-action
      :value="menuItem.regex ? menuItem.regex.test($route.path) : false"
      :disabled="menuItem.disabled"
      :sub-group="subgroup"
      color="white"
      :prepend-icon="subgroup ? false : ''"
    >
      <template #activator>
        <slot v-if="!subgroup" name="prependIcon">
          <v-icon class="mr-3">
            {{ icon }}
          </v-icon>
        </slot>

        <slot v-if="subgroup" name="prependIcon">
          <v-icon class="ml-n4 mr-3">
            {{ icon }}
          </v-icon>
        </slot>

        <v-list-item-content>
          <v-list-item-title>
            {{ menuItem.name }}
          </v-list-item-title>
        </v-list-item-content>
      </template>

      <slot />
    </v-list-group>
  </div>
</template>

<script>
  export default {
    props: {
      menuItem: {
        type: Object,
        default: () => {},
      },
      subgroup: {
        type: Boolean,
        default: false,
      },
      small: {
        type: Boolean,
        default: false,
      },
    },
    data: () => ({
      icon: 'mdi-folder-outline',
    }),
    mounted() {
      this.$watch(
        () => {
          if (this.$refs.group) return this.$refs.group.isActive;
        },
        (val) => {
          this.icon = val ? 'mdi-folder-open-outline' : 'mdi-folder-outline';
        },
      );
    },
  };
</script>
<style scoped>
  .v-application--is-ltr .v-list-group__items .v-list-item {
    padding-left: 18px !important;
  }
</style>
