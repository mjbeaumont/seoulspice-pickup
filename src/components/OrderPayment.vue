<template>
  <section class="section">
    <div class="container">
      <b-message
        type="is-danger"
        title="Payment Error"
        v-if="paymentErrors.length"
      >
        <p>Please correct the following errors:</p>
        <div class="content">
          <ul>
            <li v-for="(error, index) in paymentErrors" :key="index">
              {{ error.message }}
            </li>
          </ul>
        </div>
      </b-message>
      <div id="form-container">
        <div id="sq-card-number"></div>
        <div class="third" id="sq-expiration-date"></div>
        <div class="third" id="sq-cvv"></div>
        <div class="third" id="sq-postal-code"></div>
        <button
          id="sq-creditcard"
          class="button-credit-card"
          @click.prevent="processPayment"
        >
          Pay with card {{ total | currency }}
        </button>
        <button id="sq-apple-pay"></button>
      </div>
    </div>
  </section>

  <!-- end #form-container -->
  <!-- TODO: Add script from step 1.1.3 -->
</template>

<script>
import { mapGetters } from "vuex";
import { orderService } from "../config/api.service";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "getOrderField",
  mutationType: "updateOrderField"
});
export default {
  computed: {
    ...mapGetters(["total", "itemSubtotal", "tax", "items"]),
    ...mapFields(["name", "location", "time", "email", "curbside"])
  },
  data() {
    return {
      paymentForm: null,
      paymentErrors: [],
      submitDisabled: false
    };
  },
  mounted() {
    let that = this;
    // eslint-disable-next-line no-undef
    that.paymentForm = new SqPaymentForm({
      // Initialize the payment form elements
      applicationId: process.env.VUE_APP_SQUAREUP_APPLICATION_ID,
      inputClass: "sq-input",
      locationId:
        process.env.NODE_ENV === "development"
          ? "WC2W1FZKRQMPV"
          : that.location.id,
      autoBuild: false,
      // Customize the CSS for SqPaymentForm iframe elements
      inputStyles: [
        {
          fontSize: "16px",
          lineHeight: "24px",
          padding: "16px",
          placeholderColor: "#a0a0a0",
          backgroundColor: "transparent"
        }
      ],
      // Initialize the credit card placeholders
      cardNumber: {
        elementId: "sq-card-number",
        placeholder: "Card Number"
      },
      cvv: {
        elementId: "sq-cvv",
        placeholder: "CVV"
      },
      expirationDate: {
        elementId: "sq-expiration-date",
        placeholder: "MM/YY"
      },
      postalCode: {
        elementId: "sq-postal-code",
        placeholder: "Postal"
      },
      applePay: {
        elementId: "sq-apple-pay"
      },
      // SqPaymentForm callback functions
      callbacks: {
        /*
         * callback function: cardNonceResponseReceived
         * Triggered when: SqPaymentForm completes a card nonce request
         */
        cardNonceResponseReceived: async function(errors, nonce) {
          if (errors) {
            // Log errors from nonce generation to the browser developer console.
            errors.forEach(function(error) {
              that.paymentErrors.push(error);
            });
            return;
          }
          that.submitDisabled = true;
          const loadingComponent = that.$buefy.loading.open({
            container: null
          });
          let response = await orderService.post("/process-order.php", {
            nonce: nonce,
            totals: {
              subtotal: that.itemSubtotal.toFixed(2),
              tax: that.tax.toFixed(2),
              taxRate: that.taxRate,
              total: that.total.toFixed(2)
            },
            items: that.items,
            order: {
              name: that.name,
              email: that.email,
              location: that.location,
              time: that.time.toLocaleTimeString("en-US", {
                timeStyle: "short"
              }),
              curbside: that.curbside
            }
          });
          loadingComponent.close();

          if (response.status === 200) {
            if (response.data.success) {
              that.$emit("update", "summary");
            } else {
              that.submitDisabled = false;
              that.paymentErrors.push({ message: response.data.message });
            }
          }
        },
        methodsSupported: function(methods, unsupportedReason) {
          // eslint-disable-next-line
          console.log(methods);

          var applePayBtn = document.getElementById("sq-apple-pay");

          // Only show the button if Apple Pay on the Web is enabled
          // Otherwise, display the wallet not enabled message.
          if (methods.applePay === true) {
            applePayBtn.style.display = "inline-block";
          } else {
            // eslint-disable-next-line
            console.log(unsupportedReason);
          }
        },
        createPaymentRequest: function() {
          const paymentRequestJson = {
            requestShippingAddress: false,
            requestBillingInfo: false,
            currencyCode: "USD",
            countryCode: "US",
            total: {
              label: "Seoulspice",
              amount: that.total.toFixed(2),
              pending: false
            }
          };

          return paymentRequestJson;
        }
      }
    });
    this.paymentForm.build();
  },
  methods: {
    processPayment() {
      this.paymentErrors = [];
      if (!this.submitDisabled) {
        this.paymentForm.requestCardNonce();
      }
    }
  },
  name: "OrderPayment"
};
</script>

<style>
#form-container {
  position: relative;
  width: 380px;
  margin: 0 auto;
}

.third {
  float: left;
  width: calc((100% - 32px) / 3);
  padding: 0;
  margin: 0 16px 16px 0;
}

.third:last-of-type {
  margin-right: 0;
}

/* Define how SqPaymentForm iframes should look */
.sq-input {
  height: 56px;
  box-sizing: border-box;
  border: 1px solid #e0e2e3;
  background-color: white;
  border-radius: 6px;
  display: inline-block;
  -webkit-transition: border-color 0.2s ease-in-out;
  -moz-transition: border-color 0.2s ease-in-out;
  -ms-transition: border-color 0.2s ease-in-out;
  transition: border-color 0.2s ease-in-out;
}

/* Define how SqPaymentForm iframes should look when they have focus */
.sq-input--focus {
  border: 1px solid #6e4eec;
}

/* Define how SqPaymentForm iframes should look when they contain invalid values */
.sq-input--error {
  border: 1px solid #e02f2f;
}

#sq-card-number {
  margin-bottom: 16px;
}

/* Customize the "Pay with Credit Card" button */
.button-credit-card {
  border-radius: 50px;
  box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.08), 0px 1px 3px rgba(0, 0, 0, 0.04);
  height: auto;
  font-size: 16px;
  letter-spacing: 0.5px;
  line-height: 24px;
  margin-top: 16px;
  padding: 16px;
  position: relative;
  text-transform: uppercase;
  width: 100%;
  z-index: 1;
  background: linear-gradient(180deg, #8e72ff -57.14%, #6e4eec 125%);
  border: none;
  color: #fff;
}

.button-credit-card:hover {
  background: linear-gradient(180deg, #a791ff -57.14%, #856aef 125%);
  color: #fff;
}

@media screen and (max-width: 767px) {
  #form-container {
    width: 95%;
  }
}

/* Customize the Apple Pay on the Web button */
#sq-apple-pay {
  width: 100%;
  height: 48px;
  padding: 0;
  margin: 24px 0 16px 0;
  background-image: -webkit-named-image(apple-pay-logo-white);
  background-color: black;
  background-size: 100% 60%;
  background-repeat: no-repeat;
  background-position: 50% 50%;
  border-radius: 4px;
  cursor: pointer;
  display: none;
}
</style>
