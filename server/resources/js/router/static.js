export default [
  // {
  //   path: "/formField",
  //   name: "formField",
  //   meta: { layout: "secure_layout" },
  //   transition: "fade",
  //   component: () =>
  //     import("@/views/systemComponents/CmsBuilder/Formfield/Formfield.vue")
  // },

  // {
  //   path: "/nesteddraggable",
  //   name: "nesteddraggable",
  //   meta: { layout: "secure_layout" },
  //   transition: "fade",
  //   component: () =>
  //     import(
  //       "@/views/systemComponents/CmsBuilder/Nesteddraggable/Nesteddraggable.vue"
  //     )
  // },

  // {
  //   path: "/formbuilder",
  //   name: "Formbuilder",
  //   meta: { layout: "secure_layout" },
  //   transition: "fade",
  //   component: () =>
  //     import("@/views/systemComponents/CmsBuilder/Formbuilder/Formbuilder.vue")
  // },

  {
    path: "/desktop",
    name: "desktop",
    meta: { layout: "secure_layout" },
    transition: "fade",
    component: () => import("@/views/systemComponents/Desktop/Desktop.vue")
  },

  {
    path: "/components",
    name: "components",
    meta: { layout: "secure_layout" },
    transition: "fade",
    component: () => import(/* webpackChunkName: 'components' */ "@/views/systemComponents/Components/Components.vue")
  }

  // {
  //   path: "/users",
  //   name: "users",
  //   meta: { layout: "secure_layout" },
  //   transition: "fade",
  //   component: () =>
  //     import(
  //       /* webpackChunkName: 'usermgmt' */ "@/views/systemComponents/Users/Users.vue"
  //     )
  // },

  // {
  //   path: "/notifications",
  //   name: "notifications",
  //   meta: { layout: "secure_layout" },
  //   transition: "fade",
  //   component: () =>
  //     import(
  //       /* webpackChunkName: 'usermgmt' */ "@/views/systemComponents/Notifications/Notifications.vue"
  //     )
  // },

  // {
  //   path: "/previewprofile",
  //   name: "previewprofile  ",
  //   meta: { layout: "secure_layout" },
  //   transition: "fade",
  //   component: () =>
  //     import(
  //       /* webpackChunkName: 'previewprofile' */ "@/views/systemComponents/Users/PreviewProfile.vue"
  //     )
  // },

  // {
  //   path: "/ComponentsManagement/:id",
  //   name: "ComponentsManagement",
  //   meta: { layout: "secure_layout" },
  //   transition: "fade",
  //   component: () =>
  //     import("@/views/systemComponents/ComponentsManagement/Tabs/Index.vue"),
  //   children: [
  //     {
  //       path: "/ComponentsManagement/info",
  //       name: "ComponentsManagement/info",
  //       meta: { layout: "secure_layout" },
  //       transition: "fade",
  //       component: () =>
  //         import("@/views/systemComponents/ComponentsManagement/Info/Index.vue")
  //     },
  //     {
  //       path: "/ComponentsManagement/sql",
  //       name: "ComponentsManagement/sql",
  //       meta: { layout: "secure_layout" },
  //       transition: "fade",
  //       component: () =>
  //         import("@/views/systemComponents/ComponentsManagement/Sql/Index.vue")
  //     },
  //     {
  //       path: "/ComponentsManagement/table",
  //       name: "ComponentsManagement/table",
  //       meta: { layout: "secure_layout" },
  //       transition: "fade",
  //       component: () =>
  //         import(
  //           "@/views/systemComponents/ComponentsManagement/Table/Index.vue"
  //         )
  //     },
  //     {
  //       path: "/ComponentsManagement/form",
  //       name: "ComponentsManagement/form",
  //       meta: { layout: "secure_layout" },
  //       transition: "fade",
  //       component: () =>
  //         import("@/views/systemComponents/ComponentsManagement/Form/Index.vue")
  //     },
  //     {
  //       path: "/ComponentsManagement/menuforms",
  //       name: "ComponentsManagement/menuform",
  //       meta: { layout: "secure_layout" },
  //       transition: "fade",
  //       component: () =>
  //         import(
  //           "@/views/systemComponents/ComponentsManagement/MenuForms/Index.vue"
  //         )
  //     },
  //     {
  //       path: "/ComponentsManagement/permission",
  //       name: "ComponentsManagement/permission",
  //       meta: { layout: "secure_layout" },
  //       transition: "fade",
  //       component: () =>
  //         import(
  //           "@/views/systemComponents/ComponentsManagement/Permission/Index.vue"
  //         )
  //     },
  //     {
  //       path: "/ComponentsManagement/DynamicAppbar",
  //       name: "ComponentsManagement/DynamicAppbar",
  //       meta: { layout: "secure_layout" },
  //       transition: "fade",

  //       component: () =>
  //         import(
  //           "@/views/systemComponents/ComponentsManagement/DynamicAppbar/Index.vue"
  //         )
  //     }
  //   ]
  // },

  // {
  //   path: "/profile",
  //   meta: { layout: "secure_layout" },
  //   name: "profile",
  //   transition: "fade",
  //   component: () => import("@/views/systemComponents/Profile/Profile.vue"),
  //   children: [
  //     {
  //       path: "/profile/info",
  //       name: "profile/info",
  //       meta: { layout: "secure_layout" },
  //       component: () =>
  //         import("@/views/systemComponents/Profile/Profileinfo.vue")
  //     },

  //     {
  //       path: "/profile/securechange",
  //       name: "profile/securechange",
  //       meta: { layout: "secure_layout" },
  //       component: () =>
  //         import("@/views/systemComponents/Profile/Profilepassword.vue")
  //     },

  //     {
  //       path: "/profile/secureauth",
  //       name: "profile/secureauth",
  //       meta: { layout: "secure_layout" },
  //       component: () =>
  //         import("@/views/systemComponents/Profile/Profileauth.vue")
  //     },

  //     {
  //       path: "/profile/infoWeb",
  //       name: "profile/infoWeb",
  //       meta: { layout: "secure_layout" },
  //       component: () =>
  //         import("@/views/systemComponents/Profile/Profileinfoweb.vue")
  //     },

  //     {
  //       path: "/profile/profilePhotos",
  //       name: "profile/profilePhotos",
  //       meta: { layout: "secure_layout" },
  //       component: () =>
  //         import("@/views/systemComponents/Profile/Profilephotos.vue")
  //     },

  //     // {
  //     //   path: '/profile/infoPreview',
  //     //   name: 'profile/infoPreview',
  //     //   meta: { layout: 'secure_layout' },
  //     //   component: () => import('@/views/systemComponents/Profile/InfoPreview.vue'),
  //     //   },

  //     {
  //       path: "/profile/personalization",
  //       name: "profile/personalization",
  //       meta: { layout: "secure_layout" },

  //       component: () =>
  //         import("@/views/systemComponents/Profile/Personalization.vue")
  //     }
  //   ]
  // },

  // {
  //   path: "/appconfig",
  //   meta: { layout: "secure_layout" },
  //   name: "appconfig",
  //   component: () =>
  //     import("@/views/systemComponents/AppConfig/Configuration.vue"),
  //   children: [
  //     {
  //       path: "/appconfig/general",
  //       name: "appconfig/general",
  //       meta: { layout: "secure_layout" },
  //       component: () =>
  //         import("@/views/systemComponents/AppConfig/General.vue")
  //     },
  //     {
  //       path: "/appconfig/emails",
  //       name: "appconfig/emails",
  //       meta: { layout: "secure_layout" },
  //       component: () => import("@/views/systemComponents/AppConfig/Emails.vue")
  //     }
  //   ]
  // }
];
