<template>
  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column is-6">
          <b-field
            label="Enter Name for Pickup"
            :type="{ 'is-danger': errors.has('name') }"
            :message="errors.first('name')"
          >
            <b-input
              v-model="name"
              name="name"
              type="text"
              key="name-input"
              v-validate="'required'"
            ></b-input>
          </b-field>
          <b-field
            label="Email"
            :type="{ 'is-danger': errors.has('email') }"
            :message="errors.first('email')"
          >
            <b-input
              v-model="email"
              name="email"
              type="email"
              icon="envelope"
              v-validate="'required|email'"
            ></b-input>
          </b-field>
          <b-field
            label="Pickup Location"
            :type="{ 'is-danger': errors.has('location') }"
            :message="errors.first('location')"
          >
            <b-select
              v-model="location"
              name="location"
              placeholder="Select a store"
              icon="map-marker"
              key="location-input"
              v-validate="'required'"
            >
              <option
                v-for="location in locations"
                :key="location.id"
                :value="location"
                >{{ location.description }} ({{ location.address }})</option
              >
            </b-select>
          </b-field>
          <b-field
            label="Time"
            :type="{ 'is-danger': errors.has('time') }"
            :message="errors.first('time')"
          >
            <b-timepicker
              v-model="time"
              name="time"
              hour-format="12"
              icon="clock"
              :increment-minutes="15"
              :min-time="minTime"
              :max-time="maxTime"
              :mobile-native="false"
              v-validate="{ required: true, hours: [minTime, maxTime] }"
              :use-html5-validation="false"
            ></b-timepicker>
          </b-field>
          <b-field label="Would you like to add a tip?">
            <div class="block">
              <b-radio name="name" native-value=".1" @input="updateTip">
                10%
              </b-radio>
              <b-radio name="name" native-value=".15" @input="updateTip">
                15%
              </b-radio>
              <b-radio name="name" native-value=".2" @input="updateTip">
                20%
              </b-radio>
            </div>
          </b-field>
          <b-field
            message="Choose a percentage or enter a custom amount in the provided box."
          >
            <b-input v-cleave="masks.numeral" v-model="tip"></b-input>
          </b-field>
          <b-field>
            <b-checkbox type="is-warning" v-model="curbside"
              >I would like to pick up my order at the curb</b-checkbox
            >
          </b-field>
          <div class="has-text-centered buttons">
            <a class="button is-success" @click.prevent="pay"
              ><span>Finish and Pay</span
              ><span class="icon"> <i class="fas fa-arrow-right"></i> </span
            ></a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { createHelpers } from "vuex-map-fields";
import { mapGetters } from "vuex";
import locations from "../config/locations";
import LogRocket from "logrocket";
import cleave from "../utils/cleave-directive";

const { mapFields } = createHelpers({
  getterType: "getOrderField",
  mutationType: "updateOrderField"
});
export default {
  computed: {
    ...mapFields(["name", "email", "location", "time", "curbside", "tip"]),
    ...mapGetters(["subtotal"]),
    minTime() {
      let minTime = new Date();
      minTime.setHours(11, 0, 0);
      return minTime;
    },
    maxTime() {
      let maxTime = new Date();
      maxTime.setHours(20, 0, 0);
      return maxTime;
    }
  },
  created() {
    const now = new Date();

    if (now.getHours() >= 20 || now.getHours() < 11) {
      now.setHours(11);
      now.setMinutes(0);
      this.time = now;
    } else {
      let startTime = new Date(now.getTime() + 15 * 60000);
      const minutes = startTime.getMinutes();
      const hours = startTime.getHours();

      let m = ((((minutes + 7.5) / 15) | 0) * 15) % 60;
      let h = (((minutes / 105 + 0.5) | 0) + hours) % 24;

      startTime.setMinutes(m);
      startTime.setHours(h);

      this.time = startTime;
    }
  },
  data() {
    return {
      locations: locations,
      masks: {
        numeral: {
          numeral: true,
          numeralDecimalScale: 2,
          numeralThousandsGroupStyle: "thousand",
          prefix: "$ "
        }
      }
    };
  },
  directives: { cleave },
  methods: {
    pay() {
      this.$validator.validateAll().then(result => {
        if (result) {
          if (process.env.NODE_ENV === "production") {
            LogRocket.identify(this.email, {
              name: this.name
            });
          }
          this.$emit("update", "payment");
        }
      });
    },
    updateTip(val) {
      this.tip = "$" + (this.subtotal * val).toFixed(2);
    }
  },
  name: "OrderInformation"
};
</script>

<style scoped>
.b-checkbox {
  margin-top: 1em;
}
</style>
