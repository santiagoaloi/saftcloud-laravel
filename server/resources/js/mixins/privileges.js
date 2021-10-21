import { sync, call } from 'vuex-pathify';

export default {
  computed: {
    privileges: sync('authentication@session.user.privileges'),
  },

  methods: {
    // ...call('activeView/*'),
  },
};
