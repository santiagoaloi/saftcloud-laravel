<template>
  <div>
    <div class="hero-container">
      <!-- <video src="storage/videos/video-1.mp4" autoPlay loop muted /> -->
      <v-container>
        <div style="z-index: 2">
          <v-sheet height="100%" color="transparent">
            <div class="d-flex flex-column justify-center">
              <div style="z-index: 2" class="text-shadow font-weight-black text-h4 text-sm-h3 text-md-h2 text-lg-h1">
                <vue-typer :pre-type-delay="1000" :type-delay="90" :repeat="0" caret-animation="smooth" text="SaftCloud POS" />
              </div>

              <v-card flat color="transparent" width="600">
                <h1 class="text-shadow">Upgrade your business to the next-generation Point of Sales in the cloud.</h1>

                <h3 class="text-shadow white--text mt-2" style="font-weight: 100">
                  Saftcloud ™ is a cloud-based retail software platform that enables retailers speed up sales, manage inventories,
                  reward customer loyalty and garner insights into their businesses in real-time. The platform makes it easy to
                  add new outlets and registers as your business grows.
                </h3>

                <h3 class="text-shadow indigo--text text--lighten-4 mt-4">
                  Designed for multi-outlet retailers, Saftcloud ™ ensures that your business operates as one cohesive operation.
                </h3>

                <div class="mt-8">
                  <v-btn class="hoverElevationSoft" to="/Signup" dark x-large color="primary"> Try it for free </v-btn>
                  <v-btn dark x-large class="my-1 mx-sm-1 hoverElevationSoft"> Contact Sales </v-btn>
                </div>
              </v-card>
              <div data-aos-once="true" data-aos-delay="600" data-aos="fade-up" style="position: absolute; margin-left: 380px">
                <v-img contain src="storage/header/1.png" height="580" :transition="false" />
              </div>
            </div>
          </v-sheet>
        </div>
      </v-container>
    </div>

    <!-- <v-carousel height="100%" :show-arrows="false" hide-delimiters cycle>
      <v-container class="pa-0">
        <v-sheet height="100%" color="transparent" style="z-index: 4 !important; position: absolute">
          <v-container class="fill-height">
            <div class="d-flex flex-column justify-center">
              <div style="z-index: 2" class="text-shadow font-weight-black text-h4 text-sm-h3 text-md-h2 text-lg-h1">
                <vue-typer :pre-type-delay="1000" :type-delay="90" :repeat="0" caret-animation="smooth" text="SaftCloud POS" />
              </div>

              <v-card flat color="transparent" width="600">
                <h1 class="text-shadow">Upgrade your business to the next-generation Point of Sales in the cloud.</h1>

                <h3 class="text-shadow white--text mt-2" style="font-weight: 100">
                  Saftcloud ™ is a cloud-based retail software platform that enables retailers speed up sales, manage inventories,
                  reward customer loyalty and garner insights into their businesses in real-time. The platform makes it easy to
                  add new outlets and registers as your business grows.
                </h3>

                <h3 class="text-shadow indigo--text text--lighten-4 mt-4">
                  Designed for multi-outlet retailers, Saftcloud ™ ensures that your business operates as one cohesive operation.
                </h3>

                <div class="mt-8">
                  <v-btn class="hoverElevationSoft" to="/Signup" dark x-large color="primary"> Try it for free </v-btn>
                  <v-btn dark x-large class="my-1 mx-sm-1 hoverElevationSoft"> Contact Sales </v-btn>
                </div>
              </v-card>
              <div data-aos-once="true" data-aos-delay="600" data-aos="fade-up" style="position: absolute; margin-left: 380px">
                <v-img contain src="storage/header/1.png" height="580" :transition="false" />
              </div>
            </div>
          </v-container>
        </v-sheet>
      </v-container>

      <v-carousel-item v-for="(slide, i) in slides" :key="i">
        <v-img
          :height="height"
          :transition="false"
          gradient="to top right, rgba(100,115,201,0.4), rgba(25,32,72,1)"
          :src="slide.src"
          eager
          @load="imageLoaded = true"
        >
          <template #placeholder>
            <v-row class="fill-height ma-0" align="center" justify="center">
              <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
            </v-row>
          </template>
        </v-img>
      </v-carousel-item>
    </v-carousel> -->

    <Feature2 />
    <Feature1 />
  </div>
</template>

<script>
  import { VueTyper } from 'vue-typer';

  export default {
    name: 'Homepage',
    components: {
      VueTyper,
      Feature1: () => import(/* webpackChunkName: 'feature' */ '@/components/Landing/Feature1'),
      Feature2: () => import(/* webpackChunkName: 'feature2' */ '@/components/Landing/Feature2'),
    },

    data() {
      return {
        imageLoaded: false,
        slides: [
          { src: 'storage/backgrounds/main2.jpg' },
          { src: 'storage/backgrounds/main3.jpg' },
          { src: 'storage/backgrounds/main4.jpg' },
        ],
      };
    },

    computed: {
      height() {
        return `${this.$vuetify.breakpoint.height - this.$vuetify.application.top}px`;
      },
    },
  };
</script>

<style>
  .vue-typer {
    font-family: 'Raleway', sans-serif;
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

  video {
    object-fit: cover;
    width: 100%;
    height: 100%;
    position: fixed;
  }

  .hero-container {
    /* background: url('/images/img-home.jpg') center center/cover no-repeat; */
    height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: start;
    box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.2);
    object-fit: contain;
  }

  .hero-container > h1 {
    color: #fff;
    font-size: 100px;
    margin-top: -100px;
  }

  .hero-container > p {
    margin-top: 8px;
    color: #fff;
    font-size: 32px;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
  }

  @media screen and (max-width: 960px) {
    .hero-container > h1 {
      font-size: 70px;
      margin-top: -150px;
    }
  }

  @media screen and (max-width: 768px) {
    .hero-container > h1 {
      font-size: 50px;
      margin-top: -100px;
    }

    .hero-container > p {
      font-size: 30px;
    }
  }
</style>
