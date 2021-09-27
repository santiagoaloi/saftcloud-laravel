import { sync, call } from 'vuex-pathify';

export default {
  mounted() {
    this.loadView(this.$route.meta.id);
  },

  computed: {
    ...sync('activeView/*'),
    ...sync('theme', ['isDark']),
    ...sync('application', ['search', 'isBooted']),
  },

  methods: {
    ...call('activeView/*'),
  },
};
