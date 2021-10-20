import Vue from 'vue';
import Router from 'vue-router';
import auth from '@/util/auth';
import { store } from '@/store';
import routes from '@/router/routes';

Vue.use(Router);

const createRouter = () =>
  new Router({
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
  if (to.matched.some((record) => record.meta.layout === 'secure-layout')) {
    await store.restored;
    if (auth.loggedIn() && to.matched.some((record) => record.name !== 'Login')) {
      next();
    } else {
      await store.restored;
      next({ path: '/Login' });
    }
  } else if (auth.loggedIn() && to.matched.some((record) => record.name === 'Login')) {
    next({ path: '/Components' });
  } else {
    next();
  }
};

router.beforeEach(waitForStorageToBeReady);

export default router;
