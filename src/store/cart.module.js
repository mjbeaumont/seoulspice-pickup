import { ADD_ITEM } from "./mutations.type";

const state = {
  items: []
};

const getters = {
  itemSubtotal(state) {
    return state.items.reduce((carry, item) => carry + (item.price * item.qty), 0);
  }
};

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
