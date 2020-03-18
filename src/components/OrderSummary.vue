<template>
  <section class="section">
    <div class="container">
      <div class="box">
        <p class="thanks">
          Thank you for choosing SEOULSPICE!<br />
          We are so excited to #FEEDYOURSEOUL with delicious Korean comfort food
          💪 🇰🇷
        </p>
        <div class="content">
          <h3>Order Information</h3>
          <p>
            <strong>Name: </strong> {{ name }}<br />
            <strong>Email: </strong> {{ email }} <br />
            <strong>Location: </strong> {{ location.description }} ({{
              location.address
            }})<br />
            <strong>Time:</strong> {{ shortTime }}<br />
          </p>
          <p v-if="curbside">
            <em
              >Please call {{ location.phone }} upon arriving at the restaurant
              and we will bring your order out to you.</em
            >
          </p>
          <h3>Items Ordered</h3>
          <div v-for="(item, index) in items" :key="index">
            <p>{{ item.qty }} X {{ item.name }} [{{ item.price }}]</p>
            <ul v-if="item.type === 'entree'">
              <li
                v-for="(option, index) in item.options"
                v-html="printOptions(option)"
                :key="index"
              ></li>
            </ul>
          </div>
          <h3>Order Totals</h3>
          <p>
            <strong>Subtotal: </strong> {{ itemSubtotal | currency }}<br />
            <strong>Tax: </strong> {{ tax | currency }}<br />
            <strong>Totals: </strong> {{ total | currency }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "getOrderField",
  mutationType: "updateOrderField"
});
export default {
  computed: {
    ...mapGetters(["total", "itemSubtotal", "tax", "items"]),
    ...mapFields(["name", "location", "time", "email", "curbside"]),
    shortTime() {
      return this.time.toLocaleTimeString("en-US", {
        timeStyle: "short"
      });
    }
  },
  methods: {
    printOptions(option) {
      let optionText = "";
      optionText += "<strong>" + option.cartLabel + ": </strong>";
      optionText += option.choices
        .map(choice => {
          return choice.name;
        })
        .join(", ");
      return optionText;
    }
  },
  name: "OrderSummary"
};
</script>

<style scoped>
h3 {
  margin-top: 20px;
}
</style>
