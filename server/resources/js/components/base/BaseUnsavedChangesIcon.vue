<template>
  <v-fade-transition>
    <div v-if="unsaved" class="gallery-card-subtitle-wrapper">
      <h5 class="gallery-card-subtitle">
        <v-tooltip transition="false" color="black" bottom>
          <template #activator="{ on }">
            <v-icon :color="isDark ? 'white' : '#28292b'" v-on="on"> mdi-alert-outline </v-icon>
          </template>
          <span>Unsaved</span>
        </v-tooltip>
      </h5>
    </div>
  </v-fade-transition>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'UnsavedChangesIcon',

    props: {
      unsaved: {
        type: [Boolean],
        default: false,
      },
    },

    computed: {
      ...sync('theme', ['isDark']),
    },
  };
</script>
