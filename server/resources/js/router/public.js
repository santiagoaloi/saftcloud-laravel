export default [
 {
  path: "/login",
  name: "/login",
  meta: {
   layout: "login_layout"
  },
  component: () => import(/* webpackChunkName: 'login-page' */ "@/views/Login/Index.vue")
 },
 {
  path: "/homepage",
  name: "/homepage",
  meta: {
   layout: "public_layout"
  },
  component: () => import(/* webpackChunkName: 'public-homepage' */ "@/views/Public/Homepage/Index.vue")
 },

 {
  path: "/signup",
  name: "/signup",
  meta: {
   layout: "public_layout"
  },
  component: () => import(/* webpackChunkName: 'signup' */ "@/views/Public/Signup/Signup.vue")
 },
 {
  path: "/verifyAccount",
  name: "/verifyAccount",
  meta: {
   layout: "public_layout"
  },
  component: () => import(/* webpackChunkName: 'signup-verify-account' */ "@/views/Public/Signup/VerifyAccount.vue")
 }
];
