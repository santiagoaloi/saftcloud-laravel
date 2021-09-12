// https://davestewart.github.io/vuex-pathify/#/setup/config

import pathify from "vuex-pathify";

// options
pathify.options.deep = true;
pathify.options.mapping = "simple";
pathify.options.strict = false;
pathify.options.cache = true; // cache generated functions for faster re-use

export default pathify;
