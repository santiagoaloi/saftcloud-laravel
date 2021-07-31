<template>
 <v-row align="center" justify="space-between" class="mb-0">
  <v-col cols="12" lg="6">
   <v-row no-gutters align="center" justify="center">
    <div>
     <v-avatar :size="$vuetify.breakpoint.smAndDown ? '8em' : '18em'">
      <v-img class="rounded" aspect-ratio="2" src="storage/logo2.png" :transition="false">
       <!-- Spinner loader -->
       <template v-slot:placeholder>
        <v-row class="fill-height ma-0" align="center" justify="center">
         <v-progress-circular indeterminate />
        </v-row>
       </template>
      </v-img>
     </v-avatar>
    </div>
   </v-row>

   <v-row class="mt-10" no-gutters align="center" justify="center">
    <div class="topFont topSlide shadows mx-10 white--text">
     <h1>SaftCloud</h1>
    </div>
   </v-row>

   <v-row class="mt-2" no-gutters align="center" justify="center">
    <div class="subFont topSlide shadows mx-10 text-center white--text">
     <h2>Point of sales made easy for everyone.</h2>
    </div>
   </v-row>
  </v-col>

  <v-fade-transition hide-on-leave>
   <ValidationObserver ref="loginForm" slim>
    <v-col v-if="!resetPasswordScreen && !forgot" cols="12" sm="12" md="12" lg="6" xl="5">
     <v-card :color="$vuetify.theme.dark ? '#2f3136' : '#f6f8fa'">
      <v-card-title class=" py-10">
       <h1>Login</h1>
      </v-card-title>
      <v-card-subtitle class=" mb-n10">
       <span v-if="$vuetify.breakpoint.mdAndUp">Don't have an account?</span>
       <v-btn style="margin-top: -2.9px" small @click="signup = !signup" :class="{ 'ml-3': !$vuetify.breakpoint.smAndDown }" to="/signup">
        Sign up
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
           hide-details
           solo
           autofocus
           placeholder="Username"
           prepend-inner-icon="mdi-account"
           name="User"
           type="text"
           :disabled="loading"
           @keydown.enter.prevent="validatelogin()"
           spellcheck="false"
           :color="isDark ? '#208ad6' : 'grey'"
           :background-color="isDark ? '#28292b' : 'white'"
           :error="errors.length > 0"
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
            prepend-inner-icon="mdi-shield-key-outline"
            placeholder="Password"
            :type="password_visible ? 'text' : 'password'"
            :append-icon="password_visible ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
            :disabled="loading"
            @click:append="password_visible = !password_visible"
            @keydown.enter.prevent="validatelogin()"
            spellcheck="false"
            :color="isDark ? '#208ad6' : 'grey'"
            :background-color="isDark ? '#28292b' : 'white'"
            :error="errors.length > 0"
            @focus="reset"
            @input="reset"
            @blur="reset"
           />
          </validation-provider>
         </div>

         <v-card-actions class="mt-n2">
          <div class="flex-grow-1" />

          <v-btn disabled class="mt-3" text small @click="forgot = true">
           I forgot my password.
          </v-btn>
         </v-card-actions>
        </v-col>

        <v-col cols="12" sm="12" md="12">
         <v-card-actions class="mt-n7">
          <v-btn width="40%" color="primary" class="mr-n2 white--text" large :loading="loading" @click.prevent="validatelogin()">
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
 </v-row>
</template>

<script>
import axios from "axios";
import { sync, get, call } from "vuex-pathify";
import { store } from "@/store";
export default {
 name: "Login",
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

 computed: {
  ...sync("theme", ["isDark"])
 },

 methods: {
  ...call("authentication/*"),

  validatelogin() {
   this.$refs.loginForm.validate().then(validated => {
    if (validated) {
     this.loading = true;
     this.login(this.auth).then(authenticated => {
      if (!authenticated) {
       this.loading = false;
       store.set("snackbar/value", true);
       store.set("snackbar/text", "Invalid credentials, please try again.");
       store.set("snackbar/color", "pink darken-1");
      } else {
       this.$router.push("/components");
       window.eventBus.$emit("BUS_BUILD_ROUTES");
      }
     });
    }
   });
  }
 }
};
</script>
