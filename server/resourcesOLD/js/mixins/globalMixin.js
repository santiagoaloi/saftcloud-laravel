export default {
  methods: {
    getComponentMethods() {
      const provide = {};
      const componentFileName = Object.entries(this);

      // Build an object with all the methods of the current Modules that only contains alpha characters.
      for (const method of componentFileName) {
        if (typeof method[1] === 'function' && method[0].match(/^[a-zA-Z]/)) {
          provide[method[0]] = this[method[0]];
        }
      }

      return provide;
    },
  },
};
