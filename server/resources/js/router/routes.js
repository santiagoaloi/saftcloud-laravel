import staticRoutes from '@/router/static';
import publicRoutes from '@/router/public';

export default [
  {
    path: '/',
    name: 'initial',
    alias: ['/Homepage'],
    meta: { layout: 'public-layout' },
    component: () => import(/* webpackChunkName: 'homepage' */ '@/views/Public/Homepage/Index.vue'),
  },
  ...staticRoutes,
  ...publicRoutes,
];
