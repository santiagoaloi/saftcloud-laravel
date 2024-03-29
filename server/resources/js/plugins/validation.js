import Vue from 'vue';
import { ValidationObserver, ValidationProvider, extend, localize, setInteractionMode } from 'vee-validate';
import en from 'vee-validate/dist/locale/en.json';
import * as rules from 'vee-validate/dist/rules';

// add url validation, removed in version 3.
extend('url', {
  validate: (str) => {
    const pattern = new RegExp(
      '^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$',
      'i',
    ); // fragment locator
    return !!pattern.test(str);
  },
  message: 'This is not a valid URL',
});

// Won't validate on blur, but when the form is submitted.
setInteractionMode('passive');

for (const rule in rules) {
  if (Object.prototype.hasOwnProperty.call(rules, rule)) {
    extend(rule, rules[rule]);
  }
}

localize('en', en);

// Install Modules globally
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);
