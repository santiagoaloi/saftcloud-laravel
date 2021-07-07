import axios from "axios";
import { store } from "@/store";
import { make } from "vuex-pathify";

const initialSignupForm = () => {
 return {
  name: "",
  lastname: "",
  email: "",
  phone_code: null,
  phoneNumber: "",
  companyNameAlias: "",
  companyName: "",
  state: "",
  city: "",
  country: null,
  zipcode: "",
  address: ""
 };
};

const state = {
 step: 0,
 terms: false,
 states: [],
 cities: [],
 countryCodes: [],
 signupForm: initialSignupForm()
};

const mutations = make.mutations(state);

const getters = {
 filterCountries: () => (item, queryText) => {
  const searchText = queryText.toLowerCase();
  const fields = [item.name, item.phone_code];
  return fields.some(f => f != null && f.toLowerCase().includes(searchText));
 },

 getCountryNameAndCode: state => phone_code => {
  let countryObject = state.countryCodes.filter(item => {
   return item.phone_code === phone_code;
  });
  return `${countryObject[0].name} +${countryObject[0].phone_code} `;
 },

 getCountryName: state => countryId => {
  let countryObject = state.countryCodes.filter(item => {
   return item.id === countryId;
  });
  return `${countryObject[0].name}`;
 }
};

const actions = {
 ...make.actions(state),

 accountCreation({ state }) {
  state.loading = true;
  axios.post("api/makeAccount", this.signupForm).then(response => {
   if (response.status === 200) {
    this.$router.push("/VerifyAccount");
   } else {
    state.loading = false;
   }
  });
 },

 getCountries({ commit, state }) {
  state.countriesLoading = true;
  axios
   .get("api/countries")
   .then(response => {
    if (response.status === 200) {
     commit("countryCodes", response.data.rows);
    }
   })
   .catch(err => {
    console.log(err);
   })
   .finally(() => (state.countriesLoading = false));
 }
};

export default {
 namespaced: true,
 state,
 mutations,
 actions,
 getters
};
