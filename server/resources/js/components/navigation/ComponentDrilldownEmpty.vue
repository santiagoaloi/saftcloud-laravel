<template>
  <div class="select-none">
    <v-card-title> No Component Selected </v-card-title>
    <v-card-subtitle>
      Select one component from the list to display its corresponding settings or create a new component.
    </v-card-subtitle>

    <v-sheet v-once color="transparent" height="65vh" class="d-flex justify-center align-center">
      <div class="flex-grow-1 align-center justify-center d-flex flex-column">
        <v-img class="bw-image" :aspect-ratio="1" width="200" contain src="storage/systemImages/noContent.svg" />
      </div>
    </v-sheet>
  </div>
</template>

<script>
  export default {
    name: 'ComponentDrilldownEmpty',
  };
</script>
