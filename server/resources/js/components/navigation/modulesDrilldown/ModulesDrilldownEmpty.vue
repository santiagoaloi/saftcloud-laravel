<template>
  <div class="select-none">
    <v-card-title> {{ title }} </v-card-title>
    <v-card-subtitle>
      {{ subTitle }}
    </v-card-subtitle>

    <v-sheet v-once color="transparent" height="65vh" class="d-flex justify-center align-center">
      <div class="flex-grow-1 align-center justify-center d-flex flex-column">
        <v-img class="bw-image" :aspect-ratio="1" width="200" contain :src="imageSource" />
      </div>
    </v-sheet>
  </div>
</template>

<script>
  export default {
    name: 'ModulesDrilldownEmpty',

    computed: {
      title() {
        return 'No Module selected...';
      },
      subTitle() {
        return 'Select a module from the grid or table to access the configuration options.';
      },
      imageSource() {
        return 'storage/systemImages/noContent.svg';
      },
    },
  };
</script>
