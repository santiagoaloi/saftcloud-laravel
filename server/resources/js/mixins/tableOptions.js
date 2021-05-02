export default {
  data() {
    return {
      selected: [],
      page: 1,
      pageCount: 0,
      itemsPerPage: Number(
        this.parentData.componentSettings.tableSettings.perpage
      ),
    };
  },
  computed: {
    tableOptions() {
      return {
        dense: this.dense(),
        "disable-filtering": this.disableFiltering(),
        "disable-pagination": this.disablePagination(),
        "disable-sort": this.disableSort(),
        "hide-default-footer": true,
        "hide-default-header": this.hideHeaders(),
        "single-select": this.singleSelect(),
        "show-select": this.showSelect(),
        "mobile-breakpoint": this.breakpoint(),
        "sort-by": this.sortBy(),
        "items-per-page": this.perPage(),
        "footer-props": { itemsPerPageOptions: [5, 10, 20, 30, 50, 100] },
        "item-key": this.itemKey(),
        fixedHeader: true,
        page: this.page,
        search: this.parentData.appBar.search,
      };
    },
  },

  watch: {
    selected(newValue, oldVal) {
      if (newValue === oldVal) return; // Don't do anything.
      this.$emit("input", newValue); // emit input change to v-model
    },
  },

  methods: {
    itemKey() {
      return this.parentData.primaryKey;
    },

    dense() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return false;
      if (
        this.parentData.componentSettings.tableSettings.options.includes(
          "dense"
        )
      )
        return true;
    },

    disableFiltering() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return false;
      if (
        this.parentData.componentSettings.tableSettings.options.includes(
          "disableFiltering"
        )
      )
        return true;
    },
    disablePagination() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return false;
      if (
        this.parentData.componentSettings.tableSettings.options.includes(
          "disablePagination"
        )
      )
        return true;
    },
    disableSort() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return false;
      if (
        this.parentData.componentSettings.tableSettings.options.includes(
          "disableSorting"
        )
      )
        return true;
    },
    hideFooter() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return false;
      if (
        this.parentData.componentSettings.tableSettings.options.includes(
          "hideFooter"
        )
      )
        return true;
    },
    hideHeaders() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return false;
      if (
        this.parentData.componentSettings.tableSettings.options.includes(
          "hideHeaders"
        )
      )
        return true;
    },
    singleSelect() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return false;
      if (
        this.parentData.componentSettings.tableSettings.options.includes(
          "singleSelection"
        )
      )
        return true;
    },
    showSelect() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return true;
      if (
        this.parentData.componentSettings.tableSettings.options.includes(
          "ShowCheckboxes"
        )
      )
        return true;
    },
    breakpoint() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return null;
      return this.parentData.componentSettings.tableSettings.breakpoint;
    },
    height() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return null;
      return this.parentData.componentSettings.tableSettings.height;
    },
    sortBy() {
      if (
        Object.keys(this.parentData.componentSettings.tableSettings).length == 0
      )
        return null;
      return this.parentData.componentSettings.tableSettings.sortBy;
    },

    perPage() {
      return this.itemsPerPage;
    },

    pagination() {
      return `${this.$refs.dataTable.$children[0].pageStart}-${this.$refs.dataTable.$children[0].pageStop} of ${this.$refs.dataTable.$children[0].itemsLength}`;
    },
  },
};
