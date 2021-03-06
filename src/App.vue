<template>
  <div id="app">
    <section class="section">
      <div class="container">
        <order-totals></order-totals>
        <transition name="fade">
          <EntreeBuilder
            v-if="active === 'entree'"
            @update="setActive"
          ></EntreeBuilder>
          <OrderAddon
            v-if="active === 'addon'"
            @update="setActive"
          ></OrderAddon>
          <OrderConfirmation
            v-if="active === 'confirmation'"
            @update="setActive"
            @edit="setEdit"
          ></OrderConfirmation>
          <OrderInformation
            v-if="active === 'order-info'"
            @update="setActive"
          ></OrderInformation>
          <OrderPayment
            v-if="active === 'payment'"
            @update="setActive"
          ></OrderPayment>
          <OrderSummary
            v-if="active === 'summary'"
            @update="setActive"
          ></OrderSummary>
        </transition>
      </div>
    </section>
  </div>
</template>

<script>
import OrderTotals from "./components/OrderTotals";
import EntreeBuilder from "./components/EntreeBuilder";
import OrderAddon from "./components/OrderAddon";
import OrderConfirmation from "./components/OrderConfirmation";
import OrderInformation from "./components/OrderInformation";
import OrderPayment from "./components/OrderPayment";
import OrderSummary from "./components/OrderSummary";
export default {
  components: {
    OrderAddon,
    EntreeBuilder,
    OrderTotals,
    OrderConfirmation,
    OrderInformation,
    OrderPayment,
    OrderSummary
  },
  data() {
    return {
      active: "entree",
      edit: false
    };
  },
  methods: {
    setActive(section) {
      if (this.edit) {
        this.active = "confirmation";
      } else {
        this.active = section;
      }
      this.edit = false;
      document.documentElement.scrollTop = 0;
      document.scrollTop = 0;
    },
    setEdit(section) {
      this.setActive(section);
      this.edit = true;
    }
  },
  name: "App"
};
</script>

<style lang="scss">
$body-size: 24px;

@import "~bulma/sass/utilities/_all";

$primary: #dd3333;
$primary-invert: findColorInvert($primary);
$warning: #f9d400;
$warning-invert: findColorInvert($warning);
$black: #0a0000;
$black-invert: findColorInvert($black);

$colors: (
  "primary": (
    $primary,
    $primary-invert
  ),
  "warning": (
    $warning,
    $warning-invert
  ),
  "info": (
    $info,
    $info-invert
  ),
  "success": (
    $success,
    $success-invert
  ),
  "danger": (
    $danger,
    $danger-invert
  ),
  "black": (
    $black,
    $black-invert
  ),
  "light": (
    $light,
    $light-invert
  ),
  "dark": (
    $dark,
    $dark-invert
  )
);

$steps-active-color: $warning;
$steps-previous-color: $warning;
$radio-active-background-color: $warning;
$navbar-breakpoint: 767px;

@import "~bulma";
@import "~buefy/src/scss/buefy";

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.fade-leave,
.fade-leave-active {
  position: absolute;
}

.order-questions {
  font-size: 150%;
}

.slide-enter-active {
  -moz-transition-duration: 0.3s;
  -webkit-transition-duration: 0.3s;
  -o-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -moz-transition-timing-function: ease-in;
  -webkit-transition-timing-function: ease-in;
  -o-transition-timing-function: ease-in;
  transition-timing-function: ease-in;
}

.slide-leave-active {
  -moz-transition-duration: 0.3s;
  -webkit-transition-duration: 0.3s;
  -o-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to,
.slide-leave {
  max-height: 100px;
  overflow: hidden;
}

.slide-enter,
.slide-leave-to {
  overflow: hidden;
  max-height: 0;
}

.section {
  padding: 3rem 0.2rem;
}
</style>
