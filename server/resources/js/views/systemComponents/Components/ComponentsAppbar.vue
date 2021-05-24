<template>
  <div>
    <v-app-bar class="mt-3" color="transparent" flat dense>
      <v-toolbar-title style="width: 240px">
        <h3 class="hidden-sm-and-down black--text">Manage components</h3>
      </v-toolbar-title>

      <div class="flex-grow-1" />

      <v-text-field
        v-model.lazy="parentData.search"
        v-lazy-input:debounce="500"
        spellcheck="false"
        color="primary lighten-1"
        background-color="white"
        solo
        dense
        hide-details
        placeholder="Search components..."
        prepend-inner-icon="mdi-magnify"
        :class="expand ? 'expanded' : 'shrinked'"
        class="mx-2"
        @focus="expand = true"
        @blur="expand = false"
      />

      <v-btn class="mx-2 " color="white" @click.stop="parentData.dialogSystemOperations = true"> <v-icon class="mr-2" small> mdi-filter </v-icon>Filter </v-btn>

      <v-btn class="mx-2 " color="white" @click.stop="parentData.dialogSystemOperations = true">
        <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export
      </v-btn>

      <v-btn class="ml-2 " color="primary" @click.stop="parentData.dialogSystemOperations = true">
        <v-icon class="mr-2" small> mdi-plus </v-icon>Create component
      </v-btn>
      <!-- <v-btn class="mx-2 white--text" color="primary" @click.stop="parentData.dialogSystemOperations = true">
        <v-icon class="mr-2" small> mdi-sort </v-icon>Advanced operations
      </v-btn> -->
    </v-app-bar>
    <span>Edit components settings, groups folders or drill down for more information</span>
  </div>
</template>

<script>
export default {
  name: "ComponentsAppbar",
  inheritAttrs: true,
  inject: [
    "sortTitle",
    "sortOwner",
    "sortUpdated",
    "sortCreationOrder",
    "sortSidebarVisibility",
    "sortGlobal",
    "setView",
    "deleteComponentBulk",
    "enableProtectionBulk",
    "disableProtectionBulk",
    "sidebarBulkVisible",
    "sidebarBulkHidden",
    "showDesktop"
  ],

  props: {
    value: Boolean,
    parentData: Object
  },

  data() {
    return {
      expand: false,
      internalValue: this.value
    };
  },

  watch: {
    internalValue(val, oldVal) {
      if (val === oldVal) return;

      this.$emit("input", val);
    },
    value(val, oldVal) {
      if (val === oldVal) return;

      this.internalValue = val;
    }
  }
};
</script>
<style scoped>
.expanded {
  max-width: 24em;
  -webkit-transition: all 0.7s ease 0s;
  -moz-transition: all 0.7s ease 0s;
  -o-transition: all 0.7s ease 0s;
  transition: all 0.7s ease 0s;
}

.shrinked {
  max-width: 16em;
  -webkit-transition: all 0.7s ease 0s;
  -moz-transition: all 0.7s ease 0s;
  -o-transition: all 0.7s ease 0s;
  transition: all 0.7s ease 0s;
}
</style>
