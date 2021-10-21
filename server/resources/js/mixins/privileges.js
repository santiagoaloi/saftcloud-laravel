import { sync, get } from 'vuex-pathify';

export default {
  computed: {
    privileges: sync('authentication@session.user.privileges'),
    ...get('authentication', ['isRoot']),
  },

  methods: {
    // ...call('activeView/*'),
  },

  mounted() {
    console.log('mounted');
  },
};
