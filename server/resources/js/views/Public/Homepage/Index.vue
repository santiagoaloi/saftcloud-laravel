<template>
 <div>
  <v-sheet class="d-flex flex-column justify-center transparent" min-height="90vh">
   <v-container>
    <div class="d-flex flex-column justify-center">
     <div class="text-shadow font-weight-black text-h4 text-sm-h3 text-md-h2 text-lg-h1">
      <vue-typer :pre-type-delay="1000" :type-delay="90" :repeat="0" caret-animation="smooth" text="SaftCloud POS"></vue-typer>
     </div>

     <v-card flat color="transparent" width="600">
      <h1 class=" text-shadow  white--text ">
       Upgrade your business to the next-generation Point of Sales in the cloud.
      </h1>

      <h3 class=" text-shadow white--text mt-10" style="font-weight:100">
       Saft is a cloud-based retail software platform that enables retailers speed up sales, manage inZventories, reward customer loyalty, and garner
       insights into their businesses in real-time. The platform makes it easy to add new outlets and registers as your business grows. Designed for
       multi-outlet retailers, Vend ensures that your business operates as one cohesive operation.
      </h3>
      <div class="mt-8">
       <v-btn class="hoverElevationSoft" to="/signup" dark x-large color="primary">Try it for free</v-btn>
       <v-btn dark x-large class="my-1 mx-sm-1 hoverElevationSoft">Contact Sales</v-btn>
      </div>
     </v-card>
     <div style="position:absolute;top:85%;right:10%" class=" text-right align-end justify-end">
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
    </div>
   </v-container>
  </v-sheet>
  <Feature2 />
  <Feature1 />
  <CallToAction />
 </div>
</template>

<script>
import { VueTyper } from "vue-typer";
import Feature1 from "@/components/Landing/Feature1.vue";
import CallToAction from "@/components/Landing/CallToAction.vue";
import Feature2 from "@/components/Landing/Feature2.vue";

export default {
 name: "Homepage",
 components: {
  VueTyper,
  Feature1,
  Feature2,
  CallToAction
 },

 data() {
  return {
   delay: true
  };
 },

 mounted() {
  setTimeout(() => {
   this.delay = false;
  }, 400);
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

.hoverElevationSoft {
 border-radius: 8px;
 -webkit-transition-property: color, background-color, -webkit-box-shadow, -webkit-transform;
 transition-property: color, background-color, box-shadow, transform, -webkit-box-shadow, -webkit-transform;
 transition-duration: 0.5s;
 box-shadow: 0 10px 60px -12px rgb(50 50 93 / 25%), 0 18px 36px -18px rgb(0 0 0 / 30%), 0 -12px 36px -8px rgb(0 0 0 / 3%) !important;
}

.hoverElevationSoft:hover {
 transform: translateY(1.5px) !important;
 box-shadow: 0 13px 27px -5px rgb(50 50 93 / 25%), 0 8px 16px -8px rgb(0 0 0 / 30%), 0 -6px 16px -6px rgb(0 0 0 / 3%) !important;
}

#outer {
 display: flex;
 flex-flow: column;
 height: 100%;
}

::v-deep .inner_fixed {
 height: 100px !important;
 background-color: grey;
}

#inner_remaining {
 background-color: #dddddd;
 flex-grow: 1;
}
</style>
