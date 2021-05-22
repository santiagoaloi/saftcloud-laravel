<template>
  <div>
    <v-img
      height="101vh"
      style="margin-top:-80px"
      gradient="to top right, rgba(0,0,0,.1), rgba(0,0,0,.2)"
      src="storage/11.png"
    >
      <v-container class="fill-height text-left pa-10">
        <v-row class="d-flex flex-column">
          <div
            class="font-weight-black text-h4 text-sm-h3 text-md-h2 text-lg-h1"
          >
            <vue-typer
              :pre-type-delay="1000"
              :type-delay="90"
              :repeat="0"
              caret-animation="smooth"
              text="SaftCloud POS"
            ></vue-typer>
          </div>

          <v-card flat color="transparent" width="600">
            <h1 class=" white--text ">
              Upgrade your business to the next-generation Point of Sales in the
              cloud.
            </h1>

            <h3 class=" white--text mt-10" style="font-weight:100">
              Upgrade your business to the next-generation Point of Sales in the
              cloud. Upgrade your business to the next-generation Point of Sales
              in the cloud. Upgrade your business to the next-generation Point
              of Sales in the cloud. Upgrade your business to the
              next-generation Point of Sales in the cloud.
            </h3>
            <div class="mt-8">
              <v-btn to="/signup" x-large color="teal accent-1"
                >Try it for free</v-btn
              >
              <v-btn x-large class="my-1 mx-sm-1">Contact Sales</v-btn>
            </div>
          </v-card>
          <div
            style="position:absolute;top:85%;right:10%"
            class=" text-right align-end justify-end"
          >
            <v-btn outlined fab small color="white" class="ml-2">
              <v-icon>mdi-twitter</v-icon>
            </v-btn>
            <v-btn outlined fab small color="white" class="ml-2">
              <v-icon>mdi-linkedin</v-icon>
            </v-btn>
            <v-btn outlined fab small color="white" class="ml-2">
              <v-icon>mdi-instagram</v-icon>
            </v-btn>
          </div>
        </v-row>
      </v-container>
    </v-img>
    <Feature2 />
    <Feature1 />
    <CallToAction />
  </div>
</template>

<script>
import { VueTyper } from "vue-typer";
import Feature1 from "@/components/landing/Feature1.vue";
import CallToAction from "@/components/landing/CallToAction.vue";
import Feature2 from "@/components/landing/Feature2.vue";

export default {
  name: "Homepage",
  components: {
    VueTyper,
    Feature1,
    Feature2,
    CallToAction
  }
};
</script>

<style>
.vue-typer {
  font-family: monospace;
}

.vue-typer .custom.char {
  color: white;
}
.vue-typer .custom.char.selected {
  background-color: #264f78;
}

.vue-typer .custom.caret {
  width: 10px;
  background-color: #3f51b5;
}
</style>
