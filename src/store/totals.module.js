import { SET_TAX_EXEMPT } from "./mutations.type";

const state = {
  taxExempt: false
};
const getters = {
  /*subtotal(state, getters, rootState, rootGetters) {
    let st = 0;
    return st;
  },*/
  subtotal(state) {
    return state.taxExempt;
  },
  tax(state, getters) {
    return getters.subtotal * getters.taxRate;
  },
  taxRate() {
    //return rootState.order.location.taxRate;
    return 0.06;
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
