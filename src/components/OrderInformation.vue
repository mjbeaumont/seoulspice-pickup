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
import locations from "../config/locations";

const { mapFields } = createHelpers({
  getterType: "getOrderField",
  mutationType: "updateOrderField"
});
export default {
  computed: {
    ...mapFields(["name", "location", "time"]),
    minTime() {
      return new Date();
    },
    maxTime() {
      let maxTime = new Date();
      maxTime.setHours(20, 0, 0);
      return maxTime;
    }
  },
  created() {
    const now = new Date();
    let startTime = new Date(now.getTime() + 15 * 60000);
    const minutes = startTime.getMinutes();
    const hours = startTime.getHours();

    let m = ((((minutes + 7.5) / 15) | 0) * 15) % 60;
    let h = (((minutes / 105 + 0.5) | 0) + hours) % 24;

    startTime.setMinutes(m);
    startTime.setHours(h);

    this.time = startTime;
  },
  data() {
    return {
      locations: locations
    };
  },
  methods: {
    pay() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.$emit("update", "payment");
        }
      });
    }
  },
  name: "OrderInformation"
};
</script>

<style scoped></style>
