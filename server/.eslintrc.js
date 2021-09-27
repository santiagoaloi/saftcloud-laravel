module.exports = {
 env: {
  browser: true,
  commonjs: true,
  es6: true,
 },
 extends: ["plugin:vue/recommended", "airbnb-base", "prettier"],

 rules: {
  "prettier/prettier": ["error"],
 },

 globals: {
  Atomics: "readonly",
  SharedArrayBuffer: "readonly",
 },
 parserOptions: {
  ecmaVersion: 2018,
  parser: "babel-eslint",
  sourceType: "module",
 },
 plugins: ["vue", "prettier"],
};
