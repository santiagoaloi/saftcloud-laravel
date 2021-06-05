<template>
  <div>
    <baseAppbar :parent-data="$data" />
    <baseLayoutCard>
      <base-loading v-if="emptyRows" />
      <v-fade-transition>
        <div v-if="!emptyRows">
          <default-table ref="defaultTable" v-model="selected" :parent-data="$data" />
        </div>
      </v-fade-transition>
    </baseLayoutCard>
    <baseCrudDialog v-if="dialogFormInputs" ref="baseCrudDialog" v-model="dialogFormInputs" :parent-data="$data" />
  </div>
</template>

<script>
import axios from 'axios';
import baseFunctions from '@/mixins/baseFunctions';
import baseVariables from '@/mixins/baseVariables';
import globalMixin from '@/mixins/globalMixin';
export default {
  name: '{class}',
  components: {
    DefaultTable: () => import('./{class}Table'),
  },
  mixins: [baseFunctions, baseVariables, globalMixin],

  provide() {
    return {
      ...this.getComponentMethods(),
    };
  },

  data() {
    return {
      controller: '{class}',
    };
  },
};
</script>

<style scoped></style>
