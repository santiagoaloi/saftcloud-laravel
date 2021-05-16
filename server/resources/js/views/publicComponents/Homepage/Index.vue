<template>
    <div>
        <div style="margin-top:-80px;" :style="headerBackground">
            <v-container
                fluid
                data-aos="fade"
                data-aos-anchor-placement="center-bottom"
                data-aos-delay="300"
                data-aos-once="true"
                data-aos-easing="linear"
                data-aos-duration="400"
                class="text-center"
                style="padding-top: 10%; padding-bottom: 100px"
            >
                <v-img
                    eager
                    style="position:fixed;left:60%;top:-10%"
                    contain
                    height="900"
                    :src="imageRightHeader"
                />

                <h1
                    class="font-weight-black text-h4 text-sm-h3 text-md-h2 text-lg-h1"
                >
                    <vue-typer
                        pre-type-delay="1000"
                        type-delay="90"
                        :repeat="false"
                        caret-animation="smooth"
                        text="SaftCloud POS"
                    ></vue-typer>
                </h1>
                <h2
                    class=" white--text text-h6 text-sm-h5 mt-4 w-full w-md-8-12 w-xl-half mx-auto"
                >
                    Upgrade your business to the next-generation Point of Sales
                    in the cloud.
                </h2>
                <div class="mt-8">
                    <v-btn to="/signup" x-large color="teal accent-1"
                        >Try it for free</v-btn
                    >
                    <v-btn x-large class="my-1 mx-sm-1 w-full w-sm-auto"
                        >Contact Sales</v-btn
                    >
                </div>
            </v-container>

            <!-- <svg
                width="100%"
                height="100%"
                viewBox="0 0 1366 1366"
                preserveAspectRatio="none"
                :style="svgBackground"
                style="pointer-events:none"
            >
                <rect
                    style="margin-top:-150px"
                    viewBox="0 0 1366 1366"
                    fill="url(#backgroundGradient)"
                    width="100%"
                    height="100%"
                ></rect>
                <path d="M0 0 H2732" id="motion" />
                <path d="M2732 0 H0" id="motion-reverse" />
                <g fill="#e8d8ed">
                    <g opacity="1">
                        <path
                            d="M821.493,1245.502 C1016.37,1150.47 1215.09,1131 1366,1131 L1366,1365 L0,1365 L0,1295.568 C281.988431,1295.56995 536.909,1384.278 821.493,1245.502 Z"
                        ></path>
                        <path
                            class="reflect"
                            d="M821.493,1245.502 C1016.37,1150.47 1215.09,1131 1366,1131 L1366,1365 L0,1365 L0,1295.568 C281.988431,1295.56995 536.909,1384.278 821.493,1245.502 Z"
                        ></path>
                        <path
                            class="translate"
                            d="M821.493,1245.502 C1016.37,1150.47 1215.09,1131 1366,1131 L1366,1365 L0,1365 L0,1295.568 C281.988431,1295.56995 536.909,1384.278 821.493,1245.502 Z"
                        ></path>
                        <animateMotion
                            dur="80s"
                            repeatCount="indefinite"
                            rotate="auto"
                            keyPoints="0;0.5;0.75"
                            keyTimes="0;0.33;0.66"
                            calcMode="linear"
                        >
                            <mpath xlink:href="#motion" />
                        </animateMotion>
                    </g>
                    <g opacity="1">
                        <path
                            d="M1366,1142 L1366,1365 L0,1365 L0,1305.90997 C221.894,1305.91495 536.909,1396.171 821.493,1270.283 C1016.37,1184.077 1215.09,1142 1366,1142 Z"
                        ></path>
                        <path
                            class="reflect"
                            d="M1366,1142 L1366,1365 L0,1365 L0,1305.90997 C221.894,1305.91495 536.909,1396.171 821.493,1270.283 C1016.37,1184.077 1215.09,1142 1366,1142 Z"
                        ></path>
                        <path
                            class="translate"
                            d="M1366,1142 L1366,1365 L0,1365 L0,1305.90997 C221.894,1305.91495 536.909,1396.171 821.493,1270.283 C1016.37,1184.077 1215.09,1142 1366,1142 Z"
                        ></path>

                        <animateMotion
                            dur="80s"
                            repeatCount="indefinite"
                            rotate="auto-reverse"
                            keyPoints="0;0.7;0.66"
                            keyTimes="0;0.33;0.66"
                        >
                            <mpath xlink:href="#motion-reverse" />
                        </animateMotion>
                    </g>
                    <g opacity="0.08">
                        <path
                            d="M634.493,1300.928 C842.464506,1248.14173 1215.09,1180 1366,1180 L1366,1365.115 L0,1365.115 L0,1335.403 C236.5,1335.40002 452.004736,1347.24625 634.493,1300.928 Z"
                        ></path>
                        <path
                            class="reflect"
                            d="M634.493,1300.928 C842.464506,1248.14173 1215.09,1180 1366,1180 L1366,1365.115 L0,1365.115 L0,1335.403 C236.5,1335.40002 452.004736,1347.24625 634.493,1300.928 Z"
                        ></path>
                        <path
                            class="translate"
                            d="M634.493,1300.928 C842.464506,1248.14173 1215.09,1180 1366,1180 L1366,1365.115 L0,1365.115 L0,1335.403 C236.5,1335.40002 452.004736,1347.24625 634.493,1300.928 Z"
                        ></path>
                        <animateMotion
                            dur="90s"
                            repeatCount="indefinite"
                            rotate="auto"
                            keyPoints="0;1;0"
                            keyTimes="0;0.5;1"
                            calcMode="linear"
                        >
                            <mpath xlink:href="#motion" />
                        </animateMotion>
                    </g>
                </g>
            </svg> -->
        </div>

        <!-- <Partners /> -->
        <!-- <Stats /> -->

        <Feature1 />
        <Feature2 />

        <!-- <Feature2 /> -->

        <!-- <Partners />

    <Pricing /> -->
        <CallToAction />
    </div>
</template>

<script>
import { get, sync, call, set } from "vuex-pathify";
import { VueTyper } from "vue-typer";

import Partners from "@/components/landing/Partners.vue";
import Stats from "@/components/landing/Stats.vue";
import Pricing from "@/components/landing/Pricing.vue";
import Feature1 from "@/components/landing/Feature1.vue";
import CallToAction from "@/components/landing/CallToAction.vue";
import Feature2 from "@/components/landing/Feature2.vue";

export default {
    name: "Homepage",
    components: {
        VueTyper,
        Partners,
        Stats,
        Pricing,
        Feature1,
        Feature2,
        CallToAction
    },

    data() {
        return {};
    },

    mounted() {
        // store.set("snackbar/value", true);
        // store.set("snackbar/snackbar@text", "hello");
    },

    computed: {
        headerBackground() {
            return {
                "background-image": `url(storage/header-bg.svg)`,
                "background-repeat": "no-repeat",
                "background-size": "cover",
                height:
                    this.$vuetify.breakpoint.height -
                    this.$vuetify.application.top +
                    80 +
                    "px"
            };
        },
        svgBackground() {
            return {
                "background-image": `url(storage/login.jpg)`,
                "background-repeat": "no-repeat",
                "background-size": "cover",
                opacity: "0.2",
                filter: "grayscale(100%)"
            };
        },
        imageRightHeader() {
            return "storage/right2.png";
        }
    },

    methods: {
        onIntersect(entries, observer, isIntersecting) {},
    }
};
</script>

<style>
.reflect {
    transform: scaleX(-1);
}
.translate {
    transform: translateX(-200%);
}

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
