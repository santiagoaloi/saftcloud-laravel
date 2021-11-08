export default [
  {
    path: '/Components',
    name: 'Components',
    meta: { layout: 'secure-layout', title: 'Manage components', search: 'components...' },
    component: () => import(/* webpackChunkName: 'components' */ '@/views/System/Components/Components.vue'),
    children: [
      {
        path: '/Components/Basic',
        name: 'Components/Basic',
        meta: { layout: 'secure-layout', title: 'Manage components' },
        component: () => import(/* webpackChunkName: 'components-basic' */ '@/views/System/Components/ComponentsEdit/ConfigViews/Basic/Basic.vue'),
      },
      {
        path: '/Components/FormFields',
        name: 'Components/FormFields',
        meta: { layout: 'secure-layout', title: 'Manage components' },
        component: () => import(/* webpackChunkName: 'components-form-fields' */ '@/views/System/Components/ComponentsEdit/ConfigViews/FormFields/FormFields.vue'),
      },
      {
        path: '/Components/Query',
        name: 'Components/Query',
        meta: { layout: 'secure-layout', title: 'Manage components' },
        component: () => import(/* webpackChunkName: 'components-query' */ '@/views/System/Components/ComponentsEdit/ConfigViews/Query/Query.vue'),
      },
      {
        path: '/Components/Capabilities',
        name: 'Components/Capabilities',
        meta: { layout: 'secure-layout', title: 'Manage components' },
        component: () => import(/* webpackChunkName: 'components-capabilities' */ '@/views/System/Components/ComponentsEdit/ConfigViews/Capabilities/Capabilities.vue'),
      },
    ],
  },

  {
    path: '/Entities',
    name: 'Entities',
    meta: { layout: 'secure-layout', title: 'Manage users and roles', search: 'entities...' },
    component: () => import(/* webpackChunkName: 'entities' */ '@/views/System/Entities/Entities.vue'),
    children: [
      {
        path: '/Entities/Basic',
        name: 'Entities/Basic',
        meta: { layout: 'secure-layout', title: 'Manage users and roles' },
        component: () => import(/* webpackChunkName: 'entities' */ '@/views/System/Entities/EntitiesEdit/ConfigViews/Basic/Basic.vue'),
      },
    ],
  },
];
