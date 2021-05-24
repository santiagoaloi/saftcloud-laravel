<template>
  <baseDialog
    v-model="internalValue"
    title="Selected components"
    persistent
    max-width="900"
    @close="() => (internalValue = false)"
  >
    <v-card color="#f8f9fa">
      <template>
        <v-data-table
          :headers="parentData.headers"
          :items="parentData.selected"
          :items-per-page="5"
          class="elevation-0"
          item-key="id"
        >
          <template v-slot:item.actions="{ item }">
            <v-btn
              class="mr-2"
              text
              rounded
              elevation="0"
              color="primary "
              style="margin-left: 5px; color: white"
              @click.native="unselect(item)"
            >
              Unselect
            </v-btn>
          </template>
        </v-data-table>
      </template>
    </v-card>
  </baseDialog>
</template>

<script>
export default {
  name: "DialogSelected",
  inheritAttrs: true,
  inject: ["unselect"],

  props: {
    value: Boolean,
    parentData: Object,
  },

  data() {
    return {
      internalValue: this.value,
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
    },
  },
};
</script>
