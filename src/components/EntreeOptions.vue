<template>
  <div>
    <entree-option-checkbox-group
      v-for="group in options"
      :key="group.type"
      :group="group"
    ></entree-option-checkbox-group>
    <div class="has-text-centered buttons">
      <a class="button is-info" @click.prevent="setActiveOrderStep()"
        ><span>Add to Cart</span
        ><span class="icon"> <i class="fas fa-arrow-right"></i> </span
      ></a>
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
    return {};
  },
  methods: {
    checkMinSelected() {
      return this.options
        .filter(option => option.required)
        .every(option => option.choices.some(choice => choice.selected));
    },
    setActiveOrderStep() {
      if (this.checkMinSelected()) {
        this.$emit("valid", this.options);
      } else {
        this.$buefy.toast.open({
          message:
            "Please select at least one protein, veggie, sauce, and topping to continue.",
          type: "is-danger",
          duration: 6000
        });
      }
    }
  },
  name: "OrderDetailsOptions",
  props: ["options"]
};
</script>

<style scoped></style>
