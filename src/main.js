import Vue from "vue";
import App from "./App.vue";
import store from "./store";
import Buefy from "buefy";
import VueCurrencyFilter from "vue-currency-filter";
import VeeValidate from "vee-validate";
import { hours } from "./utils/custom-validators";
import LogRocket from "logrocket";

if (process.env.NODE_ENV === "production") {
  LogRocket.init("ae9bjy/seoulspice-pickup");
}

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

VeeValidate.Validator.extend("hours", hours);
Vue.use(VeeValidate);

new Vue({
  store,
  render: h => h(App)
}).$mount("#app");
