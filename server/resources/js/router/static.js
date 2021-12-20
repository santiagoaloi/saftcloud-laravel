export default [
  {
    path: '/Components',
    name: 'Components',
    meta: { layout: 'secure-layout', title: 'Manage components', search: 'components...', rootOnly: true },
    component: () => import(/* webpackChunkName: 'components' */ '@/views/System/Components/Components.vue'),
  },

  {
    path: '/Entities',
    name: 'Entities',
    meta: { layout: 'secure-layout', title: 'Manage users and roles', search: 'entities...', rootOnly: false },
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
