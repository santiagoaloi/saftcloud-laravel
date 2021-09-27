import Vue from 'vue';
import Router from 'vue-router';
import auth from '@/util/auth';
import { store } from '@/store';
import routes from '@/router/routes';

Vue.use(Router);

const createRouter = () => new Router({
  base: '/',
  mode: 'hash',
  linkActiveClass: 'active',
  routes,
});

const router = createRouter();

export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher;
}

const waitForStorageToBeReady = async (to, from, next) => {
  if (to.matched.some((record) => record.meta.layout === 'secure_layout')) {
    if (auth.loggedIn()) {
      await store.restored;
      next();
    } else {
      await store.restored;
      next({ path: '/login' });
    }
  } else {
    next();
  }
};

router.beforeEach(waitForStorageToBeReady);

router.beforeResolve((to, from, next) => {

  if (store.get('application/isBooted')) {
    store.set('application/isBooted', false);
  }

  // If the user is already logged in
  if (auth.loggedIn()) {
    if (to.matched.some((record) => record.name === 'login')) {
      // Redirect to the home page instead
      next({ path: '/components' });
    } else {
      // Continue to the login page
      next();
    }
  } else {
    next();
  }
});




export default router;
