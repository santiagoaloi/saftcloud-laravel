import { sync, call } from 'vuex-pathify';

export default {
  beforeRouteLeave(to, from, next) {
    this.resetState().then(() => next());
  },

  mounted() {
    this.loadView(this.$route.meta.id);
  },

  computed: {
    ...sync('activeView/*'),
    ...sync('theme', ['isDark']),
    ...sync('application', ['search']),
  },

  methods: {
    ...call('activeView/*'),
  },
};
