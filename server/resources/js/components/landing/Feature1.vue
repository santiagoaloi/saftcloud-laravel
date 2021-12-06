<template>
  <vue-diagonal
    class="w-full"
    :deg="-7"
    background="linear-gradient(331deg, rgba(57, 62, 87, 1) 0%, rgba(98, 108, 158, 1) 50%)"
    space-before
  >
    <v-container>
      <v-card>
        <v-row align="center" justify="start">
          <v-col cols="12" lg="4">
            <v-img src="storage/img4.jpg" height="300" />
          </v-col>

          <v-col lg="7">
            <v-container fluid>
              <h2 class="mb-2 mb-5">We want to talk to you 2</h2>
              <div class="text-h6">
                We will hire hundreds of people who read these words. We cannot possibly succeed in our goals without doing so. We
                would be
              </div>
              <v-btn x-large class="mt-6 white--text" color="blue-grey darken-2"> Write to us </v-btn>
            </v-container>
          </v-col>
        </v-row>
      </v-card>
      <div data-aos="fade-up" class="d-flex justify-center py-10">
        <v-card class="pa-10 cursor-pointer" flat width="100%">
          <v-row align="center" justify="center">
            <v-col cols="12" lg="6">
              <div class="text-uppercase font-weight-bold body-2 primary--text mb-2 mt-0 mt-xl-10">
                Create your own ecomerce site and start selling in no time
              </div>
              <h2>ecomerce at your fingertips</h2>
              <div class="text-h6 mt-5">
                Start selling your products online with a dedicated shopping cart site for your business. Customize the layouts,
                themes, banners using a straight forward drag-and-drop elements out of the box. Integrate third party payment
                vendors like stripe or paypal.
              </div>
            </v-col>
            <v-col cols="12" lg="6">
              <v-img contain src="storage/ecomerce.png" max-height="400" />
            </v-col>
          </v-row>
        </v-card>
      </div>
      <div class="d-flex justify-center py-10">
        <v-card color="transparent" flat width="100%">
          <v-row>
            <v-col sm="6">
              <div data-aos="fade-up" class="d-flex justify-center py-10">
                <v-card class="cursor-pointer" width="100%">
                  <v-row align="center" justify="start">
                    <v-col cols="12" lg="5">
                      <v-img src="storage/img4.jpg" height="280" />
                    </v-col>

                    <v-col lg="7">
                      <v-container fluid>
                        <h2 class="mb-2 mb-5">Security</h2>
                        <div class="text-h6">
                          We will hire hundreds of people who read these words. We cannot possibly succeed i
                        </div>
                      </v-container>
                    </v-col>
                  </v-row>
                </v-card>
              </div>
            </v-col>
            <v-col sm="6">
              <div data-aos="fade-up" class="d-flex justify-center py-10">
                <v-card class="cursor-pointer" width="100%">
                  <v-row align="center" justify="start">
                    <v-col cols="12" lg="5">
                      <v-img src="storage/img4.jpg" height="280" />
                    </v-col>

                    <v-col lg="7">
                      <v-container fluid>
                        <h2 class="mb-2 mb-5">24/7 Support</h2>
                        <div class="text-h6">We will hire hundreds of people who read these words. We cannot possib would be</div>
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
<script>
  export default {
    name: 'Feature1',
    data: () => ({
      isIntersecting: false,
    }),
    methods: {
      onIntersect(entries, observer) {
        // More information about these options
        // is located here: https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API
        this.isIntersecting = entries[0].intersectionRatio >= 0.5;
      },
    },
  };
</script>
