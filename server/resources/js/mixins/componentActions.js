import { call } from "vuex-pathify";

export default {
 name: "ComponentActionsMmixin",
 methods: {
  ...call("componentManagement/*"),

  removeComponentWarning(id, title, mode) {
   console.log(id, title, mode);
   this.$swal({
    title: `<span style="color:${this.isDark ? "lightgrey" : ""} "> Delete ${title}? </span>`,
    html: `<span style="color:${this.isDark ? "lightgrey" : ""} ">  This action cannot be undone. </span>`,
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
     this.removeComponent({ id, mode });
    }
   });
  }
 }
};
