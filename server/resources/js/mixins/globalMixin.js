// import findKey from "lodash/findKey";
// import isEqual from "lodash/isEqual";
import { store } from "@/store";

//Data Exporting capabilities
import Vue from "vue";
// import JsonExcel from "vue-json-excel";
// Vue.component("downloadExcel", JsonExcel);

export default {
  data() {
    return {
      scrollButton: false,
      screenHeight: 0,
    };
  },

  created() {
    this.screenHeight = window.innerHeight;
    window.addEventListener("resize", this.getWindowSize);
  },

  beforeDestroy() {
    // VERY IMPORTANT -- otherwise the listeners will stuck up in every component loaded.
    window.removeEventListener("resize", this.getWindowSize, { passive: true });
  },

  methods: {
    getWindowSize() {
      this.screenHeight = window.innerHeight;
    },

    onScroll(e) {
      if (typeof window === "undefined") return;
      const top = window.pageYOffset || e.target.scrollTop || 0;
      this.scrollButton = top > 40;
    },

    toTop() {
      this.$vuetify.goTo(0);
    },

    // debugUpdated() {
    //   // Usage by calling this function from the updated hook.
    //   // This function will tell you what has changed in the data object.

    //   if (!this._priorState) {
    //     this._priorState = this.$options.data();
    //   }

    //   const self = this;
    //   const changedProp = findKey(this._data, (val, key) => {
    //     return !isEqual(val, self._priorState[key]);
    //   });

    //   this._priorState = { ...this._data };
    //   console.log(changedProp);
    // },

    getComponentMethods() {
      const provide = {};
      const componentFileName = Object.entries(this);

      // Build an object with all the methods of the current component that only contains alpha characters.
      for (const method of componentFileName) {
        if (typeof method[1] === "function" && method[0].match(/^[a-zA-Z]/)) {
          provide[method[0]] = this[method[0]];
        }
      }

      return provide;
    },
  },

  // computed: {
  //   uploadPath() {
  //     return `${store.state.baseUrl}/uploads/`;
  //   },

  //   siteInfo() {
  //     return store.state.appData.siteInfo;
  //   },

  //   appConfig() {
  //     return store.state.appData.appConfig;
  //   },

  //   groupId() {
  //     return store.state.sessionData.login.group_id;
  //   },

  //   sessionEmail() {
  //     return store.state.sessionData.userProfile.email;
  //   },

  //   profile() {
  //     return store.state.publicData.moderating
  //       ? store.state.publicData.publicProfile
  //       : store.state.sessionData.userProfile;
  //   },

  //   publicPortfolio() {
  //     return store.state.publicData.publicPortfolio;
  //   },

  //   publicProfile() {
  //     return store.state.publicData.publicProfile;
  //   },

  //   baseUrl() {
  //     return store.state.baseUrl;
  //   },

  //   isLoggedIn() {
  //     if (Object.keys(store.state.sessionData.login).length > 0) {
  //       return true;
  //     } else {
  //       return false;
  //     }
  //   },
  // },
};
