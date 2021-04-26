<template>
  <v-container
    data-aos="fade"
    data-aos-anchor-placement="center-bottom"
    data-aos-delay="300"
    data-aos-once="true"
    data-aos-easing="linear"
    data-aos-duration="400"
    style="padding-top: 200px; padding-bottom: 200px"
  >
    <v-row>
      <v-col v-for="(item, i) in features" :key="i" cols="12" md="6">
        <div class="d-flex">
          <div class="mr-2">
            <v-sheet outlined rounded class="pa-2 elevation-1">
              <v-icon>{{ item.icon }}</v-icon>
            </v-sheet>
          </div>
          <div>
            <div class="text-h5">{{ item.title }}</div>
            <div class="text-h6 font-weight-light mt-1">
              {{ item.description }}
            </div>
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      features: [
        {
          icon: "mdi-account-check-outline",
          title: "Account Verification",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse expedita fugit quam aliquam. Autem assumenda",
        },
        {
          icon: "mdi-lifebuoy",
          title: "Dedicated Support",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse expedita fugit quam aliquam. Autem assumenda",
        },
        {
          icon: "mdi-email-open-multiple-outline",
          title: "Email Integration",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse expedita fugit quam aliquam. Autem assumenda",
        },
        {
          icon: "mdi-clock-outline",
          title: "Save Time",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse expedita fugit quam aliquam. Autem assumenda",
        },
      ],
    };
  },
};
</script>
