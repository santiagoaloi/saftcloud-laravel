<template>
  <!-- <v-card tile elevation="4" color="transparent"> -->

  <v-carousel :light="true" height="100%" :show-arrows="false" hide-delimiters>
    <v-carousel-item v-for="item in filteredComponents" :key="item.id">
      <v-sheet color="rgba(100, 100,100, 0.4)" height="100%">
        <v-row class="fill-height" align="end" justify="center">
          <!-- <div class="display-3">{{ slide }} Slide</div> -->
          <v-card color="transparent" width="90%">
            <v-row class="fill-height" align="center" justify="center">
              <div class="topFont topSlide text-truncate px-8 white--text">
                <v-btn
                  fab
                  text
                  class="mx-8"
                  color="success"
                  v-bind="attrs"
                  v-on="on"
                  ><v-icon xLarge>mdi-chevron-left</v-icon></v-btn
                >
                <v-icon class="mr-3 white--text" x-large>
                  {{ parentData.rows[parentData.carouselActiveIndex].icon }}
                </v-icon>
                {{ parentData.rows[parentData.carouselActiveIndex].title }}
                <v-btn
                  fab
                  text
                  class="mx-8"
                  color="info"
                  v-bind="attrs"
                  v-on="on"
                  ><v-icon xLarge>mdi-chevron-right</v-icon></v-btn
                >
              </div>
            </v-row>
            <v-card-actions>
              <v-spacer />
            </v-card-actions>
          </v-card>

          <v-expansion-panels accordion>
            <v-card class="px-4" width="100%">
              <v-list>
                <v-list-item>
                  <v-list-item-avatar>
                    <v-img src="https://cdn.vuetifyjs.com/images/john.png" />
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title>
                      {{
                        parentData.rows[parentData.carouselActiveIndex].owner
                      }}
                    </v-list-item-title>
                    <v-list-item-subtitle>Owner</v-list-item-subtitle>
                  </v-list-item-content>

                  <v-list-item-action>
                    <v-hover v-slot="{ hover }" open-delay="200">
                      <v-btn
                        class="mr-1"
                        color="grey"
                        dark
                        icon
                        large
                        :ripple="false"
                        @click="
                          manage(
                            parentData.rows[parentData.carouselActiveIndex]
                              .table,
                            parentData.rows[parentData.carouselActiveIndex]
                              .controller
                          )
                        "
                      >
                        <v-icon color="grey darken-2" class="mx-2">
                          {{ hover ? "mdi-pencil-outline" : "mdi-pencil" }}
                        </v-icon>
                      </v-btn>
                    </v-hover>
                  </v-list-item-action>

                  <v-list-item-action>
                    <v-hover v-slot="{ hover }" open-delay="200">
                      <v-btn
                        color="red lighten-2"
                        dark
                        icon
                        large
                        :ripple="false"
                        @click.native="
                          checkRemovalProtection(
                            parentData.rows[parentData.carouselActiveIndex]
                          )
                        "
                      >
                        <v-icon class="mx-2">
                          {{
                            hover
                              ? "mdi-delete-empty-outline"
                              : "mdi-delete-outline"
                          }}
                        </v-icon>
                      </v-btn>
                    </v-hover>
                  </v-list-item-action>

                  <v-list-item-action>
                    <v-btn
                      color="blue lighten-2"
                      dark
                      icon
                      large
                      :ripple="false"
                      class="mx-n3"
                      :to="
                        parentData.rows[parentData.carouselActiveIndex]
                          .controller
                      "
                    >
                      <v-icon> mdi-link </v-icon>
                    </v-btn>
                  </v-list-item-action>
                </v-list-item>
              </v-list>

              <v-list>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>
                      <v-icon small>mdi-folder</v-icon>
                      {{
                        parentData.rows[parentData.carouselActiveIndex].folder
                      }}/{{
                        parentData.rows[parentData.carouselActiveIndex]
                          .controller
                      }}</v-list-item-title
                    >
                    <v-list-item-subtitle>
                      <v-icon small>mdi-tag</v-icon>
                      {{ parentData.rows[parentData.carouselActiveIndex].note }}
                    </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-card>

            <v-expansion-panel v-for="(item, i) in 5" :key="i">
              <v-expansion-panel-header> Item </v-expansion-panel-header>
              <v-expansion-panel-content>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat.
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
        </v-row>
      </v-sheet>
    </v-carousel-item>
  </v-carousel>

  <!-- </v-card> -->
  <!-- <v-card height="30vh" color="blue"> </v-card> -->
</template>

<script>
export default {
  name: "ComponentsCarousel",
  inject: ["checkRemovalProtection", "manage"],
  props: {
    value: Number,
    parentData: Object,
  },

  data() {
    return {};
  },

  computed: {
    filteredComponents: function () {
      const search = this.parentData.search.toString().toLowerCase();
      return this.parentData.rows.filter((item) => {
        return (
          item.title.toLowerCase().match(search) ||
          item.controller.toLowerCase().match(search) ||
          item.owner.toLowerCase().match(search)
        );
      });
    },
  },

  watch: {
    // Emit new value to parent if v-model value changes.
    value(val, oldVal) {
      if (val === oldVal) return;
      this.$emit("input", val); // emit input change to v-model
    },
  },
};
</script>
<style scoped>
@media (min-width: 992px) {
  .topFont {
    font-size: 2.5em;
  }
}

@media (max-width: 992px) {
  .topFont {
    font-size: 2em;
  }
}

@media (max-width: 500px) {
  .topFont {
    font-size: 1em;
  }
}

.topSlide {
  font-weight: 300 !important;
  letter-spacing: 0.025em !important;
}
</style>
