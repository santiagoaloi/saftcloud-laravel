<template>
  <div>
    <!-- toolbar -->
    <form-fields-toolbar />

    <v-divider />
    <v-row class="mt-0">
      <v-col cols="5">
        <!-- fields list -->
        <form-fields-list />
      </v-col>

      <v-col cols="7">
        <div class="d-flex">
          <v-divider vertical />
          <!-- right panel -->
          <form-fields-right-panel class="px-3" />
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
  export default {
    name: 'ComponentsEditViewsFormFields',
    components: {
      FormFieldsList: () => import(/* webpackChunkName: 'form-fields-list' */ './FormFieldsList'),
      FormFieldsToolbar: () => import(/* webpackChunkName: 'form-fields-toolbar' */ './FormFieldsToolbar'),
      FormFieldsRightPanel: () => import(/* webpackChunkName: 'form-fields-right-panel' */ './FormFieldsRightPanel'),
    },
  };
</script>
