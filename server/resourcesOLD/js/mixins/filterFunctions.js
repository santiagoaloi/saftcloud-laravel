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
      const index = this.dropdownProducts.findIndex((product) => product.product_id === id);
      if (index > 0) {
        return parseFloat(this.dropdownProducts[index].stock);
      }
      return 0;
    },

    iconSelectedWeb(item) {
      const result = this.selected.filter((p) => p.transaction_id === item.transaction_id);
      if (result.length === 1) {
        return true;
      }
      return false;
    },

    iconSelectedMobile(item) {
      const result = this.selected.filter((p) => p.transaction_id === item.transaction_id);
      if (result.length === 1) {
        return 'mdi-check-circle';
      }
      return 'mdi-circle-outline';
    },

    iconSelectedMobileColor(item) {
      const result = this.selected.filter((p) => p.transaction_id === item.transaction_id);
      if (result.length === 1) {
        return 'green';
      }
      return 'grey';
    },

    // Filtro para el dropdown que limita la busqueda por nombre y codigo de barra de producto.
    filterProductsAll(item, queryText) {
      const searchText = queryText.toLowerCase();
      const fields = [item.product_name, item.bar_code, item.sku, item.product_brand];
      return fields.some((f) => f != null && f.toLowerCase().includes(searchText));
    },

    filterCountries(item, queryText) {
      const searchText = queryText.toLowerCase();
      const fields = [item.name, item.phone_code];
      return fields.some((f) => f != null && f.toLowerCase().includes(searchText));
    },
  },
};
