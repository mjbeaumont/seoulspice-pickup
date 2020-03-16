import { ADD_ITEM} from "./mutations.type";

const state = {
  items: []
};

const getters = {};

const mutations = {
  [ADD_ITEM](state, item) {
    state.items.push(item);
  }
};

export default {
  state,
  getters,
  mutations
};
