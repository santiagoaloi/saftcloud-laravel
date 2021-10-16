<template>
  <vue-diagonal
    :deg="-7"
    background="linear-gradient(331deg, rgba(101, 235, 235, 1) 0%, rgba(54, 49, 125, 1) 50%)"
    space-after
  >
    <v-container style="padding-top: 60px; padding-bottom: 200px">
      <v-responsive max-width="1200" class="mx-auto text-center">
        <h2 class="text-h3 mb-2 white--text">Pricing</h2>
        <div class="text-h6 text-lg-h5 white--text">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus impedit error labore
          doloremque fugit.
        </div>
      </v-responsive>

      <v-row class="mt-10">
        <v-col v-for="(plan, i) in plans" :key="i" cols="12" lg="4">
          <v-card class="text-body-1 pa-4" outlined elevation="2">
            <div class="d-flex justify-space-between">
              <div class="mr-2">
                <div class="d-flex align-center">
                  <div class="text-h4 font-weight-black">
                    {{ plan.title }}
                  </div>
                  <div v-if="plan.featured" class="ml-2">
                    <v-chip small color="primary" class="font-weight-black"> Popular </v-chip>
                  </div>
                </div>
                <div class="mt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
              </div>
              <div class="text-right">
                <div class="d-flex align-center">
                  <div class="text-h5 font-weight-light mr-1">$</div>
                  <div class="text-h3 text-number font-weight-black">
                    {{ plan.price }}
                  </div>
                </div>
                <div class="justify-end overline">
                  {{ plan.time }}
                </div>
              </div>
            </div>

            <v-divider class="my-4" />

            <div class="text-h6">
              <div
                v-for="(feat, j) in plan.features"
                :key="j"
                class="d-flex align-center justify-space-between my-1"
              >
                <div>
                  <span v-if="feat.value" class="font-weight-black mr-1">{{ feat.value }}</span>
                  <span class="text-truncate font-weight-regular">{{ feat.label }}</span>
                </div>
                <v-icon color="primary"> mdi-check </v-icon>
              </div>
            </div>
            <v-divider class="my-4" />
            <v-btn
              x-large
              block
              :outlined="!plan.featured"
              :color="plan.featured ? 'primary' : ''"
              to="/auth/signup"
            >
              Subscribe
            </v-btn>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </vue-diagonal>
</template>

<script>
  export default {
    data() {
      return {
        plans: [
          {
            title: 'Trial',
            price: 'Free',
            time: '14 days',
            features: [
              {
                value: '2',
                label: 'Accounts',
              },
              {
                value: '100GB',
                label: 'Bandwith',
              },
              {
                value: '10GB',
                label: 'Disk Space',
              },
              {
                value: '',
                label: 'Unlimited Emails',
              },
            ],
          },
          {
            title: 'Startup',
            price: '49',
            featured: true,
            time: '/month',

            features: [
              {
                value: '20',
                label: 'Accounts',
              },
              {
                value: '1TB',
                label: 'Bandwith',
              },
              {
                value: '100GB',
                label: 'Disk Space',
              },
              {
                value: '',
                label: 'Unlimited Emails',
              },
            ],
          },
          {
            title: 'Enterprise',
            price: '149',
            time: '/month',

            features: [
              {
                value: '100',
                label: 'Accounts',
              },
              {
                value: '10TB',
                label: 'Bandwith',
              },
              {
                value: '10TB',
                label: 'Disk Space',
              },
              {
                value: '',
                label: 'Unlimited Emails',
              },
            ],
          },
        ],
      };
    },
  };
</script>
