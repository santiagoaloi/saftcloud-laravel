export default [
  {
    path: '/Login',
    name: 'Login',
    meta: {
      layout: 'public-layout',
    },
    component: () => import(/* webpackChunkName: 'public-login-page' */ '@/views/Login/Index.vue'),
  },

  {
    path: '/Signup',
    name: 'Signup',
    meta: {
      layout: 'public-layout',
    },
    component: () => import(/* webpackChunkName: 'public-signup', webpackPrefetch: true */ '@/views/Public/Signup/Signup.vue'),
  },
];
