<template>
  <div>
    <transition-group name="fade" mode="out-in">
      <entree-option-checkbox-group
        v-for="step in steps"
        :group="options.getOption(step)"
        v-show="active === step"
        :key="step"
      ></entree-option-checkbox-group>
    </transition-group>
    <div class="has-text-centered buttons">
      <a
        class="button is-info"
        @click.prevent="setActiveOrderStep()"
        v-if="active !== 'extras'"
        ><span>Next</span
        ><span class="icon"> <i class="fas fa-arrow-right"></i> </span
      ></a>
      <a
        class="button is-success"
        @click.prevent="addItem()"
        v-if="active === 'extras'"
        ><span>Add to Cart ({{ price | currency }})</span></a
      >
    </div>
  </div>
</template>

<script>
import EntreeOptionCheckboxGroup from "./EntreeOptionCheckboxGroup";

export default {
  components: {
    EntreeOptionCheckboxGroup
  },
  computed: {},
  data() {
    return {
      active: "proteins",
      steps: [
        "proteins",
        "extraProteins",
        "veggies",
        "sauces",
        "toppings",
        "extras"
      ]
    };
  },
  methods: {
    addItem() {
      this.$emit("valid");
    },
    advanceStep() {
      this.active = this.steps[
        this.steps.findIndex(step => step === this.active) + 1
      ];
    },
    checkMinSelected(option) {
      return option.choices.some(choice => choice.selected);
    },
    setActiveOrderStep() {
      const option = this.options.getOption(this.active);

      if (this.checkMinSelected(option)) {
        this.advanceStep();
      } else {
        this.$buefy.dialog.confirm({
          message:
            "Are you sure you want to continue without selecting any options?",
          onConfirm: () => this.advanceStep(),
          confirmText: "Yes",
          cancelText: "No"
        });
      }
    }
  },
  name: "OrderDetailsOptions",
  props: ["options", "price"]
};
</script>

<style scoped></style>
