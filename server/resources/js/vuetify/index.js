import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';
import minifyTheme from 'minify-css-string';
import { store } from '@/store';
import config from '../configs';

import { VItem } from 'vuetify/lib';

export default async () => {
  await store.restored;
  Vue.use(Vuetify, {
    components: {
      VItem,
    },
  });
  return new Vuetify({
    theme: {
      dark: store.state.theme.isDark,
      themes: {
        dark: config.theme.dark,
        light: config.theme.light,
      },
      options: {
        minifyTheme,
        variations: false,
        themeCache: {
          get: (key) => localStorage.getItem(key),
          set: (key, value) => localStorage.setItem(key, value),
        },
      },
    },
  });
};
