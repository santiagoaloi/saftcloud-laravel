<template>
    <div>
        <v-app-bar color="#24292e" app flat height="80">
            <!-- <v-container class="py-0 px-0 px-sm-2 fill-height"> -->
            <div
                data-aos="fade"
                data-aos-anchor-placement="center-bottom"
                data-aos-delay="300"
                data-aos-once="true"
                data-aos-easing="linear"
                data-aos-duration="400"
            >
                <router-link
                    to="/"
                    class="d-flex align-center text-decoration-none"
                >
                    <img class="mr-4" src="storage/logo2.png" height="40" />
                    <span class="headline grey--text"> SaftCloud</span>
                </router-link>
            </div>

            <v-spacer></v-spacer>

            <router-link
                to="/signup"
                class="d-flex align-center text-decoration-none mr-2"
            >
                <v-btn height="36" class="mr-3" rounded color="primary"
                    >Sign up</v-btn
                >
            </router-link>
            <template v-if="!isLoggedIn">
                <v-chip to="/login" link>
                    <v-avatar left>
                        <v-img :src="getAvatarSoruce()"></v-img>
                    </v-avatar>
                    Login
                </v-chip>
            </template>

            <v-menu
                v-if="isLoggedIn"
                rounded="xl"
                origin="center center"
                transition="scale-transition"
                :nudge-bottom="10"
                offset-y
            >
                <template v-slot:activator="{ on }">
                    <v-chip v-on="on">
                        <v-avatar left>
                            <v-img :src="getAvatarSoruce()"></v-img>
                        </v-avatar>
                        {{ profile.first_name }}
                    </v-chip>
                </template>
                <v-card
                    color="rgba(250, 250, 250, 1)"
                    class="mx-auto pa-2"
                    max-width="300"
                    rounded="xl"
                >
                    <v-list
                        rounded="xl"
                        color="rgba(250, 250, 250, 1)"
                        outlined
                    >
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img :src="getAvatarSoruce()"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ profile.first_name }}
                                    {{ profile.last_name }}</v-list-item-title
                                >
                                <v-list-item-subtitle>{{
                                    sessionEmail
                                }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-list
                        rounded="xl"
                        color="rgba(250, 250, 250, 1)"
                        outlined
                    >
                        <v-list-item to="/login">
                            <v-list-item-action>
                                <v-icon>mdi-view-dashboard-outline</v-icon>
                            </v-list-item-action>
                            <v-list-item-subtitle
                                >POS Console</v-list-item-subtitle
                            >
                        </v-list-item>
                        <v-list-item @click="logout()">
                            <v-list-item-action>
                                <v-icon>mdi-logout</v-icon>
                            </v-list-item-action>
                            <v-list-item-subtitle>Log Out</v-list-item-subtitle>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
            <!-- </v-container> -->
        </v-app-bar>
    </div>
</template>

<script>
import { store } from "@/store";
import axios from "axios";
import globalMixin from "@/mixins/globalMixin";
import { mapActions } from "vuex";

export default {
    name: "PublicAppbar",
    mixins: [globalMixin],

    data() {
        return {
            responsiveMenu: false,
            store: store,
            navMenu: [
                {
                    name: "aktuellt",
                    href: "pub_aktuellt",
                    disabled: false
                },
                {
                    name: "Portfolio",
                    href: "portfolio",
                    disabled: false
                },
                {
                    name: "Bli medlem",
                    href: "medlem",
                    disabled: false
                },
                {
                    name: "Press",
                    href: "press",
                    disabled: false
                },
                {
                    name: "Om oss",
                    href: "om",
                    disabled: false
                },
                {
                    name: "Kontakt",
                    href: "kontakt",
                    disabled: false
                },
                {
                    name: "English",
                    href: "english",
                    disabled: false
                }
            ]
        };
    },

    computed: {
        profile() {
            return store.state.sessionData.userProfile;
        }
    },

    methods: {
        ...mapActions(["logoutVuex", "clearPublicData"]),

        logout() {
            this.clearPublicData();
            this.logoutVuex();
        },

        getAvatarSoruce() {
            if (this.isLoggedIn) {
                return `${this.profile.avatar}`;
            } else {
                return `${this.uploadPath}/cms/avatar.png`;
            }
        }
    }
};
</script>

<style scoped lang="scss">
.v-chip.v-size--default {
    height: 36px;
}

.header-logo:hover {
    opacity: 0.8;
}
.userLink {
    letter-spacing: 1px;
    text-transform: uppercase;
    font-weight: 600;
    font-size: 13px;
    color: black;
    &:hover {
        color: #909090;
        visibility: visible;
    }
}

.menuActive {
    letter-spacing: 1px;
    position: relative;
    text-decoration: none;
    font-weight: 300;
    font-size: 13px;
    color: #909090;
    transition: all 0.35s ease;

    &::before {
        content: "";
        position: absolute;
        width: 95%;
        height: 0.8px;
        bottom: -10px;
        left: 0;
        background-color: #606060;
        visibility: visible;
        -webkit-transform: scaleX(1.1);
        transform: scaleX(1.1);
    }

    &:hover {
        color: #909090;

        &::before {
            visibility: visible;
            -webkit-transform: scaleX(1.1);
            transform: scaleX(1.1);
        }
    }
}

.menu {
    letter-spacing: 1px;
    position: relative;
    text-decoration: none;
    font-weight: 300;
    font-size: 13px;
    color: black;
    transition: all 0.35s ease;

    &::before {
        content: "";
        position: absolute;
        width: 95%;
        height: 0.8px;
        bottom: -10px;
        left: 0;
        background-color: #606060;
        visibility: hidden;
    }

    &::before {
        content: "";
        position: absolute;
        width: 95%;
        height: 0.8px;
        bottom: -10px;
        left: 0;
        background-color: #606060;
        visibility: hidden;
    }

    &:hover {
        color: #909090;

        &::before {
            visibility: visible;
            -webkit-transform: scaleX(1.1);
            transform: scaleX(1.1);
        }
    }
}

.capitalLetters {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 13px;
}
.menu-option:last-child {
    padding-right: 12px !important;
}
.v-toolbar {
    transition-duration: 0s, 0s, 0s, 0s, 0ms, 0s, 0s;
}

.responsiveMenu {
    position: fixed;
    top: 100px;
    right: 0;
    width: 200px;
    z-index: 1;
    .menu-item {
        display: flex;
        justify-content: flex-end;
    }
}

::v-deep .v-toolbar__content,
.v-toolbar__extension {
    border-bottom: 1px solid #ccc;
}

@media screen and (min-width: 960px) {
    .responsiveMenu {
        top: 120px;
    }
}
</style>
