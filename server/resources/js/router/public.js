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
    path: '/Homepage',
    name: 'Homepage',
    meta: {
      layout: 'public-layout',
    },
    component: () =>
      import(/* webpackChunkName: 'public-homepage' */ '@/views/Public/Homepage/Index.vue'),
  },

  {
    path: '/Signup',
    name: 'Signup',
    meta: {
      layout: 'public-layout',
    },
    component: () =>
      import(
        /* webpackChunkName: 'public-signup', webpackPrefetch: true */ '@/views/Public/Signup/Signup.vue'
      ),
  },

  {
    path: '/VerifyAccount',
    name: 'VerifyAccount',
    meta: {
      layout: 'public-layout',
    },
    component: () =>
      import(
        /* webpackChunkName: 'public-signup-verify-account' */ '@/views/Public/Signup/VerifyAccount.vue'
      ),
  },
];
