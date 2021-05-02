<template>
    <div>
        <v-sheet>
            <v-container
                data-aos="fade"
                data-aos-anchor-placement="center-bottom"
                data-aos-delay="300"
                data-aos-once="true"
                data-aos-easing="linear"
                data-aos-duration="400"
                class="text-center"
                style="padding-top: 100px; padding-bottom: 100px"
            >
                <h1 class="text-h4 text-sm-h3 text-md-h2 text-lg-h1">
                    SaftCloud<span class="primary--text"> xxxxxxxxxx</span>
                </h1>
                <h2
                    class="text-h6 text-sm-h5 mt-4 w-full w-md-8-12 w-xl-half mx-auto"
                >
                    Upgrade yoursss dbusiness to the next-generation point of
                    sales in the cloud.
                </h2>
                <div class="mt-8">
                    <router-link to="/signup">
                        <v-btn
                            x-large
                            class="my-1 mx-sm-1 w-full w-sm-auto"
                            color="primary"
                            >Start free trial</v-btn
                        >
                    </router-link>
                    <v-btn x-large class="my-1 mx-sm-1 w-full w-sm-auto"
                        >Contact Sales</v-btn
                    >
                </div>
            </v-container>
        </v-sheet>

        <Partners />
        <Stats />

        <!-- <v-container>
      <v-divider />
    </v-container> -->

        <!-- <Feature2 /> -->
        <Feature1 />

        <Partners />

        <Pricing />
        <CallToAction />
    </div>
</template>

<script>
import Partners from "@/components/landing/Partners.vue";
import Stats from "@/components/landing/Stats.vue";
import Pricing from "@/components/landing/Pricing.vue";
import Feature1 from "@/components/landing/Feature1.vue";
import CallToAction from "@/components/landing/CallToAction.vue";
import Feature2 from "@/components/landing/Feature2.vue";

export default {
    name: "Homepage",
    components: {
        Partners,
        Stats,
        Pricing,
        Feature1,
        Feature2,
        CallToAction
    },

    methods: {
        onIntersect(entries, observer, isIntersecting) {}
    }
};
</script>
