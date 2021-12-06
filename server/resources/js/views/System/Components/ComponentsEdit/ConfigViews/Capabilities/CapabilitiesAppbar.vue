<template>
  <fragment>
    <div class="d-flex justify-end align-center">
      <div class="d-flex">
        <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click.stop="add()">
          <v-icon class="mr-2" small> mdi-plus </v-icon>Add capability
        </v-btn>
      </div>
    </div>
    <v-divider class="mt-3" />
  </fragment>
</template>

<script>
  import { sync, call } from 'vuex-pathify';

  export default {
    name: 'CapabilityAppbar',

    methods: {
      ...call('componentManagement/*'),

      add() {
        this.capability = {};
        this.dialogCapability = true;
      },
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['dialogCapability', 'capability']),
    },
  };
</script>
