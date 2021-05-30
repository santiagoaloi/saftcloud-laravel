<template>
  <baseDialog
    v-model="internalValue"
    title="Group settings "
    persistent
    max-width="900"
    show-remove
    @save="saveGroup()"
    @close="() => (internalValue = false)"
    @remove="
      deleteGroup(parentData.group_settings.total, parentData.group_settings.group_id, parentData.group_settings.name)
    "
  >
    <template>
      <v-banner v-if="parentData.val_errors_group.length != 0" single-line>
        <v-icon slot="icon" color="warning" size="36">
          mdi-information-variant
        </v-icon>
        <p v-for="(item, index) in parentData.val_errors_group" :key="index" class="pa-0">
          {{ item }}
        </p>
      </v-banner>
    </template>

    <v-card-text>
      <v-container>
        <v-row>
          <v-col cols="12" sm="12" md="6">
            <span>Group name</span>
            <v-text-field
              ref="groupTitle"
              v-model.lazy="parentData.group_settings.name"
              v-lazy-input:debounce="500"
              counter
              maxlength="35"
              autofocus
              solo
              prepend-inner-icon="mdi-comment"
              placeholder=" "
              color="primary"
              label="  "
              hint=" "
            />
          </v-col>
          <!-- 
            <v-col cols="12" sm="12" md="6">
              <span>Directory name</span>
              <v-text-field
                v-model.lazy="parentData.group_settings.folder"
                v-lazy-input:debounce="500"
                counter
                maxlength="35"
                prepend-inner-icon="mdi-folder"
                solo
                placeholder=" "
                color="primary"
                :disabled="parentData.newGroup !== 1"
                label="Component folder name"
                hint="Backend directory and file names.  "
                @keydown.space.prevent
              />
            </v-col> -->

          <!-- <v-col
              cols="12"
              sm="12"
              md="6"
              lg="6">
              <span>Group icon</span>
              <v-autocomplete
                v-model.lazy="parentData.group_settings.icon"
                label="Select group icon"
                clearable
                solo
                :items="material_icons"
                item-value="icon"
                item-text="name"
                placeholder=" "
                item-color="primary"
                color="primary"
                :menu-props="{transition:'slide-y-transition', closeOnClick:false, closeOnContentClick:true}">>
                <template v-slot:selection="{ item }">
                  <div>
                    <v-icon
                      class="ml-2"
                      color="#4C4C4C">
                      {{ item.icon }}
                    </v-icon>
                  </div>
                </template>

                <template
                  slot="item"
                  slot-scope="data">
                  <div>
                    <v-icon
                      class="ml-2"
                      color="#4C4C4C"
                      small>
                      {{ parentData.item.icon }}
                    </v-icon>
                    <span class="ml-2">{{ parentData.item.name }}</span>
                  </div>
                </template>

                <template slot="prepend-item">
                  <v-list-item-content class="px-2">
                    <v-btn
                      tile
                      text
                      outlined
                      small
                      color="primary"
                      @click.stop="dialogIconModal = true">
                      Add icon
                    </v-btn>
                  </v-list-item-content>
                </template>
              </v-autocomplete>
          </v-row>
            </v-col>-->
        </v-row>
      </v-container>
    </v-card-text>
  </baseDialog>
</template>
<script>
export default {
  name: "DialogGroup",
  inheritAttrs: true,
  inject: ["saveGroup", "deleteGroup"],

  props: {
    value: Boolean,
    parentData: Object
  },

  data() {
    return {
      internalValue: this.value
    };
  },

  mounted() {
    this.parentData.group_settings.name = this.parentData.groupInputValue;
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
