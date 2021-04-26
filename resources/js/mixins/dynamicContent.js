import axios from "axios";
import { mapActions } from "vuex";

export default {
  name: "globalMixin",
  data() {
    return {
      loading: true,
      workspace: this.$route.name,
      elements: [],
    };
  },

  mounted() {
    this.loadWorkplace();
  },

  methods: {
    ...mapActions(["loadWorkplace"]),

    loadWorkplace() {
      var post = {
        workspace: this.workspace,
      };

      axios.post("Formbuilder/loadWorkspace", post).then((response) => {
        if (response.data.status == "success") {
          this.elements = JSON.parse(response.data.data.elements);
          setTimeout(() => {
            this.loading = false;
          }, 1000);
        }
      });
    },
  },
};
