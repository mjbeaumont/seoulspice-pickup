import { SET_TAX_EXEMPT } from "./mutations.type";

const state = {};

const getters = {
  subtotal(state, getters, rootState, rootGetters) {
    return rootGetters.itemSubtotal;
  },
  tip(state, getters, rootState) {
    return rootState.order.tip
      ? Number(rootState.order.tip.replace(/[^0-9.-]+/g, ""))
      : 0;
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
    return getters.subtotal + getters.tip + getters.tax;
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
