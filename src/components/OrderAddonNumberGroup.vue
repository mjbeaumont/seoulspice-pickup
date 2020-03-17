<template>
  <div>
    <h3 class="subtitle is-3">{{ heading }}</h3>
    <div v-for="choice in group.choices" :key="choice.name">
      <b-field :label="labelText(choice)">
        <b-numberinput
          type="is-black"
          v-model="choice.qty"
          min="0"
        ></b-numberinput>
      </b-field>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    heading() {
      return this.group.type.charAt(0).toUpperCase() + this.group.type.slice(1);
    }
  },
  methods: {
    labelText(addon) {
      return (
        addon.name + " (" + this.$options.filters.currency(addon.price) + ")"
      );
    }
  },
  name: "OrderAddonNumberGroup",
  props: {
    group: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped></style>
