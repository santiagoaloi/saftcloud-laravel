module.exports = {
  env: {
    browser: true,
    commonjs: true,
    es6: true,
  },
  extends: ['plugin:vue/recommended', 'airbnb', 'prettier'],

  rules: {
    'prettier/prettier': ['error'],
    'consistent-return': 'off',
    'no-nested-ternary': 'off',
    'no-shadow': 'off',
    'no-param-reassign': 'off',
  },

  globals: {
    Atomics: 'readonly',
    SharedArrayBuffer: 'readonly',
  },
  parserOptions: {
    ecmaVersion: 2018,
    parser: 'babel-eslint',
    sourceType: 'module',
  },
  plugins: ['vue', 'prettier'],
};
