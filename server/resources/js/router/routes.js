import staticRoutes from '@/router/static';
import publicRoutes from '@/router/public';

export default [
  {
    path: '/',
    name: 'initial',
    meta: { layout: 'public-layout', keepAlive: true },
    component: () => import(/* webpackChunkName: 'homepage' */ '@/views/Public/Homepage/Index.vue'),
  },
  ...staticRoutes,
  ...publicRoutes,
];
