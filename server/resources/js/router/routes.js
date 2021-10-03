import staticRoutes from '@/router/static';
import publicRoutes from '@/router/public';

export default [
  {
    path: '/',
    name: 'initial',
    meta: { layout: 'public_layout' },
    redirect: {
      path: '/Homepage',
      meta: {
        layout: 'public_layout',
      },
    },
  },
  ...staticRoutes,
  ...publicRoutes,
];
