import { call } from "vuex-pathify";

export default {
 name: "ComponentActionsMmixin",
 methods: {
  ...call("componentManagement/*"),

  removeComponentWarning(id, method, apiPath, title) {
   this.$swal({
    title: `<span style="color:${this.isDark ? "lightgrey" : ""} "> Delete component? </span>`,
    html: `<span style="color:${this.isDark ? "lightgrey" : ""} "> This component will be deleted inmediately.</span>`,
    color: "white",
    showCancelButton: true,
    confirmButtonText: "Delete",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#EC407A",
    backdrop: `${this.isDark ? "rgba(0, 0, 0, 0.6)" : "rgba(108, 122, 137, 0.8)"}`,
    background: `${this.isDark ? "#2f3136" : ""}`,
    width: 600
   }).then(result => {
    if (result.value) {
     this.removeComponent({ id, method, apiPath });
    }
   });
  }
 }
};
