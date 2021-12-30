<template>
  <div class="d-flex justify-center align-center select-none h-full overflow-x-hidden">
    <div class="d-flex align-center flex-column">
      <v-img class="bw-image" :aspect-ratio="1" width="20%" contain src="storage/systemImages/noContent.svg" />
      <v-responsive width="60%">
        <div class="text-center">
          <template v-if="isAllModulesEmpty"> Seems that you haven't created any modules yet. </template>
          <template v-else>
            <h3 class="blue--text">There are {{ countAllModules }} modules in your store</h3>
            <h3>
              Seems that no modules are matching your filters. Try a new search, change filters or select one or more module
              groups.
            </h3>
          </template>
        </div>
      </v-responsive>

      <v-btn v-if="isAllModulesEmpty" color="#373b4f" class="mt-2" @click="dialogModule = true"> Add module</v-btn>
      <v-btn v-else color="#373b4f" class="mt-2" @click="dialogGroups = true"> Select group</v-btn>
    </div>
  </div>
</template>

<script>
  import { get, sync } from 'vuex-pathify';

  export default {
    name: 'ModulesNoData',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['dialogGroups']),
      ...get('modulesManagement', ['isAllModulesEmpty', 'countAllModules']),
    },
  };
</script>
00000988
