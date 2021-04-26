export default {
  methods: {
    redondeoTest(value) {
      value = parseFloat(value).toFixed(2);
      return value;
    },

    calculateImport(value) {
      return value.price * value.qty;
    },

    getStock(id) {
      const index = this.dropdownProducts.findIndex(
        (product) => product.product_id === id
      );
      if (index > 0) {
        return parseFloat(this.dropdownProducts[index].stock);
      } else {
        return 0;
      }
    },

    iconSelectedWeb(item) {
      let result = this.selected.filter(
        (p) => p.transaction_id === item.transaction_id
      );
      if (result.length === 1) {
        return true;
      } else {
        return false;
      }
    },

    iconSelectedMobile(item) {
      let result = this.selected.filter(
        (p) => p.transaction_id === item.transaction_id
      );
      if (result.length === 1) {
        return "mdi-check-circle";
      } else {
        return "mdi-circle-outline";
      }
    },

    iconSelectedMobileColor(item) {
      let result = this.selected.filter(
        (p) => p.transaction_id === item.transaction_id
      );
      if (result.length === 1) {
        return "green";
      } else {
        return "grey";
      }
    },

    // Filtro para el dropdown que limita la busqueda por nombre y codigo de barra de producto.
    filterProductsAll(item, queryText) {
      const searchText = queryText.toLowerCase();
      const fields = [
        item.product_name,
        item.bar_code,
        item.sku,
        item.product_brand,
      ];
      return fields.some(
        (f) => f != null && f.toLowerCase().includes(searchText)
      );
    },

    // Filtro para el dropdown que limita la busqueda por nombre y codigo de barra de producto.
    filterCountries(item, queryText) {
      const searchText = queryText.toLowerCase();
      const fields = [
        item.name,
        item.phone_code,
      ];
      return fields.some(
        (f) => f != null && f.toLowerCase().includes(searchText)
      );
    },
  },
};
