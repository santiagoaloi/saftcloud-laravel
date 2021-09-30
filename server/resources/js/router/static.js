export default [
  {
    path: '/desktop',
    name: 'desktop',
    meta: { layout: 'secure_layout' },
    component: () => import('@/views/System/Desktop/Desktop.vue'),
  },

  {
    path: '/components',
    name: 'components',
    meta: { layout: 'secure_layout', title: 'Manage components' },
    component: () =>
      import(/* webpackChunkName: 'components' */ '@/views/System/Components/Components.vue'),
    children: [
      {
        path: '/components/basic',
        name: 'components/basic',
        meta: { layout: 'secure_layout', title: 'Manage components' },
        component: () =>
          import(
            /* webpackChunkName: 'components-basic' */ '@/views/System/Components/ComponentsEdit/ConfigViews/Basic/Basic.vue'
          ),
      },
      {
        path: '/components/formFields',
        name: 'components/formFields',
        meta: { layout: 'secure_layout', title: 'Manage components' },
        component: () =>
          import(
            /* webpackChunkName: 'components-form-fields' */ '@/views/System/Components/ComponentsEdit/ConfigViews/FormFields/FormFields.vue'
          ),
      },
      {
        path: '/components/query',
        name: 'components/query',
        meta: { layout: 'secure_layout', title: 'Manage components' },
        component: () =>
          import(
            /* webpackChunkName: 'components-query' */ '@/views/System/Components/ComponentsEdit/ConfigViews/Query/Query.vue'
          ),
      },
      {
        path: '/components/capabilities',
        name: 'components/capabilities',
        meta: { layout: 'secure_layout', title: 'Manage components' },
        component: () =>
          import(
            /* webpackChunkName: 'components-capabilities' */ '@/views/System/Components/ComponentsEdit/ConfigViews/Capabilities/Capabilities.vue'
          ),
      },
    ],
  },

  {
    path: '/accounts',
    name: 'accounts',
    meta: { layout: 'secure_layout', title: 'Manage account and roles' },
    component: () =>
      import(/* webpackChunkName: 'accounts' */ '@/views/System/Accounts/Accounts.vue'),
    children: [],
  },
];
