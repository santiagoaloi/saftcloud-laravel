export default [
  {
    path: '/Modules',
    name: 'Modules',
    meta: { layout: 'secure-layout', title: 'Manage modules', search: 'Modules...', rootOnly: true },
    component: () => import(/* webpackChunkName: 'modules' */ '@/views/System/Modules/Modules.vue'),
  },

  {
    path: '/Entities',
    name: 'Entities',
    meta: { layout: 'secure-layout', title: 'Manage users and roles', search: 'Entities...', rootOnly: false },
    component: () => import(/* webpackChunkName: 'entities' */ '@/views/System/Entities/Entities.vue'),
    children: [
      {
        path: '/Entities/Basic',
        name: 'Entities/Basic',
        meta: { layout: 'secure-layout', title: 'Manage users and roles' },
        component: () =>
          import(/* webpackChunkName: 'entities' */ '@/views/System/Entities/EntitiesEdit/ConfigViews/Basic/Basic.vue'),
      },
    ],
  },
];
