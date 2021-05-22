<template>
  <v-container
    class="fill-height mb-8 mb-md-8 mb-lg-0 mb-xl-0 px-8 px-md-0 px-lg-0 px-xl-0"
  >
    <v-row align="center" justify="center">
      <v-col cols="12" lg="6">
        <v-row no-gutters align="center" justify="center">
          <div>
            <v-avatar :size="$vuetify.breakpoint.smAndDown ? '8em' : '18em'">
              <v-img
                eager
                class="rounded"
                aspect-ratio="2"
                src="storage/logo2.png"
              >
                <!-- Spinner loader -->
                <template v-slot:placeholder>
                  <v-row
                    class="fill-height ma-0"
                    align="center"
                    justify="center"
                  >
                    <v-progress-circular indeterminate />
                  </v-row>
                </template>
              </v-img>
            </v-avatar>
          </div>
        </v-row>

        <v-row class="mt-10" no-gutters align="center" justify="center">
          <div class="topFont topSlide shadows mx-10" style="color: white">
            <h1>SaftCloud</h1>
            <!-- {{ siteInfo.companyName }} -->
          </div>
        </v-row>

        <v-row class="mt-2" no-gutters align="center" justify="center">
          <div
            class="subFont topSlide shadows mx-10 text-center"
            style="color: white"
          >
            <h2>Point of sales made easy for everyone.</h2>

            <!-- {{ siteInfo.companySlogan }} -->
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
            xl="4"
          >
            <v-card elevation="10" color="white">
              <v-card-title class=" py-10">
                <h1>Login</h1>
              </v-card-title>
              <v-card-subtitle class=" mb-n10">
                <span v-if="$vuetify.breakpoint.mdAndUp"
                  >Don't have an account?</span
                >
                <v-btn
                  style="margin-top: -2.9px"
                  small
                  @click="signup = !signup"
                  :class="$vuetify.breakpoint.smAndDown ? '' : 'ml-3'"
                  to="/signup"
                >
                  Sign up
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
                        v-model.trim="auth.email"
                        hide-details
                        solo
                        autofocus
                        placeholder="Username"
                        color="black"
                        prepend-inner-icon="mdi-account"
                        name="User"
                        type="text"
                        :disabled="loading"
                        :background-color="
                          errors.length > 0 ? '#faebeb' : 'white'
                        "
                        :error-messages="errors[0]"
                        @keydown.enter.prevent="login()"
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
                          v-model.trim="auth.password"
                          hide-details
                          solo
                          color="black"
                          prepend-inner-icon="mdi-shield-key-outline"
                          placeholder="Password"
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
                          @keydown.enter.prevent="login()"
                          @keydown.space.prevent
                        />
                      </validation-provider>
                    </div>

                    <v-card-actions class="mt-n2">
                      <div class="flex-grow-1" />

                      <v-btn
                        disabled
                        class="mt-3"
                        text
                        small
                        @click="forgot = true"
                      >
                        I forgot my password.
                      </v-btn>
                    </v-card-actions>
                  </v-col>

                  <v-col cols="12" sm="12" md="12">
                    <v-card-actions class="mt-n7">
                      <!-- <div class="flex-grow-1" /> -->

                      <v-btn
                        width="40%"
                        color="pink accent-5"
                        class="mr-n2 white--text"
                        large
                        :loading="loading"
                        @click.prevent="login()"
                        :disabled="auth.email === '' || auth.password === ''"
                      >
                        Login
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
                        color="teal accent-2"
                        prepend-inner-icon="mdi-account"
                        name="User"
                        type="text"
                        :background-color="
                          errors.length > 0 ? '#faebeb' : 'white'
                        "
                        :error-messages="errors[0]"
                        @keydown.enter.prevent="resetPasswordPreAuthenticate()"
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
</template>

<script>
import axios from "axios";
import { call } from "vuex-pathify";
import globalMixin from "@/mixins/globalMixin";
import { store } from "@/store";

export default {
  name: "Login",
  mixins: [globalMixin],

  data() {
    return {
      auth: { email: "", password: "" },
      signup: false,
      newPassword: "",
      newPasswordRepeat: "",
      resetPasswordScreen: false,
      forgot: false,
      loading: false,
      password_visible: false
    };
  },

  methods: {
    loginSanctum: call("authentication/login"),
    login() {
      this.loading = true;
      this.loginSanctum(this.auth).then(response => {
        if (!response) {
          this.loading = false;
          store.set("snackbar/value", true);
          store.set("snackbar/text", "Invalid credentials, please try again.");
          store.set("snackbar/color", "pink darken-1");
        }
      });
    }
  }
};
</script>
