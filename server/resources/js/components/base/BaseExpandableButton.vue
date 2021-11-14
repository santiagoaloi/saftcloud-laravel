<template>
  <div :style="`z-index: ${zIndex};width: ${width}`">
    <v-sheet :width="width">
      <v-list color="#222530e6">
        <v-list-item :ripple="false" @click="internalValue = !internalValue">
          <v-list-item-avatar>
            <v-icon>{{ icon }}</v-icon>
          </v-list-item-avatar>

          <v-list-item-content>
            <h5 class="indigo--text text--lighten-2">{{ title }}</h5>
            <v-list-item-subtitle>{{ subtitle }}</v-list-item-subtitle>
          </v-list-item-content>

          <v-list-item-icon>
            <v-icon right> {{ internalValue ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
          </v-list-item-icon>
        </v-list-item>
      </v-list>
    </v-sheet>

    <v-fade-transition>
      <base-flex-container v-show="internalValue" :width="width" :top="nudgeTop">
        <template #top>
          <slot name="listTop"> </slot>
        </template>
        <slot></slot>
      </base-flex-container>
    </v-fade-transition>
  </div>
</template>

<script>
  export default {
    name: 'ExpandableButton',
    props: {
      value: {
        type: [Boolean],
        default: false,
      },
      width: {
        type: [String],
        default: () => '100%',
      },
      icon: {
        type: [String],
        default: () => 'mdi-home',
      },
      title: {
        type: [String],
        default: () => 'Title',
      },
      subtitle: {
        type: [String],
        default: () => 'Subtitle',
      },
      nudgeTop: {
        type: [Number],
        default: () => 0,
      },

      zIndex: {
        type: [Number],
        default: () => 1,
      },
    },
    data() {
      return {
        internalValue: this.value,
      };
    },

    watch: {
      internalValue(val, oldVal) {
        if (val === oldVal) return; // Don't do anything.
        this.$emit('input', val); // emit input change to v-model
      },

      value(val, oldVal) {
        if (val === oldVal) return;
        this.internalValue = val;
      },
    },
  };
</script>
