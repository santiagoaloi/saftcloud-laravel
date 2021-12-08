<template>
  <v-container class="fill-height">
    <v-row align="center" justify="space-between" class="mb-0">
      <v-col cols="12" lg="6">
        <v-row align="center" justify="center">
          <div>
            <v-avatar :size="$vuetify.breakpoint.smAndDown ? '8em' : '16em'">
              <v-img eager class="rounded" aspect-ratio="2" src="storage/logo.png" :transition="false">
                <!-- Spinner loader -->
                <template #placeholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate />
                  </v-row>
                </template>
              </v-img>
            </v-avatar>
          </div>
        </v-row>

        <v-row class="mt-10" align="center" justify="center">
          <div class="topFont topSlide shadows mx-10 white--text">
            <h1>SaftCloud ™</h1>
          </div>
        </v-row>

        <v-row class="mt-2" align="center" justify="center">
          <div class="subFont topSlide shadows mx-10 text-center white--text">
            <h2>Point of sales made easy for everyone.</h2>
          </div>
        </v-row>
      </v-col>

      <ValidationObserver ref="loginForm" slim>
        <v-col v-if="!resetPasswordScreen && !forgot" cols="12" sm="12" md="12" lg="6" xl="6">
          <v-alert v-model="hasSessionExpired" dismissible dense text color="white" type="info">
            Your session has expired <strong> due to inactivity.</strong>
          </v-alert>

          <v-card class="modal pa-5" elevation="10" :class="{ shake: shake }">
            <v-card></v-card>
            <v-card-title class="py-10">
              <h1>Welcome back!</h1>
            </v-card-title>

            <v-card-subtitle class="mb-n10">
              <span v-if="$vuetify.breakpoint.mdAndUp">Need an account?</span>
              <v-btn
                dark
                style="margin-top: -2.9px"
                small
                :class="{ 'ml-3': !$vuetify.breakpoint.smAndDown }"
                to="/Signup"
                @click="signup = !signup"
              >
                Register
              </v-btn>
            </v-card-subtitle>

            <div class="px-4 width-full">
              <v-row>
                <v-col cols="12" sm="12" md="12" />

                <v-col cols="12" sm="6" md="12">
                  <validation-provider v-slot="{ errors, reset }" name="account name" rules="required">
                    <v-text-field
                      ref="username"
                      v-model.trim="auth.email"
                      background-color="rgba(56, 54, 54, 0.2)"
                      :color="isDark ? '#208ad6' : 'grey'"
                      rounded
                      flat
                      hide-details
                      solo
                      autofocus
                      placeholder="Username"
                      prepend-inner-icon="mdi-account"
                      name="User"
                      type="text"
                      :disabled="loading"
                      spellcheck="false"
                      height="55"
                      :error="errors.length > 0"
                      @keydown.enter.prevent="validatelogin()"
                      @focus="reset"
                      @input="reset"
                      @blur="reset"
                    />
                  </validation-provider>
                </v-col>

                <v-col cols="12" sm="6" md="12">
                  <div id="passwordField">
                    <validation-provider v-slot="{ errors, reset }" name="account password" rules="required">
                      <v-text-field
                        v-model.trim="auth.password"
                        hide-details
                        solo
                        flat
                        height="55"
                        prepend-inner-icon="mdi-shield-key-outline"
                        placeholder="Password"
                        :type="password_visible ? 'text' : 'password'"
                        :append-icon="password_visible ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                        :disabled="loading"
                        spellcheck="false"
                        :color="isDark ? '#208ad6' : 'grey'"
                        background-color="rgba(56, 54, 54, 0.2)"
                        :error="errors.length > 0"
                        rounded
                        @click:append="password_visible = !password_visible"
                        @keydown.enter.prevent="validatelogin()"
                        @focus="reset"
                        @input="reset"
                        @blur="reset"
                      />
                    </validation-provider>
                  </div>

                  <v-card-actions class="mt-n2">
                    <v-btn disabled class="mt-3" text small @click="forgot = true"> Forgot your password? </v-btn>
                  </v-card-actions>
                </v-col>

                <v-col cols="12" sm="12" md="12">
                  <v-card-actions class="mt-n7">
                    <v-spacer></v-spacer>

                    <v-btn
                      rounded
                      width="40%"
                      color="primary"
                      class="ml-n2 white--text hoverElevationSoft"
                      large
                      :loading="loading"
                      elevation="7"
                      :ripple="false"
                      @click.prevent="validatelogin()"
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
    </v-row>
  </v-container>
</template>

<script>
  import { sync, call } from 'vuex-pathify';
  import { store } from '@/store';

  const initialState = () => ({
    auth: { email: '', password: '', remember: false },
    signup: false,
    newPassword: '',
    newPasswordRepeat: '',
    resetPasswordScreen: false,
    forgot: false,
    loading: false,
    password_visible: false,
    shake: false,
  });
  export default {
    name: 'Login',
    data() {
      return {
        ...initialState(),
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('authentication', ['hasSessionExpired']),
      ...sync('loaders', ['logoutLoader']),
    },

    activated() {
      this.loading = false;
      Object.assign(this.$data, initialState());
      store.set('loaders/logoutLoader', false);
    },

    mounted() {
      this.loading = false;
      Object.assign(this.$data, initialState());
      store.set('loaders/logoutLoader', false);
    },

    methods: {
      ...call('authentication/*'),

      validatelogin() {
        console.log('test');
        this.$refs.loginForm.validate().then((validated) => {
          if (validated) {
            this.loading = true;
            this.login(this.auth).then((authenticated) => {
              if (!authenticated) {
                alert('llegue al paso del route 2');
                this.loading = false;
                this.shake = true;
                setTimeout(() => {
                  this.shake = false;
                }, 500);
              } else {
                this.$router.push('/Entities');
              }
            });
          } else {
            this.loading = false;
            this.shake = true;
            setTimeout(() => {
              this.shake = false;
            }, 500);
          }
        });
      },
    },
  };
</script>

<style scoped>
  @supports (-webkit-backdrop-filter: none) or (backdrop-filter: none) {
    .modal {
      -webkit-backdrop-filter: blur(10px);
      backdrop-filter: blur(10px);
      background-color: rgba(56, 54, 54, 0.2);
    }
  }

  @supports not ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
    .modal {
      background-color: rgba(56, 54, 54, 0.2);
    }
  }
</style>
