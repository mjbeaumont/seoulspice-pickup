<template>
  <section class="section">
    <div class="container">
      <transition-group name="fade">
        <order-addon-number-group
          :key="drinkOptions.type"
          :group="drinkOptions"
          v-if="active === 'drinks'"
        ></order-addon-number-group>

        <order-addon-number-group
          :key="dessertOptions.type"
          :group="dessertOptions"
          v-if="active === 'desserts'"
        ></order-addon-number-group>
      </transition-group>
      <div class="has-text-centered buttons">
        <a class="button is-success" @click.prevent="addItems()"
          ><span>Continue</span></a
        >
      </div>
    </div>
  </section>
</template>

<script>
import { ADD_ITEM } from "../store/mutations.type";
import OrderAddonNumberGroup from "./OrderAddonNumberGroup";
import drinkOptions from "../config/drink-options";
import dessertOptions from "../config/dessert-options";
export default {
  components: {
    OrderAddonNumberGroup
  },
  data() {
    return {
      drinkOptions: drinkOptions,
      dessertOptions: dessertOptions,
      active: "drinks"
    };
  },
  methods: {
    addItems() {
      const choices =
        this.active === "drinks"
          ? this.drinkOptions.choices
          : this.dessertOptions.choices;
      const choicesToAdd = choices.filter(choice => choice.qty > 0);

      if (choicesToAdd.length) {
        choicesToAdd.forEach(choice => {
          const itemToAdd = {
            name: choice.name,
            qty: choice.qty,
            type: "drink",
            price: choice.price,
            options: null
          };
          this.$store.commit(ADD_ITEM, itemToAdd);
        });
      }

      if (this.active === "drinks" && !this.activeAddon) {
        this.active = "desserts";
      } else {
        this.$emit("update", "confirmation");
      }
    }
  },
  name: "OrderAddon"
};
</script>

<style scoped>
.buttons {
  margin-top: 1em;
}
</style>
