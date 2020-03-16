import { ADD_ITEM } from "./mutations.type";

const state = {
  items: []
};

const getters = {
  itemSubtotal(state) {
    let st = 0;
    state.items.forEach(item => {
      st += item.price;
      if (item.type === "entree") {
        item.options.forEach(option => {
          option.choices.forEach(choice => {
            st += choice.price;
          });
        });
      }
    });
    return st;
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
