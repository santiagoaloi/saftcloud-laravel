import staticRoutes from '@/router/static';
import publicRoutes from '@/router/public';

export default [
  {
    path: '/',
    name: 'initial',
    meta: { layout: 'public-layout' },
    redirect: {
      path: '/Homepage',
      meta: {
        layout: 'public-layout',
      },
    },
  },
  ...staticRoutes,
  ...publicRoutes,
];
