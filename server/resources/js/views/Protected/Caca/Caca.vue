<template>
  <div>
    <v-card-actions class="pa-0">
      <template v-if="$route.meta.icon">
        <v-avatar class="cursor-pointer" size="40" rounded :color="$route.meta.icon.color">
          <v-icon size="30" dark>
            {{ $route.meta.icon.name || null }}
          </v-icon>
        </v-avatar>
      </template>

      <v-spacer></v-spacer>

      <v-btn plain class="mx-2"> <v-icon left small> mdi-arrow-top-right </v-icon>Export </v-btn>
      <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click="dialog = true">
        <v-icon left small> mdi-plus </v-icon>Add records
      </v-btn>
    </v-card-actions>
    <v-divider class="mt-3" />

    <v-data-table
      :search="search"
      fixed-header
      :headers="columns"
      :items="records"
      style="cursor: pointer"
    />

    <base-dialog
      v-model="dialog"
      width="50vw"
      title="add record"
      @save="addRecord()"
      @close="dialog = false"
    >
      <v-form @submit.prevent="addRecord()">
        <v-row>
          <v-col v-for="(field, i) in formFields" :key="i" sm="6">
            <baseFieldLabel required :label="field.label" />
            <v-text-field
              v-model="recordItem[field.field]"
              :outlined="isDark"
              :solo="!isDark"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              spellcheck="false"
            />
          </v-col>
        </v-row>
        <v-btn v-show="false" type="submit" />
      </v-form>
    </base-dialog>
  </div>
</template>

<script>
  import activeView from '@/mixins/activeView';

  export default {
    name: 'Caca',
    mixins: [activeView],
    data() {
      return {
        dialog: false,
      };
    },
  };
</script>
