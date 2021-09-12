import { sync, call } from "vuex-pathify";
export default {
 mounted() {
  this.loadView(this.$route.meta.id);
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("application", ["search"]),
  ...sync("activeView/*")
 },

 methods: {
  ...call("activeView/*")
 }
};
