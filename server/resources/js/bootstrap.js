/* eslint-disable */

import axios from 'axios';
import router from '@/router';
import { store } from '@/store';

const axiosDefaults = require('axios/lib/defaults');
const csrf = document.head.querySelector('meta[name="csrf-token"]');

axiosDefaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axiosDefaults.headers.common['X-CSRF-TOKEN'] = csrf.content;

// Awaits for storage (indexedDB) to be ready.
const getToken = async () => {
  await store.restored;
  return store.get('authentication@session.token');
};

getToken().then((sessionToken) => {
  if (sessionToken) {
    axiosDefaults.headers.common.Authorization = `Bearer ${sessionToken}`;
  }
});

//* Attaches catch to every axios request globally
axios.interceptors.response.use(
  (response) => response,
  ({ ...error }) => {
    console.log(error);
    if (error.response) {
      //* If session fails to validate the token, kill the session.
      if (error.response.data.message === 'Unauthenticated.') {
        router.push('/Login');
        store.set('authentication/session', {});
      }

      //* If records are duplicated
      if (error.response.status === 1062) {
        store.set('snackbar/data@value', true);
        store.set('snackbar/data@text', 'Invalid Credentials');
        store.set('snackbar/data@icon', 'mdi-alert-octagon');
        store.set('snackbar/data@color', 'pink darken-1');
      }

      //* If credentials are invalid
      if (error.response.status === 401) {
        store.set('snackbar/data@value', true);
        store.set('snackbar/data@text', 'Invalid Credentials');
        store.set('snackbar/data@icon', 'mdi-alert-octagon');
        store.set('snackbar/data@color', 'pink darken-1');
      }

      //* if function required elevated privileges.
      if (error.response.data.message === 'This action is unauthorized.') {
        store.set('snackbar/data@value', true);
        store.set('snackbar/data@text', 'Insufficient privileges, this action requires higher clearance');
        store.set('snackbar/data@icon', 'mdi-alert-octagon');
        store.set('snackbar/data@color', 'pink darken-1');
      }

      //* SQL connectivty error
      if (error.response.data.message.includes('No connection could be made')) {
        store.set('snackbar/data@value', true);
        store.set(
          'snackbar/data@text',
          'Database connectivty error. No connection could be made because the target machine actively refused it ',
        );
        store.set('snackbar/data@icon', 'mdi-alert-octagon');
        store.set('snackbar/data@color', 'pink darken-1');
      }

      return Promise.reject(error);
    }
  },
);
