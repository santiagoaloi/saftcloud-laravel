export default [
  {
    path: '/Login',
    name: 'Login',
    meta: {
      layout: 'public-layout',
      keepAlive: true,
    },
    component: () => import(/* webpackChunkName: 'public-login-page' */ '@/views/Login/Index.vue'),
  },
  {
    path: '/Homepage',
    name: 'Homepage',
    meta: {
      layout: 'public-layout',
      keepAlive: true,
    },
    component: () => import(/* webpackChunkName: 'public-homepage' , webpackPreload: true */ '@/views/Public/Homepage/Index.vue'),
  },

  {
    path: '/Signup',
    name: 'Signup',
    meta: {
      layout: 'public-layout',
      keepAlive: true,
    },
    component: () => import(/* webpackChunkName: 'public-signup', webpackPrefetch: true */ '@/views/Public/Signup/Signup.vue'),
  },
];
