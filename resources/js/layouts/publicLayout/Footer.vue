<template>
  <v-footer color="transparent">
    <v-container class="py-5">
      <v-row>
        <v-col cols="12" md="4">
          <div class="text-h6 text-lg-h5 font-weight-bold">Navigation</div>
          <div style="width: 80px; height: 2px" class="mb-5 mt-1 primary" />
          <div class="d-flex flex-wrap">
            <div v-for="(link, i) in links" :key="i" class="w-half body-1 mb-1">
              <router-link
                v-if="link.to"
                class="text-decoration-none text--primary"
                :to="link.to"
                >{{ link.label }}</router-link
              >
              <a
                v-else
                class="text-decoration-none text--primary"
                :href="link.href"
                :target="link.target || 'blank'"
                >{{ link.label }}</a
              >
            </div>
          </div>
        </v-col>
        <v-col cols="12" md="4">
          <div class="text-h6 text-lg-h5 font-weight-bold">
            Contact Information
          </div>
          <div style="width: 80px; height: 2px" class="mb-5 mt-1 primary" />
          <div class="d-flex mb-2 font-weight-bold">
            <v-icon color="primary lighten-1" class="mr-2"
              >mdi-map-marker-outline</v-icon
            >
            Bokstigen 3, 13745, Stockholm SWEDEN
          </div>
          <div class="d-flex mb-2">
            <v-icon color="primary lighten-1" class="mr-2"
              >mdi-phone-outline</v-icon
            >
            <a href="#" class="text-decoration-none text--primary"
              >+46 70 2555 331</a
            >
          </div>
          <div class="d-flex mb-2">
            <v-icon color="primary lighten-1" class="mr-2"
              >mdi-email-outline</v-icon
            >
            <a href="#" class="text-decoration-none text--primary"
              >hello@saftcloud.com</a
            >
          </div>
        </v-col>
        <v-col cols="12" md="4">
          <div class="text-h6 text-lg-h5 font-weight-bold">Newsletter</div>
          <div style="width: 80px; height: 2px" class="mb-5 mt-1 primary" />
          <div class="d-flex flex-column flex-lg-row w-full">
            <v-text-field
              solo
              label="Your email"
              dense
              height="44"
              class="mr-lg-2"
            ></v-text-field>
            <v-btn large color="primary">Subscribe</v-btn>
          </div>
          <div class="text-center text-md-right mt-4 mt-lg-2">
            Connect
            <v-btn fab small color="primary" class="ml-2">
              <v-icon>mdi-twitter</v-icon>
            </v-btn>
            <v-btn fab small color="primary" class="ml-2">
              <v-icon>mdi-linkedin</v-icon>
            </v-btn>
            <v-btn fab small color="primary" class="ml-2">
              <v-icon>mdi-instagram</v-icon>
            </v-btn>
          </div>
        </v-col>
      </v-row>
      <v-divider class="my-3"></v-divider>
      <div class="text-center caption">
        © SaftCloud 2021. All Rights Reserved.
      </div>
    </v-container>
  </v-footer>
</template>

<script>
import RouterLink from "vue-router";
export default {
  name: "Footer",
  components: [RouterLink],
  data: function () {
    return {
      links: [
        {
          label: "Overview",
          to: "#",
        },
        {
          label: "Features",
          to: "#",
        },
        {
          label: "Pricing",
          to: "#",
        },
        {
          label: "Documentation",
          to: "#",
        },
        {
          label: "News",
          to: "#",
        },
        {
          label: "FAQ",
          to: "#",
        },
        {
          label: "About us",
          to: "#",
        },
        {
          label: "Carrers",
          to: "#",
        },
        {
          label: "Press",
          to: "#",
        },
      ],
    };
  },
};
</script>
