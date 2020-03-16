import Vue from "vue";
import Vuex from "vuex";
import totals from "./totals.module";
import cart from "./cart.module";

Vue.use(Vuex);

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== "production",
  modules: {
    totals,
    cart
  }
});
