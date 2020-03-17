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
          <OrderAddonSelector v-if="active === 'addon'"></OrderAddonSelector>
        </transition>
      </div>
    </section>
  </div>
</template>

<script>
import OrderTotals from "./components/OrderTotals";
import EntreeBuilder from "./components/EntreeBuilder";
import OrderAddonSelector from "./components/OrderAddonSelector";
export default {
  components: {
    OrderAddonSelector,
    EntreeBuilder,
    OrderTotals
  },
  data() {
    return {
      active: "entree"
    };
  },
  methods: {
    setActive(section) {
      this.active = section;
    }
  },
  name: "App"
};
</script>

<style lang="scss">
$body-size: 18px;

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
</style>
