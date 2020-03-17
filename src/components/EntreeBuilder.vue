<template>
  <div class="entree-builder">
    <section class="section">
      <div class="container">
        <transition class="fade">
          <b-field label="Choose your base" v-if="!entree.base">
            <b-select
              v-model="entree.base"
              name="base"
              placeholder="Choose your base"
              key="base-input"
            >
              <option
                v-for="base in entreeOptions.bases"
                :key="base.name"
                :value="base"
                >{{ base.name }} ({{ base.price || currency }})</option
              >
            </b-select>
          </b-field>
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
        onCancel: () => this.$emit("update", "addon"),
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
