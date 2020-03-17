<template>
  <div class="entree-builder">
    <section class="section">
      <div class="container">
        <transition class="fade">
          <div v-if="!entree.base">
            <h3>Choose your base</h3>
            <div class="buttons">
              <b-button
                type="is-warning"
                v-for="base in entreeOptions.bases"
                :key="base.name"
                @click="setBase(base)"
                >{{ base.name }} ({{ base.price || currency }})</b-button
              >
            </div>
          </div>
          <entree-options-component
            :options="entreeOptions"
            :price="price"
            v-if="entree.base"
            @valid="addToCart"
          ></entree-options-component>
        </transition>
      </div>
    </section>
  </div>
</template>

<script>
import entreeOptions from "../config/entree-options";
import EntreeOptionsComponent from "../components/EntreeOptions";
import { ADD_ITEM } from "../store/mutations.type";

export default {
  components: {
    EntreeOptionsComponent
  },
  name: "EntreeBuilder",
  computed: {
    price() {
      let price = 0;
      if (this.entree.base) {
        price += this.entree.base.price;
      }
      this.entreeOptions.options.forEach(option => {
        option.choices.forEach(choice => {
          if (choice.selected) {
            price += choice.price;
          }
        });
      });
      return price;
    }
  },
  data() {
    return {
      entree: {
        base: null,
        type: "entree"
      },
      entreeOptions: entreeOptions
    };
  },
  methods: {
    addToCart() {
      let options = this.entreeOptions.options
        .map(option => {
          let choices = option.choices.filter(choice => choice.selected);
          if (choices.length) {
            return {
              type: option.type,
              cartLabel: option.cartLabel,
              choices: choices
            };
          }
          return null;
        })
        .filter(option => option !== null);

      const optionsToAdd = JSON.parse(JSON.stringify(options));

      const entreeToAdd = {
        name: this.entree.base.name,
        price: this.price,
        qty: 1,
        type: this.entree.type,
        options: optionsToAdd
      };

      this.$store.commit(ADD_ITEM, entreeToAdd);
      this.confirmContinue();
    },
    confirmContinue() {
      this.$buefy.dialog.confirm({
        message: "Would you like to add another entree?",
        onConfirm: () => this.clearEntree(),
        onCancel: () => {
          this.$emit("update", "addon");
          this.clearEntree();
        },
        confirmText: "Yes",
        cancelText: "No"
      });
    },
    clearEntree() {
      this.entree.base = null;
      this.entreeOptions.options.forEach(option => {
        option.choices.forEach(choice => {
          choice.selected = false;
        });
      });
    },
    setBase(base) {
      this.entree.base = base;
    }
  }
};
</script>

<style type="text/scss" scoped>
.box {
  width: 25%;
  margin-top: 1em;
}
</style>
