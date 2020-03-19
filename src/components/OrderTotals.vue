<template>
  <div class="navbar is-fixed-top is-dark is-transparent">
    <div class="navbar-brand">
      <a class="navbar-item"
        ><img
          class="starting-logo"
          alt="SEOULSPICE"
          src="https://www.seoulspice.com/wp-content/uploads/2017/05/logo1-1.png"
          srcset="
            https://www.seoulspice.com/wp-content/uploads/2017/05/logo1-1.png  1x,
            https://www.seoulspice.com/wp-content/uploads/2017/05/logo1r-1.png 2x
          "
      /></a>
      <a
        role="button"
        class="button is-medium is-outlined is-warning"
        :class="mobileMenuOpen ? 'is-active' : ''"
        aria-label="menu"
        aria-expanded="false"
        @click.prevent="toggleMobileMenu"
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
  padding-right: 280px;
}

.navbar-item img {
  max-height: 2.75em;
}

.starting-logo {
  padding-left: 20px;
  max-width: 250px;
}

/* mobile and tablet */
@media screen and (max-width: 768px) {
  .navbar-start {
    .navbar-item {
      padding-right: 0;
    }
  }
}

/* tablet and bigger */
@media screen and (min-width: 768px) {
  .button.is-medium {
    display: none;
  }

  .starting-logo {
    max-width: 150px;
  }
}
/* mobile */
@media screen and (max-width: 767px) {
  .starting-logo {
    display: none;
  }

  .navbar-brand {
    .button {
      margin: 0 auto;
    }

    .navbar-item {
      padding: 0;
    }
  }
}
</style>
