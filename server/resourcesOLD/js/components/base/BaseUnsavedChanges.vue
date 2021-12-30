<template>
  <v-sheet color="transparent" class="px-3">
    <v-alert class="mt-3" elevation="1" colored-border color="pink" border="right" dense>
      <div class="d-flex justify-space-between align-center">
        Unsaved
        <v-btn dark small @click="rollBack"> rollback </v-btn>
      </div>
    </v-alert>
  </v-sheet>
</template>

<script>
  export default {
    name: 'UnsavedChanges',
    methods: {
      rollBack() {
        this.$emit('rollBack');
      },
    },
  };
</script>
