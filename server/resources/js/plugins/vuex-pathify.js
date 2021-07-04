// https://davestewart.github.io/vuex-pathify/#/setup/config

import pathify from "vuex-pathify";

// options
pathify.options.mapping = "simple";
pathify.options.strict = true;
pathify.options.cache = true; // cache generated functions for faster re-use

export default pathify;
