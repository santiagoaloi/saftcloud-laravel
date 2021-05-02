const element = {
  state: {
    params: [],
    preview: [],
    element: "",
    workspace: "",
    workspaceAlias: "",
    workspaceType: "",
    previewing: false,
    elementFrames: false,
  },

  actions: {
    saveElementParams({ commit }, { params }) {
      commit("SET_elementParams", params);
    },

    saveElementInfo({ commit }, { element }) {
      commit("SET_elementInfo", element);
    },

    setElementWorkspace({ commit }, { workspace }) {
      commit("SET_elementWorkspace", workspace);
    },

    clearElementParams({ commit }) {
      commit("SET_clear");
    },

    setElementsPreview({ commit }, { preview }) {
      commit("SET_elementsPreview", preview);
    },

    setElementsPreviewing({ commit }, { previewing }) {
      commit("SET_elementsPreviewing", previewing);
    },

    setElementFrames({ commit }) {
      commit("SET_elementFrames");
    },

    setElementImageUpload({ commit }, { image }) {
      commit("SET_elementImageUpload", image);
    },

    setElementImageMultipleUpload({ commit }, { images }) {
      commit("SET_elementImageMultipleUpload", images);
    },

    setElementTextAdvanced({ commit }, { text }) {
      commit("SET_elementTextAdvanced", text);
    },
  },

  mutations: {
    SET_elementTextAdvanced(state, data) {
      state.params.elementText = data;
    },

    SET_elementImageUpload(state, data) {
      state.params.image = data;
    },

    SET_elementImageMultipleUpload(state, data) {
      console.log(data);
      state.params.images = data;
    },

    SET_elementsPreviewing(state, data) {
      state.previewing = data;
    },

    SET_elementsPreview(state, data) {
      state.preview = data;
    },

    SET_elementWorkspace(state, data) {
      state.workspace = data;
    },

    SET_elementWorkspaceAlias(state, data) {
      state.workspaceAlias = data;
    },

    SET_elementWorkspaceType(state, data) {
      state.workspaceType = data;
    },

    SET_elementParams(state, data) {
      state.params = data;
    },

    SET_elementInfo(state, data) {
      state.element = data;
    },

    SET_elementFrames(state) {
      state.elementFrames = !state.elementFrames;
    },

    SET_elementFramesEnabled(state) {
      state.elementFrames = true;
    },

    SET_clear(state) {
      state.params = [];
    },
  },

  getters: {
    activeWorkspace: (state) => {
      return state.workspace == "" ? null : state.workspace;
    },

    previewing: (state) => {
      return state.previewing;
    },

    activeWorkspaceAlias: (state) => {
      return state.workspaceAlias == "" ? null : state.workspaceAlias;
    },

    workspaceType: (state) => {
      return state.workspaceType;
    },
  },
};

export default element;
