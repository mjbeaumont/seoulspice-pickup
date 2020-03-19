<template>
  <section class="section">
    <div class="container">
      <cart-item
        v-for="(item, index) in items"
        :key="index"
        :item="item"
        :index="index"
      ></cart-item>
      <div class="has-text-centered buttons">
        <a class="button is-danger" @click.prevent="editOrder('entree')"
          ><span>Add Entree</span></a
        ><a class="button is-danger" @click.prevent="editOrder('addon')"
          ><span>Add Drink/Dessert</span></a
        ><a class="button is-success" @click.prevent="confirmItems()"
          ><span>Continue</span
          ><span class="icon"> <i class="fas fa-arrow-right"></i> </span
        ></a>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
import CartItem from "./CartItem";
export default {
  components: {
    CartItem
  },
  computed: {
    ...mapGetters(["items"])
  },
  name: "OrderConfirmation",
  methods: {
    editOrder(type) {
      this.$emit("edit", type);
    },
    confirmItems() {
      this.$gtag.event("begin-checkout");
      this.$emit("update", "order-info");
    }
  }
};
</script>

<style scoped></style>
