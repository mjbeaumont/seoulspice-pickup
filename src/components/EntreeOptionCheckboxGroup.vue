<template
  ><b-field :addons="false" :label="labelText">
    <b-checkbox
      v-for="choice in group.choices"
      :key="choice.name"
      v-model="choice.selected"
      :disabled="checkboxIsDisabled(choice)"
      type="is-warning"
    >
      {{ choice.name }}
    </b-checkbox>
  </b-field>
</template>

<script>
export default {
  computed: {
    labelText() {
      return this.group.label + " (Choose up to  " + this.group.max + ")";
    },
    countSelectedOptions() {
      return this.group.choices.filter(choice => choice.selected).length;
    }
  },
  methods: {
    checkboxIsDisabled(item) {
      return this.countSelectedOptions >= this.group.max && !item.selected;
    },
    updateOption() {
      return 1;
    }
  },
  name: "OrderOptionCheckboxGroup",
  props: {
    group: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped></style>
