import { SET_TAX_EXEMPT } from "./mutations.type";

const state = {
  taxExempt: false
};
const getters = {
  subtotal(state, getters, rootState, rootGetters) {
    return rootGetters.itemSubtotal;
  },
  tax(state, getters) {
    return getters.subtotal * getters.taxRate;
  },
  taxRate(state, getters, rootState) {
    return rootState.order.location ? rootState.order.location.taxRate : 0;
  },
  taxRateHuman(state, getters) {
    return getters.taxRate * 100;
  },
  total(state, getters) {
    return getters.subtotal + getters.tax;
  }
};
const actions = {};
const mutations = {
  [SET_TAX_EXEMPT](state, val) {
    state.taxExempt = val;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
