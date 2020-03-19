<template>
  <div class="navbar is-fixed-top is-dark is-transparent">
    <div class="navbar-brand">
      <a
        role="button"
        class="button is-medium is-outlined is-warning"
        :class="mobileMenuOpen ? 'is-active' : ''"
        aria-label="menu"
        aria-expanded="false"
        @click.prevent="toggleMobileMenu"
        ><span class="icon"> <i class="fas fa-cash-register"></i> </span
        ><span>{{ mobileButtonText }}</span></a
      >
    </div>
    <div class="navbar-menu" :class="mobileMenuOpen ? 'is-active' : ''">
      <div class="navbar-start">
        <p class="navbar-item">
          <span class="has-text-warning has-text-weight-bold">Subtotal: </span>
          {{ subtotal | currency }}
        </p>
        <p class="navbar-item" v-if="taxRate > 0">
          <span class="has-text-warning has-text-weight-bold"
            >Tax ({{ taxRateHuman }}%):
          </span>
          {{ tax | currency }}
        </p>
        <p class="navbar-item">
          <span class="has-text-warning has-text-weight-bold">Total: </span>
          {{ total | currency }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Totals",
  computed: {
    mobileButtonText() {
      return this.mobileMenuOpen ? "Hide Totals" : "View Totals";
    },
    ...mapGetters(["subtotal", "tax", "taxRate", "taxRateHuman", "total"])
  },
  data() {
    return {
      mobileMenuOpen: false
    };
  },
  methods: {
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
    }
  }
};
</script>

<style lang="scss" scoped>
.navbar-start {
  margin: 0 auto;
}

@media screen and (min-width: 768px) {
  .button.is-medium {
    display: none;
  }
}
</style>
