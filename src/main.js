import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import Buefy from "buefy";
import VueCurrencyFilter from "vue-currency-filter";

Vue.config.productionTip = false;

Vue.use(Buefy, {
  defaultIconPack: "fas"
});

Vue.use(VueCurrencyFilter, {
  symbol: "$",
  thousandsSeparator: ",",
  fractionCount: 2,
  fractionSeparator: ".",
  symbolPosition: "front",
  symbolSpacing: false
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
