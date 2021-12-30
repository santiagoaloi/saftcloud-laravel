// Automatically loads and bootstraps files
// in the "./src/Component/base" folder.

// Imports
import Vue from 'vue';
import upperFirst from 'lodash/upperFirst';
import camelCase from 'lodash/camelCase';

const requireComponentBase = require.context('@/components/base', true, /\.vue$/);
for (const file of requireComponentBase.keys()) {
  const componentConfig = requireComponentBase(file);
  const name = file
    .replace(/index.js/, '')
    .replace(/^\.\//, '')
    .replace(/\.\w+$/, '');
  const componentName = upperFirst(camelCase(name));
  Vue.component(`${componentName}`, componentConfig.default || componentConfig);
}

const requireComponentlots = require.context('@/components/slots', true, /\.vue$/);
for (const file of requireComponentlots.keys()) {
  const componentConfig = requireComponentlots(file);
  const name = file
    .replace(/index.js/, '')
    .replace(/^\.\//, '')
    .replace(/\.\w+$/, '');
  const componentName = upperFirst(camelCase(name));
  Vue.component(`${componentName}`, componentConfig.default || componentConfig);
}
