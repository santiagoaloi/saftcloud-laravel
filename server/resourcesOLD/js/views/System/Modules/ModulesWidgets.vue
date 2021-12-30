<template>
  <div v-if="$vuetify.breakpoint.lgAndUp" class="px-3 pt-2">
    <v-row>
      <v-col sm="grow">
        <v-card color="#292c3b" class="mt-4 mx-auto" width="100%">
          <v-sheet height="80" class="v-sheet--offset mx-auto" color="#373b4f" elevation="12" max-width="calc(100% - 32px)">
            <v-container class="fill-height">
              <v-avatar size="50" color="#4a4c69">
                <v-icon> mdi-view-module </v-icon>
              </v-avatar>
              <div class="flex-grow-1" />
              <div class="indigo--text text--lighten-3" style="font-size: 2.6rem">25</div>
              <div class="flex-grow-1" />
            </v-container>
          </v-sheet>
          <v-card-text class="pt-0">
            <div class="font-weight-light mb-2 white--text">Module views</div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col sm="grow">
        <v-card color="#292c3b" class="mt-4 mx-auto" width="100%">
          <v-sheet height="80" class="v-sheet--offset mx-auto" color="#373b4f" elevation="12" max-width="calc(100% - 32px)">
            <v-container class="fill-height justify-center">
              <v-avatar size="50" color="#4a4c69">
                <v-icon large> mdi-view-module </v-icon>
              </v-avatar>
              <div class="flex-grow-1" />
              <b class="indigo--text text--lighten-3" style="font-size: 2.5rem"> 25 </b>
              <div class="flex-grow-1" />
            </v-container>
          </v-sheet>
          <v-card-text class="pt-0">
            <div class="font-weight-light mb-2 white--text">Module views</div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col sm="grow">
        <v-card color="#292c3b" class="mt-4 mx-auto" width="100%">
          <v-sheet height="80" class="v-sheet--offset mx-auto" color="#373b4f" elevation="12" max-width="calc(100% - 32px)">
            <v-container class="fill-height justify-center">
              <v-avatar size="50" color="#4a4c69">
                <v-icon large> mdi-view-module </v-icon>
              </v-avatar>
              <div class="flex-grow-1" />
              <b class="indigo--text text--lighten-3" style="font-size: 2.5rem"> 25 </b>
              <div class="flex-grow-1" />
            </v-container>
          </v-sheet>
          <v-card-text class="pt-0">
            <div class="font-weight-light mb-2 white--text">Module views</div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script>
  export default {
    name: 'ModulesToolbar',
    data: () => ({
      labels: ['12am', '3am', '6am', '9am', '12pm', '3pm', '6pm', '9pm'],
      value: [200, 675, 410, 390, 310, 460, 250, 240],
    }),
    computed: {
      // ...sync('theme', ['isDark']),
      // ...sync('modulesManagement', ['dialogModules', 'dialogEditor']),
      // ...sync('loaders', ['dialogModulesLoader']),
    },

    methods: {
      // ...call('modulesManagement', ['selectGroup']),
    },
  };
</script>
<style scoped>
  .v-sheet--offset {
    top: -14px;
    position: relative;
  }
</style>
