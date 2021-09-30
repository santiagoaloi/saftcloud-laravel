export default [
  {
    path: '/login',
    name: 'login',
    meta: {
      layout: 'public_layout',
    },
    component: () => import(/* webpackChunkName: 'public-login-view' */ '@/views/Login/Index.vue'),
  },
  {
    path: '/homepage',
    name: 'homepage',
    meta: {
      layout: 'public_layout',
    },
    component: () =>
      import(/* webpackChunkName: 'public-homepage' */ '@/views/Public/Homepage/Index.vue'),
  },

  {
    path: '/signup',
    name: 'signup',
    meta: {
      layout: 'public_layout',
    },
    component: () =>
      import(
        /* webpackChunkName: 'public-signup', webpackPrefetch: true */ '@/views/Public/Signup/Signup.vue'
      ),
  },

  {
    path: '/verifyAccount',
    name: 'verifyAccount',
    meta: {
      layout: 'public_layout',
    },
    component: () =>
      import(
        /* webpackChunkName: 'public-signup-verify-account' */ '@/views/Public/Signup/VerifyAccount.vue'
      ),
  },
];
