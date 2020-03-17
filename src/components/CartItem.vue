<template>
  <div class="box">
    <div class="columns">
      <div class="column is-6">
        {{ item.name }}
      </div>
      <div class="column is-2">{{ price | currency }}</div>
      <div class="column is=4">
        <div class="columns">
          <div class="column is-10">
            <b-field>
              <b-numberinput
                :value="item.qty"
                @input="updateQty"
                min="1"
                type="is-black"
              ></b-numberinput>
            </b-field>
          </div>
          <div class="column is-2">
            <a class="delete is-large" @click.prevent="removeItem()"></a>
          </div>
        </div>
      </div>
    </div>
    <ul v-if="item.type === 'entree'" class="options">
      <li
        v-for="(option, index) in item.options"
        v-html="printOptions(option)"
        :key="index"
      ></li>
    </ul>
  </div>
</template>

<script>
import { UPDATE_QTY, REMOVE_ITEM } from "../store/mutations.type";
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters(["countEntrees"]),
    price() {
      return this.item.price * this.item.qty;
    }
  },
  methods: {
    printOptions(option) {
      let optionText = "";
      optionText += "<strong>" + option.cartLabel + ": </strong>";
      optionText += option.choices
        .map(choice => {
          let choiceText = choice.name;
          if (choice.price > 0) {
            choiceText += " (+" + choice.price + ")";
          }
          return choiceText;
        })
        .join(", ");
      return optionText;
    },
    updateQty(val) {
      this.$store.commit(UPDATE_QTY, { qty: val, index: this.index });
    },
    removeItem() {
      if (this.item.type === "entree" && this.countEntrees === 1) {
        this.$buefy.toast.open({
          duration: 5000,
          message:
            "You must have at least one entree in your cart to place an order.",
          type: "is-danger"
        });
      } else {
        this.$store.commit(REMOVE_ITEM, this.index);
      }
    }
  },
  name: "CartItem",
  props: ["item", "index"]
};
</script>

<style scoped>
.options {
  border-top: 1px solid #ccc;
  margin-top: 15px;
  padding-top: 15px;
}
</style>
