<template>
  <v-fade-transition hide-on-leave>
    <v-data-table
      v-if="parentData.view_type"
      v-show="parentData.view_type"
      v-model="parentData.selected"
      style="margin-bottom: -1.3em"
      :search="parentData.search"
      :headers="parentData.headers"
      :items="parentData.rows"
      :items-per-page="10"
      class="elevation-0 pa-2"
      item-key="id"
      show-select
      :hide-default-footer="parentData.rows.length == 0"
      :hide-default-header="parentData.rows.length == 0"
    />
  </v-fade-transition>
</template>

<script>
export default {
  name: "ComponentsTable",
  inheritAttrs: true,
  inject: [],
  props: {
    parentData: Object,
  },
};
</script>
