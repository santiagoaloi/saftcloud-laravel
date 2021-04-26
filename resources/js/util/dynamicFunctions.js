export default {
  bindIfStatement(functionName) {
    console.log(functionName);
    try {
      return this[functionName]();
    } catch (e) {
      this.$swal({
        title: "Function not found",
        text: ` We couldn't find the function "${functionName}"`,
        confirmButtonText: "Close",
        confirmButtonColor: "grey",
        backdrop: "rgba(108, 122, 137, 0.8)",
        animation: false,
        icon: "error",
        width: 500,
      });
    }
  },
};
