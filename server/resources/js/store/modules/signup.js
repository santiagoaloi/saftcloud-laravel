import axios from 'axios';
import { make } from 'vuex-pathify';

const initialSignupForm = () => ({
  name: '',
  lastname: '',
  email: '',
  phone_code: null,
  phoneNumber: '',
  companyNameAlias: '',
  companyName: '',
  state: '',
  city: '',
  country: null,
  zipcode: '',
  address: '',
  selectedViews: [],
});

const state = {
  step: 0,
  terms: false,
  countryCodes: [],
  signupForm: initialSignupForm(),
  states: [],
  availableViews: [],
};

const mutations = make.mutations(state);

const getters = {
  filterCountries: () => (item, queryText) => {
    const searchText = queryText.toLowerCase();
    const fields = [item.name, item.phone_code];
    return fields.some((f) => f != null && f.toLowerCase().includes(searchText));
  },

  getCountryNameAndCode: (state) => (code) => {
    const countryObject = state.countryCodes.filter((item) => item.phone_code === code);
    return `${countryObject[0].name} +${countryObject[0].phone_code} `;
  },

  getCountryName: (state) => (countryId) => {
    const countryObject = state.countryCodes.filter((item) => item.id === countryId);
    return `${countryObject[0].name}`;
  },
};

const actions = {
  ...make.actions(state),

  accountCreation({ state }) {
    state.loading = true;
    axios.post('api/makeAccount', state.signupForm).then((response) => {
      if (response.status === 200) {
        this.$router.push('/VerifyAccount');
      } else {
        state.loading = false;
      }
    });
  },

  getCountries({ commit, state }) {
    state.countriesLoading = true;
    axios
      .get('api/countries')
      .then((response) => {
        if (response.status === 200) {
          commit('countryCodes', response.data.records);
        }
        state.countriesLoading = false;
      })
      .catch(() => {});
  },

  getStates({ commit }, state) {
    axios
      .post(`api/states/${state.id}`)
      .then((response) => {
        if (response.status === 200) {
          commit('states', response.data.records);
        }
      })
      .catch(() => {});
  },

  getAvailableViews({ commit }) {
    axios
      .get('api/getModules')
      .then((response) => {
        if (response.status) {
          commit('availableViews', response.data.modules);
        }
      })
      .catch(() => {});
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
