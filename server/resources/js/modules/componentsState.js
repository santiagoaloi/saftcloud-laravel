import axios from "axios";

const componentsState = {
  state: {
    component: {
      components: {
        activeGroupId: "1",
        activeGroupItem: 0,
        activeGroupFolder: "All",
        activeCarouselItem: 0,
      },
    },
  },

  actions: {},

  mutations: {
    //Components Page
    SET_COMPONENTS_activeGroupItem(state, data) {
      state.component.components.activeGroupItem = data;
    },
    SET_COMPONENTS_activeGroupId(state, data) {
      state.component.components.activeGroupId = data;
    },
    SET_COMPONENTS_activeGroupFolder(state, data) {
      state.component.components.activeGroupFolder = data;
    },
    SET_COMPONENTS_activeCarouselItem(state, data) {
      state.component.components.activeCarouselItem = data;
    },
  },

  getters: {
    GET_COMPONENTS_activeGroupItem: (state) => {
      return state.component.components.activeGroupItem;
    },
    GET_COMPONENTS_activeGroupId: (state) => {
      return state.component.components.activeGroupId;
    },
    GET_COMPONENTS_activeGroupFolder: (state) => {
      return state.component.components.activeGroupFolder;
    },
    GET_COMPONENTS_activeCarouselItem: (state) => {
      return state.component.components.activeCarouselItem;
    },
  },
};

export default componentsState;
