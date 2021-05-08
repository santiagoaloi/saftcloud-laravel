<template>
  <div>
    <v-container
      data-aos="fade"
      data-aos-delay="300"
      :style="'min-height:' + (screenHeight - $vuetify.application.top) + 'px;'"
      class="fill-height"
    >
      <v-row align="center" justify="center">
        <v-col cols="12" lg="6">
          <v-row class="mt-10" no-gutters align="center" justify="center">
            <div class="topFont topSlide shadows mx-10" style="color: white">
              <!-- {{ siteInfo.companyName }} -->
              Company Name
            </div>
          </v-row>

          <v-row class="mt-2" no-gutters align="center" justify="center">
            <div class="subFont topSlide shadows mx-10" style="color: white">
              <!-- {{ siteInfo.companySlogan }} -->
              Company Slogan
            </div>
          </v-row>
        </v-col>

        <v-fade-transition hide-on-leave>
          <ValidationObserver ref="authForm" slim>
            <v-col
              v-if="!resetPasswordScreen && !forgot"
              cols="12"
              sm="12"
              md="12"
              lg="6"
            >
              <v-card
                :color="
                  $vuetify.breakpoint.mdAndUp
                    ? 'rgba(200, 200, 200,  0.1)'
                    : 'transparent'
                "
                style="border-radius: 21px"
              >
                <v-card-subtitle class="white--text">
                  <!-- Enter your login details to access you account. , Doesnt need to exist -->
                </v-card-subtitle>
                <v-card-subtitle class="white--text mb-n10">
                  Don't have an account?
                  <v-btn
                    style="margin-top: -2.3px"
                    text
                    small
                    color="white"
                    @click="signup = !signup"
                  >
                    Create new account
                  </v-btn>
                </v-card-subtitle>

                <div style="width: 100%" class="px-4">
                  <v-row>
                    <v-col cols="12" sm="12" md="12" />

                    <v-col cols="12" sm="6" md="12">
                      <validation-provider
                        v-slot="{ errors }"
                        name="Användarnamn"
                        rules="required"
                      >
                        <v-text-field
                          ref="username"
                          v-model.trim="username"
                          hide-details
                          solo
                          autofocus
                          placeholder="Användarnamn"
                          color="#57AEB1"
                          prepend-inner-icon="mdi-account"
                          name="User"
                          label="User account"
                          type="text"
                          :disabled="loading"
                          :background-color="
                            errors.length > 0 ? '#faebeb' : 'white'
                          "
                          :error-messages="errors[0]"
                          @keydown.enter.prevent="authenticate()"
                          @keydown.space.prevent
                        />
                      </validation-provider>
                    </v-col>

                    <v-col cols="12" sm="6" md="12">
                      <div id="passwordField">
                        <validation-provider
                          v-slot="{ errors }"
                          name="Användarnamn"
                          rules="required"
                        >
                          <v-text-field
                            v-model.trim="password"
                            hide-details
                            solo
                            color="#57AEB1"
                            label="Password"
                            prepend-inner-icon="mdi-shield-key-outline"
                            placeholder="Lösenord"
                            :type="password_visible ? 'text' : 'password'"
                            :append-icon="
                              password_visible
                                ? 'mdi-eye-off-outline'
                                : 'mdi-eye-outline'
                            "
                            :disabled="loading"
                            :background-color="
                              errors.length > 0 ? '#faebeb' : 'white'
                            "
                            :error-messages="errors[0]"
                            @click:append="password_visible = !password_visible"
                            @keydown.enter.prevent="authenticate()"
                            @keydown.space.prevent
                          />
                        </validation-provider>
                      </div>
                      <v-btn
                        class="mt-3"
                        text
                        small
                        color="white"
                        @click="forgot = true"
                      >
                        Glömt lösenordet?
                      </v-btn>
                    </v-col>

                    <v-col cols="12" sm="12" md="12">
                      <v-card-actions class="mt-n2">
                        <div class="flex-grow-1" />

                        <v-btn
                          class="white--text"
                          :input-value="true"
                          text
                          large
                          @click="checkUser()"
                        >
                          Go back
                        </v-btn>

                        <!-- <v-btn
                          class="mr-n2 white--text"
                          :input-value="true"
                          text
                          large
                          :loading="loading"
                          @click="loginSanctum()"
                        >
                          Logga in
                        </v-btn> -->

                        <v-btn
                          class="mr-n2 white--text"
                          :input-value="true"
                          text
                          large
                          :loading="loading"
                          @click.prevent="registerSanctum()"
                        >
                          Register
                        </v-btn>

                        <v-btn
                          class="mr-n2 white--text"
                          :input-value="true"
                          text
                          large
                          :loading="loading"
                          @click.prevent="loginSanctum()"
                        >
                          Login
                        </v-btn>
                        <v-btn
                          class="mr-n2 white--text"
                          :input-value="true"
                          text
                          large
                          :loading="loading"
                          @click.prevent="checkUser()"
                        >
                          check user
                        </v-btn>
                      </v-card-actions>
                    </v-col>
                  </v-row>
                </div>
              </v-card>
            </v-col>
          </ValidationObserver>
        </v-fade-transition>

        <v-fade-transition hide-on-leave>
          <ValidationObserver ref="accountRecoveryForm" slim>
            <v-col v-if="forgot" :key="0" cols="12" lg="6" sm="8">
              <v-card
                :color="
                  $vuetify.breakpoint.mdAndUp
                    ? 'rgba(200, 200, 200,  0.1)'
                    : 'transparent'
                "
                style="border-radius: 21px"
              >
                <v-card-title class="headline white--text">
                  Having trouble signing in?
                </v-card-title>
                <v-card-subtitle class="white--text">
                  Enter your account to get started.
                </v-card-subtitle>

                <div style="width: 100%" class="px-4">
                  <v-row>
                    <v-col cols="12" sm="12" md="12" />

                    <v-col cols="12" sm="6" md="12">
                      <validation-provider
                        v-slot="{ errors }"
                        name="username"
                        rules="required"
                      >
                        <v-text-field
                          ref="username"
                          v-model="username"
                          hide-details
                          solo
                          autofocus
                          placeholder="Account"
                          color="#57AEB1"
                          prepend-inner-icon="mdi-account"
                          name="User"
                          label="User account"
                          type="text"
                          :background-color="
                            errors.length > 0 ? '#faebeb' : 'white'
                          "
                          :error-messages="errors[0]"
                          @keydown.enter.prevent="
                            resetPasswordPreAuthenticate()
                          "
                          @keydown.space.prevent
                        />
                      </validation-provider>
                    </v-col>

                    <v-col cols="12" sm="12" md="12">
                      <v-card-actions
                        style="margin-top: -1.5 em; cursor: pointer !important"
                      >
                        <div class="flex-grow-1" />
                        <v-btn
                          class="white--text"
                          :input-value="true"
                          text
                          large
                          @click="forgot = false"
                        >
                          Back
                        </v-btn>

                        <v-btn
                          class="white--text"
                          :input-value="true"
                          text
                          large
                          :loading="loading"
                          @click="resetPasswordPreAuthenticate()"
                        >
                          Continue
                        </v-btn>
                      </v-card-actions>
                    </v-col>
                  </v-row>
                </div>
              </v-card>
            </v-col>
          </ValidationObserver>
        </v-fade-transition>

        <v-fade-transition hide-on-leave>
          <ValidationObserver ref="resetPasswordForm" slim>
            <v-col v-if="resetPasswordScreen" :key="0" cols="12" lg="6" sm="8">
              <v-card
                :color="
                  $vuetify.breakpoint.mdAndUp
                    ? 'rgba(200, 200, 200,  0.1)'
                    : 'transparent'
                "
                style="border-radius: 21px"
              >
                <v-col
                  style="background: rgba(43, 54, 67, 0.3); border-radius: 21px"
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-card-title class="headline white--text">
                    Change your password
                  </v-card-title>
                  <v-card-subtitle class="white--text">
                    Enter a new password for your account
                  </v-card-subtitle>

                  <div style="width: 100%" class="px-4">
                    <v-row>
                      <v-col cols="12" sm="12" md="12" />

                      <v-col cols="12" sm="6" md="12">
                        <validation-provider
                          v-slot="{ errors }"
                          name="New password"
                          rules="required|min:8"
                        >
                          <v-text-field
                            v-model="newPassword"
                            class="detailsColor mb-n6"
                            autofocus
                            solo
                            placeholder="New password"
                            color="#57AEB1"
                            prepend-inner-icon="mdi-account"
                            name="User"
                            label="User account"
                            :type="password_visible ? 'text' : 'password'"
                            :append-icon="
                              password_visible
                                ? 'mdi-eye-outline'
                                : 'mdi-eye-off-outline'
                            "
                            :background-color="
                              errors.length > 0 ? '#faebeb' : 'white'
                            "
                            :error-messages="errors[0]"
                            @keydown.enter.prevent="preResetPassword()"
                            @keydown.space.prevent
                            @click:append="password_visible = !password_visible"
                          />
                        </validation-provider>
                      </v-col>
                      <v-col cols="12" sm="6" md="12">
                        <validation-provider
                          v-slot="{ errors }"
                          name="Repeat new password"
                          rules="required"
                        >
                          <v-text-field
                            v-model="newPasswordRepeat"
                            :disabled="newPassword.length < 8"
                            class="detailsColor"
                            solo
                            placeholder="Repeat password"
                            color="#57AEB1"
                            prepend-inner-icon="mdi-shield-outline"
                            name="User"
                            label="User account"
                            :type="password_visible ? 'text' : 'password'"
                            :append-icon="
                              password_visible
                                ? 'mdi-eye-outline'
                                : 'mdi-eye-outline'
                            "
                            :background-color="
                              errors.length > 0 ? '#faebeb' : 'white'
                            "
                            :error-messages="errors[0]"
                            @keydown.enter.prevent="preResetPassword()"
                            @keydown.space.prevent
                            @click:append="password_visible = !password_visible"
                          />
                        </validation-provider>
                      </v-col>

                      <v-col cols="12" sm="12" md="12">
                        <v-card-actions
                          style="
                            margin-top: -1.5 em;
                            cursor: pointer !important;
                          "
                        >
                          <div class="flex-grow-1" />
                          <v-btn
                            color="grey"
                            x-large
                            height="38"
                            class="white--text"
                            @click="resetPassword = false"
                          >
                            Back
                          </v-btn>

                          <v-btn
                            class="mr-n3 white--text"
                            color="teal"
                            x-large
                            height="38"
                            :loading="loading"
                            @click="preResetPassword()"
                          >
                            Continue
                          </v-btn>
                        </v-card-actions>
                      </v-col>
                    </v-row>
                  </div>
                </v-col>
              </v-card>
            </v-col>
          </ValidationObserver>
        </v-fade-transition>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";

// import Vue from "vue";
// import { store } from "@/store";
// import { mapActions } from "vuex";
// import moment from "moment";
import globalMixin from "@/mixins/globalMixin";
// import aes from "crypto-js/aes";
// import enc from "crypto-js/enc-hex";
// import ZeroPadding from "crypto-js/pad-zeropadding";
// Vue.use(aes, enc, ZeroPadding);

export default {
  name: "Login",
  mixins: [globalMixin],

  data() {
    return {
      signup: false,
      newPassword: "",
      newPasswordRepeat: "",
      resetPasswordScreen: false,
      loginVisible: false,
      forgotKey: 0,
      verify: false,
      key: 0,
      offline: false,
      new_password: "",
      forgot_button: true,
      recovery_token: false,
      forgot: false,
      recovery_token_valid: false,
      recovery_token_input: "",

      dictionary: {
        custom: {
          validate_password: {
            required: "Your password is required."
          },

          validate_user: {
            required: "Your account name is required."
          }
        }
      },

      recovery_token_generated: "",
      second_factor_token: "",
      secondFactor: false,
      // date_time: moment().format("LLL"),
      loading: false,
      empresa: "",
      descripcion: "",
      loggedin: "",
      username: "",
      v_mode: "login",
      valid: true,
      password_visible: false,
      password: "",
      snackbar: false,
      is_status: "",
      is_message: "",
      is_icon: "",
      timeout: 0,
      background: "",
      dialog: false,
      attempts: 0
    };
  },

  computed: {
    // siteInfo() {
    //   return store.state.appData.siteInfo;
    // },
  },

  mounted() {
    // this.disableModeration();
  },

  created() {
    // window.getApp.$on("APP_END_LOADING", () => {
    //   this.loading = false;
    // });
  },

  methods: {
    loginSanctum() {
      axios.get("sanctum/csrf-cookie").then(response => {
        axios
          .post("login", { email: "test@test.com", password: "password" })
          .then(response2 => {
            axios.get("authenticated").then(response2 => {});
          });
      });
    },

    // loginSanctum() {
    //   axios
    //     .post("api/login", { email: "test@test.com", password: "password" })
    //     .then(response => {
    //       console.log(response);
    //     });
    //   // axios.get("/api/user").then(response => {
    //   //   console.log(response);
    //   // });
    // },

    checkUser() {
      axios.get("authenticated").then(response => {
        console.log(response);
      });
    },

    registerSanctum() {
      axios.defaults.withCredentials = true;
      axios
        .post("api/register", {
          name: "test",
          email: "test@test.com",
          password: "password"
        })
        .then(response => {
          console.log(response);
        });
    }

    // ...mapActions([
    //   "verifyCredentials",
    //   "disableModeration",
    //   "resetPasswordVuex",
    // ]),
    // preResetPassword() {
    //   this.$refs.resetPasswordForm.validate().then((success) => {
    //     if (success) {
    //       this.resetPassword();
    //     }
    //   });
    // },
    // async resetPassword() {
    //   if (this.newPassword === this.newPasswordRepeat) {
    //     this.loading = true;
    //     const post = {
    //       username: this.username,
    //       password: this.newPassword,
    //     };
    //     const xx1 = enc.parse(this.$x1);
    //     const iv = enc.parse(this.$x2);
    //     const encrypted = aes
    //       .encrypt(JSON.stringify(post), xx1, {
    //         iv,
    //         padding: ZeroPadding,
    //       })
    //       .toString();
    //     this.resetPasswordVuex({ encrypted }).then((response) => {
    //       if (response == "success") {
    //         this.password = this.newPasswordRepeat;
    //         this.authenticate();
    //       }
    //     });
    //   } else {
    //     window.getApp.$emit(
    //       "APP_SHOW_SNACKBAR",
    //       "red lighten-3",
    //       "error",
    //       "Passwords don't match."
    //     );
    //   }
    // },
    // resetPasswordPreAuthenticate() {
    //   this.$refs.accountRecoveryForm.validate().then((success) => {
    //     if (success) {
    //       this.authenticate();
    //     }
    //   });
    // },
    // async authenticate() {
    //   this.$refs.authForm.validate().then((success) => {
    //     if (success) {
    //       this.loading = true;
    //       const post = { username: this.username, password: this.password };
    //       const xx1 = enc.parse(this.$x1);
    //       const iv = enc.parse(this.$x2);
    //       const encrypted = aes
    //         .encrypt(JSON.stringify(post), xx1, { iv, padding: ZeroPadding })
    //         .toString();
    //       this.verifyCredentials({ encrypted }).then((response) => {
    //         if (response == "resetPassword") {
    //           this.resetPasswordScreen = true;
    //           this.loading = false;
    //         }
    //         if (response == "Authentication error") {
    //           this.loading = false;
    //         }
    //       });
    //     }
    //   });
    // },
    // async pushHomepage() {
    //   this.$router.push("/");
    // },
  }
};
</script>

<style scoped>
::v-deep .detailsColor .error--text > * {
  color: white !important;
  caret-color: white !important;
}
</style>
