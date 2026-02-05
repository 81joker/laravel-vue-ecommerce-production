import './bootstrap';

import './categoray-menu.js';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'
import persist from '@alpinejs/persist'
import {get, post} from "./http.js";
// import collapsible from '@alpinejs/collapsible'
// Alpine.plugin(collapse)

Alpine.plugin(persist)
// Alpine.plugin(collapsible)
window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    // Alpine.store("header", {
    //   cartItemsObject: Alpine.$persist({}),
    //   watchingItems: Alpine.$persist([]),
    //   get watchlistItems() {
    //     return this.watchingItems.length;
    //   },
    //   get cartItems() {
    //     return Object.values(this.cartItemsObject).reduce(
    //       (accum, next) => accum + parseInt(next.quantity),
    //       0
    //     );
    //   },
    // });

    Alpine.data("toast", () => ({
      visible: false,
      delay: 5000,
      percent: 0,
      interval: null,
      timeout: null,
      message: null,
      close() {
        this.visible = false;
        clearInterval(this.interval);
      },
      show(message) {
        this.visible = true;
        this.message = message;

        if (this.interval) {
          clearInterval(this.interval);
          this.interval = null;
        }
        if (this.timeout) {
          clearTimeout(this.timeout);
          this.timeout = null;
        }

        this.timeout = setTimeout(() => {
          this.visible = false;
          this.timeout = null;
        }, this.delay);
        const startDate = Date.now();
        const futureDate = Date.now() + this.delay;
        this.interval = setInterval(() => {
          const date = Date.now();
          this.percent = ((date - startDate) * 100) / (futureDate - startDate);
          if (this.percent >= 100) {
            clearInterval(this.interval);
            this.interval = null;
          }
        }, 30);
      },
    }));

    Alpine.data("productItem", (product) => {
      return {
        product,
        addToCart(quantity = 1) {
            post(this.product.addToCartUrl, { quantity })
            .then(result => {
                this.$dispatch("cart-change" , {count: result.count})
                this.$dispatch("notify", {
                    message: "The item was added into the cart",
                });
            })
            .catch(response => {
                console.log(response);

            })
        },

        removeItemFromCart() {
            post(this.product.removeUrl)
            .then(result => {
              this.$dispatch("notify", {
                message: "The item was removed from the cart",
              })
              this.$dispatch("cart-change" , {count: result.count})
                this.cartItems = this.cartItems.filter(p => p.id !== this.product.id);
                // this.cartItems = this.cartItems.filter(p => p.id !== product.id)

            })
        },

        changeQuantity() {
            post(this.product.updateQuantityUrl, { quantity: product.quantity })
            .then(result => {
                this.$dispatch("cart-change" , {count: result.count})
                this.$dispatch("notify", {
                    message: "The quantity was changed (^_^)",
                })
            })
        },


      };
    });
  });
  Alpine.start();
