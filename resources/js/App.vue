<template>
  <div>
    <!-- <vue-progress-bar /> -->

    <v-fade-transition hide-on-leave>
      <component :is="layout">
        <!-- <baseDialog
        v-if="sessionExpirationDialog"
        v-model="sessionExpirationDialog"
        title="Session Timeout"
        persistent
        max-width="500"
        no-click-animation
        :no-actions="true"
        height="180"
        :save="() => (sessionExpirationDialog = false)"
        :close="() => (sessionExpirationDialog = false)">
        <v-card flat>
          <v-row
            class="fill-height no-gutters"
            align="center">
            <v-col cols="9">
              <v-card-text>
                Your session will expire automatically due to inactivity.
                Choose to stay signed-in in or logout.
              </v-card-text>
            </v-col>
            <v-col cols="3">
              <v-card-text>
                <v-icon size="6em">
                  mdi-timelapse
                </v-icon>
              </v-card-text>
            </v-col>
          </v-row>

          <v-card-actions>
            <v-btn
              class="white--text"
              color="grey darken-1"
              @click="closeSessionTimeoutDialog">
              Logout
            </v-btn>
            <v-btn
              class="white--text"
              color="grey accent-2"
              @click="sessionExpirationDialog = false">
              Stay loggedin ({{ revertCount }})
            </v-btn>
            <v-spacer />
          </v-card-actions>
        </v-card>
      </baseDialog> -->
      </component>
    </v-fade-transition>
  </div>
</template>
<script>
import { store } from "@/store";
import { mapActions } from "vuex";
// import routesBuilder from "@/mixins/routesBuilder";
// import appActivity from '@/util/appActivity'

export default {
  name: "AppVue",
  // mixins: [routesBuilder],
  metaInfo: {
    title: "SaftCloud",
    titleTemplate: "%s | Homepage",
    htmlAttrs: { lang: "en" },
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
    ],
  },

  data() {
    return {
      test: "test",
      sessionExpirationDialog: false,
      hide: true,
      loading: false,
      idleText: "unknown",
      idleTime: 0,
      active: false,
      timeoutThreshold: 15,
      revertCount: 10,
      countDownInterval: null,
    };
  },

  computed: {
    upload() {
      return store.state.baseUrl;
    },

    vuetify() {
      return this.$vuetify;
    },

    isLoggedIn: function () {
      if (Object.keys(store.state.sessionData.login).length == 0) {
        return null;
      }
      return true;
    },

    isRouterLoaded: function () {
      if (this.$route.name !== null) return true;
      return false;
    },

    layout() {
      return this.$route.meta.layout;
    },
  },

  watch: {
    // sessionExpirationDialog (val) {
    //   if (!val) return
    //     this.startTimeoutCountdown()
    //   },
    // revertCount (val) {
    //     if (val === 0) {
    //       this.sessionExpirationDialog = false
    //       clearInterval(this.countDownInterval)
    //       this.revertCount = 10
    //       this.logoutVuex()
    //     }
    //   },
  },

  created() {
    // this.$vuetify.theme.primary = "#78909C";

    // appActivity.hook(this.onActivity)
    // this.fastInterval = setInterval(this.fastCheckActivity, 1300)

    window.getApp = this;

    //  hook the progress bar to start before we move router-view
    // this.$router.beforeEach((to, from, next) => {
    //   this.$Progress.start();
    //   if (to.name != "elementsPreview" && from.name == "Formbuilder") {
    //     this.$swal({
    //       title: "Spara eventuella förändringar",
    //       text:
    //         "Om du lämnar sidan så försvinner eventuellt osparade ändringar.",
    //       showCancelButton: true,
    //       confirmButtonText: "Fortsätt",
    //       cancelButtonText: "Stanna",
    //       confirmButtonColor: "#33967b",
    //       backdrop: "rgba(108, 122, 137, 0.8)",
    //       imageUrl: `${this.upload}uploads/images/draft.svg`,
    //       imageHeight: 200,
    //       width: 600,
    //     }).then((result) => {
    //       if (result.value) {
    //         // this.$Progress.start()
    //         next();
    //       }
    //     });
    //   } else {
    //     next();
    //     // this.$Progress.start()
    //   }
    // });

    // this.$router.afterEach((to, from) => {
    //   this.$Progress.finish();
    // });
  },

  mounted() {
    // console.log(this.$vuetify);

    //this brings the whole object to the front.

    // console.log();
    // const axiosDefaults = require("axios/lib/defaults");

    // axiosDefaults.baseURL = store.state.baseUrl;

    // if (Object.keys(store.state.sessionData.login).length !== 0) {
    //   axiosDefaults.headers = {
    //     // 'Content-Type': 'application/json',
    //     Authorization: "Bearer " + store.state.sessionData.login.token,
    //   };
    // } else {
    //   axiosDefaults.headers = {
    //     "Content-Type": "application/json",
    //     Authorization: "Bearer",
    //   };
    // }

    // this.loadSiteInfo();
    // this.loadAppConfig();
    // this.buildDynamicRoutes();
    // this.buildGlobalRoutes();
  },

  methods: {
    ...mapActions(["loadSiteInfo", "loadAppConfig", "logoutVuex"]),

    // minusOne () {
    //   this.revertCount--
    // },

    // startTimeoutCountdown () {
    //   this.countDownInterval = setInterval(this.minusOne, 1300)
    // },

    // closeSessionTimeoutDialog () {

    //   this.sessionExpirationDialog = false
    //   this.revertCount = 10
    //   this.logoutVuex()

    // },

    //   fastCheckActivity () {

    //     this.idleText = appActivity.getIdleText()
    //     this.idleTime = appActivity.getIdleSeconds()

    //     if (this.idleTime === 0) {
    //       this.revertCount = 10
    //     }

    //     if (this.isLoggedIn) {
    //       if (this.idleTime > this.timeoutThreshold) {
    //         this.sessionExpirationDialog = true

    //         }
    //     }
    //  },

    // onActivity () {
    //   this.active = true
    // },
  },
};
</script>
    