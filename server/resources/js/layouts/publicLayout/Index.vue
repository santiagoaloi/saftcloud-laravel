<template>
  <div>
    <pub-bar />
    <pub-view />
    <snackbar />
    <pub-footer />
  </div>
</template>

<script>
import App from "../../App.vue";
export default {
  name: "Publiclayout",
  components: {
    PubBar: () =>
      import(
        /* webpackChunkName: 'public-appbar-view-footer-combined' */ "./AppBar"
      ),
    PubView: () =>
      import(
        /* webpackChunkName: 'public-appbar-view-footer-combined' */ "./View"
      ),
    PubFooter: () =>
      import(
        /* webpackChunkName: 'public-appbar-view-footer-combined' */ "./Footer"
      ),
    Snackbar: () =>
      import(
        /* webpackChunkName: 'public-snackbar' */
        "@/components/base/Snackbar"
      )
  }
};
</script>
