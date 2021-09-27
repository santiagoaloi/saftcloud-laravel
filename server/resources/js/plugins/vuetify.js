import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';

import * as directives from 'vuetify/lib/directives';
import config from '../configs';

Vue.use(Vuetify, {
  directives,
});

export default new Vuetify({
  rtl: config.theme.isRTL,
  theme: {
    dark: config.theme.globalTheme === 'dark',
    options: {
      customProperties: true,
    },
    themes: {
      dark: config.theme.dark,
      light: config.theme.light,
    },
  },
});
