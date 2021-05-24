<template>
  <baseDialog
    v-model="internalValue"
    :title="`Sort components in ${parentData.last_search_filter} group`"
    persistent
    max-width="900"
    @close="() => (internalValue = false)"
  >
    <template>
      <v-banner two-line>
        <v-avatar slot="icon" color="primary" size="40">
          <v-icon icon="mdi-lock" color="white"> mdi-comment </v-icon>
        </v-avatar>
        Displaying only the components that are visible in the sidemenu.
      </v-banner>
    </template>

    <v-card
      flat
      tile
      color="red"
      style="overflow-y: scroll; overflow-x: hidden"
    >
      <v-row>
        <!-- <v-list-item-group multiple v-model.lazy="selected" > -->
        <v-list-item-group v-model.lazy="parentData.selected">
          <draggable
            v-model.lazy="parentData.rows"
            :delay="100"
            :delay-on-touch-only="true"
            ghost-class="ghost"
            @change="updateComponents()"
          >
            <v-list-item
              v-for="item in filteredSortableComponents"
              :key="item.id"
              :disabled="filteredSortableComponents.length < 2"
              style="width: 600px"
              class="item pa-3"
              active-class="primary--text"
            >
              <v-btn icon class="mx-2">
                <v-icon>drag_indicator</v-icon>
              </v-btn>

              <v-list-item-action>
                <v-avatar class="mr-3" size="45">
                  <v-icon>{{ item.icon }}</v-icon>
                </v-avatar>
              </v-list-item-action>

              <v-list-item-content>
                <v-list-item-title class="pb-2">
                  {{ item.title }}
                </v-list-item-title>
                <v-list-item-subtitle>{{ item.note }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </draggable>
        </v-list-item-group>
      </v-row>
    </v-card>
  </baseDialog>
</template>

<script>
export default {
  name: "DialogSort",
  inheritAttrs: true,
  inject: ["updateComponents"],

  props: {
    value: Boolean,
    parentData: Object,
  },

  data() {
    return {
      internalValue: this.value,
    };
  },

  computed: {
    filteredSortableComponents() {
      return this.parentData.rows.length > 1
        ? Object.entries(this.parentData.rows)
            .map((item) => item[1])
            .filter((item) => item.menu == "1")
        : "";
    },
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
