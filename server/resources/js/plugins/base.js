// Automatically loads and bootstraps files
// in the "./src/components/base" folder.

// Imports
import Vue from 'vue';
import upperFirst from 'lodash/upperFirst';
import camelCase from 'lodash/camelCase';

const requireComponentBase = require.context('@/components/Base', true, /\.vue$/);
for (const file of requireComponentBase.keys()) {
  const componentConfig = requireComponentBase(file);
  const name = file
    .replace(/index.js/, '')
    .replace(/^\.\//, '')
    .replace(/\.\w+$/, '');
  const componentName = upperFirst(camelCase(name));
  Vue.component(`${componentName}`, componentConfig.default || componentConfig);
}

const requireComponentSlots = require.context('@/components/Slots', true, /\.vue$/);
for (const file of requireComponentSlots.keys()) {
  const componentConfig = requireComponentSlots(file);
  const name = file
    .replace(/index.js/, '')
    .replace(/^\.\//, '')
    .replace(/\.\w+$/, '');
  const componentName = upperFirst(camelCase(name));
  Vue.component(`${componentName}`, componentConfig.default || componentConfig);
}
