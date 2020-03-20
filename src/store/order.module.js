import { createHelpers } from "vuex-map-fields";

const { getOrderField, updateOrderField } = createHelpers({
  getterType: "getOrderField",
  mutationType: "updateOrderField"
});

const state = {
  name: null,
  email: null,
  location: null,
  time: null,
  curbside: false,
  tip: null
};

const getters = {
  getOrderField
};

const mutations = {
  updateOrderField
};

export default {
  state,
  getters,
  mutations
};
