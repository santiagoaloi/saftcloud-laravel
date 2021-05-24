<template>
  <baseDialog
    v-model="internalValue"
    title="Add new MySQL table"
    persistent
    max-width="900"
    @save="addTable()"
    @close="() => (internalValue = false)"
  >
    <v-card color="#f8f9fa">
      <v-tabs
        v-model.lazy="parentData.tab_item"
        color="primary"
        slider-color="primary"
        slider-size="4"
        vertical
      >
        <v-tab v-for="item in parentData.table_tabs" :key="item.menu_name">
          <v-icon left>
            {{ item.icon }}
          </v-icon>
          {{ item.menu_name }}
        </v-tab>

        <v-tab-item>
          <v-card color="#f8f9fa">
            <v-card-text>
              <v-container>
                <v-row dense>
                  <v-col class="xs" md="6">
                    <span>Table name</span>
                    <v-text-field
                      v-model.lazy="parentData.table_settings.table_name"
                      v-lazy-input:debounce="500"
                      autofocus
                      solo
                      prepend-inner-icon="mdi-table-plus"
                      placeholder=" "
                      color="primary"
                      label="  "
                      hint=" "
                    />
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
        </v-tab-item>

        <v-tab-item>
          <v-card color="#f8f9fa">
            <v-card-text>
              <v-container>
                <v-row dense>
                  <v-col class="xs" md="6">
                    <span>Table name</span>
                    <v-text-field
                      v-model.lazy="parentData.table_settings.table_name"
                      v-lazy-input:debounce="500"
                      autofocus
                      solo
                      prepend-inner-icon="comment"
                      placeholder=" "
                      color="primary"
                      label="  "
                      hint=" "
                    />
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs>
    </v-card>
  </baseDialog>
</template>
<script>
export default {
  name: "DialogTable",
  inheritAttrs: true,
  inject: ["addTable"],

  props: {
    value: Boolean,
  },

  data() {
    return {
      internalValue: this.value,
    };
  },

  watch: {
    internalValue(val, oldVal) {
      if (val === oldVal) return;

      requestAnimationFrame(() => {
        this.$refs.tableTitle.focus();
      });

      this.$emit("input", val);
    },
    value(val, oldVal) {
      if (val === oldVal) return;

      this.internalValue = val;
    },
  },
};
</script>
