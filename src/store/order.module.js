import { createHelpers } from "vuex-map-fields";

const { getOrderField, updateOrderField } = createHelpers({
  getterType: "getOrderField",
  mutationType: "updateOrderField"
});

const state = {
  name: null,
  location: null,
  time: null
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
