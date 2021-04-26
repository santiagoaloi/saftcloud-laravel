export default {
  name: "headerHistorial",

  mounted() {
    console.log("mixin loaded");
    this.headers.push({
      text: "Historial",
      value: "historial",
      sortable: false,
    });
  },
};
