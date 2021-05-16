<template>
  <vue-diagonal
    :deg="-7"
    background="linear-gradient(331deg, rgba(101, 235, 235, 1) 0%, rgba(54, 49, 125, 1) 50%)"
    space-after
    space-before
  >
    <v-container>
      <div class="d-flex justify-center py-10">
        <v-card
          color="white"
          data-aos="zoom-in"
          data-aos-delay="40"
          data-aos-once="false"
          data-aos-easing="linear"
          data-aos-duration="350"
          data-aos-anchor-placement="top"
          width="80vw"
        >
          <v-row align="center" justify="start">
            <v-col cols="12" lg="4">
              <v-img eager src="storage/team.jpg" height="280"></v-img>
            </v-col>

            <v-col lg="7">
              <v-container fluid>
                <h2 class="text-h3 mb-2 black--text mb-5">
                  We want to talk to you
                </h2>
                <div class="text-h6 text-lg-h5 black--text">
                  We will hire hundreds of people who read these words. We
                  cannot possibly succeed in our goals without doing so. We
                  would be
                </div>
                <v-btn
                  x-large
                  class="mt-6 white--text"
                  color="blue-grey darken-2"
                  >Write to us</v-btn
                >
              </v-container>
            </v-col>
          </v-row>
        </v-card>
      </div>

      <div class="d-flex justify-center">
        <v-card
          color="white"
          data-aos="zoom-in"
          data-aos-delay="40"
          data-aos-once="false"
          data-aos-easing="linear"
          data-aos-duration="350"
          data-aos-anchor-placement="top"
          class="pa-10"
          width="80vw"
        >
          <v-row align="center" justify="center">
            <v-col cols="12" lg="6">
              <div
                class="text-uppercase font-weight-bold body-2 primary--text mb-2 mt-0 mt-xl-10"
              >
                Create your own ecomerce site and start selling in no time
              </div>
              <h2 class="text-h3">
                ecomerce at your fingertips
              </h2>
              <div class="text-h6 text-lg-h5 mt-5">
                Start selling your products online with a dedicated shopping
                cart site for your business. Customize the layouts, themes,
                banners using a straight forward drag-and-drop elements out of
                the box. Integrate third party payment vendors like stripe or
                paypal.
              </div>
            </v-col>
            <v-col cols="12" lg="6">
              <v-img
                contain
                eager
                src="storage/ecomerce.png"
                max-height="400"
              ></v-img>
            </v-col>
          </v-row>
        </v-card>
      </div>

      <div class="d-flex justify-center">
        <v-card flat color="transparent" width="80vw">
          <v-row>
            <v-col sm="6">
              <div class="d-flex justify-center py-10">
                <v-card
                  color="white"
                  data-aos="zoom-in"
                  data-aos-delay="40"
                  data-aos-once="false"
                  data-aos-easing="linear"
                  data-aos-duration="350"
                  data-aos-anchor-placement="top"
                  width="80vw"
                >
                  <v-row align="center" justify="start">
                    <v-col cols="12" lg="5">
                      <v-img eager src="storage/team.jpg" height="280"></v-img>
                    </v-col>

                    <v-col lg="7">
                      <v-container fluid>
                        <h2 class="text-h3 mb-2 black--text mb-5">
                          Security
                        </h2>
                        <div class="text-h6 text-lg-h5 black--text">
                          We will hire hundreds of people who read these words.
                          We cannot possibly succeed i
                        </div>
                      </v-container>
                    </v-col>
                  </v-row>
                </v-card>
              </div>
            </v-col>
            <v-col sm="6">
              <div class="d-flex justify-center py-10">
                <v-card
                  color="white"
                  data-aos="zoom-in"
                  data-aos-delay="40"
                  data-aos-once="false"
                  data-aos-easing="linear"
                  data-aos-duration="350"
                  data-aos-anchor-placement="top"
                  width="80vw"
                >
                  <v-row align="center" justify="start">
                    <v-col cols="12" lg="5">
                      <v-img eager src="storage/team.jpg" height="280"></v-img>
                    </v-col>

                    <v-col lg="7">
                      <v-container fluid>
                        <h2 class="text-h3 mb-2 black--text mb-5">
                          24/7 Support
                        </h2>
                        <div class="text-h6 text-lg-h5 black--text">
                          We will hire hundreds of people who read these words.
                          We cannot possib would be
                        </div>
                      </v-container>
                    </v-col>
                  </v-row>
                </v-card>
              </div>
            </v-col>
          </v-row>
        </v-card>
      </div>
    </v-container>
  </vue-diagonal>
</template>

<style scoped lang="scss">
// .test {
//   background: linear-gradient(-555deg, #cedaec 60%, rgb(71, 60, 114) 60%);
// }
</style>
