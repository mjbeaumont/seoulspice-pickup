<template>
  <div id="app">
    <section class="section">
      <div class="container">
        <order-totals></order-totals>
        <router-view />
      </div>
    </section>
  </div>
</template>

<script>
import OrderTotals from "./components/OrderTotals";
export default {
  components: {
    OrderTotals
  }
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
</style>
