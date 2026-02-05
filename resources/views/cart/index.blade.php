    <x-app-layout>
        <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
            <h1 class="text-3xl font-bold mb-6">Your Cart Items</h1>


            <div class="bg-white p-4 rounded-lg shadow" x-data="{
                cartItems: {{ json_encode(
                    $products->map(
                        fn($product) => [
                            'id' => $product->id,
                            'title' => $product->title,
                            'image' => $product->image,
                            'price' => $product->price,
                            'addToCartUrl' => route('cart.add', $product),
                            'quantity' => $cartItems[$product->id]['quantity'],
                            'href' => route('product.view', $product->slug),
                            'removeUrl' => route('cart.remove', $product),
                            'updateQuantityUrl' => route('cart.update-quantity', $product),
                            // 'quantity' => $cartItems[$product->id]['quantity'] ?? 1,
                            // 'totalPrice' => $product->price * $cartItems[$product->id]['quantity'],
                        ],
                    ),
                ) }},
                get cartTotal() {
                    return this.cartItems.reduce((accum, next) => accum + next.price * next.quantity, 0).toFixed(2)
                }
            }">
                <template x-if="cartItems.length">
                    <div>
                    <!-- Product Items -->
                    <template x-for="product in cartItems" :key="product.id">
                        {{-- [productItem] this is parent function for all product children functions on app.js --}}
                        <div x-data="productItem(product)">
                            <div>
                                <!-- Product Item -->
                                <div class="flex flex-col sm:flex-row items-center gap-4">
                                    <a :href="product.href">
                                        <img :src="product.image" class="w-36" alt="" />
                                    </a>
                                    <div class="flex flex-col justify-between flex-1">
                                        <div class="flex justify-between mb-3">
                                            <h3 x-text="product.title"></h3>
                                            <span class="text-lg font-semibold" x-text="`$${product.price}`"></span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center">
                                                Qty:
                                                <input type="number" min="1" x-model="product.quantity"
                                                    @change="changeQuantity(product.quantity)"
                                                    class="ml-3 py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16">

                                            </div>
                                            <a href="#" @click.prevent="removeItemFromCart()"
                                                class="text-purple-600 hover:text-purple-500">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Product Item -->
                                <hr class="my-5" />
                            </div>

                    </template>
                    <div class="border-t border-gray-300 pt-4">
                        <h1 class="text-3xl font-bold mb-6 text-red-500">Order Summary</h1>
                        <div class="flex justify-between">
                            <span class="font-semibold">Subtotal</span>
                            <span class="text-xl" x-text="`$${cartTotal}`"></span>
                        </div>
                        <p class="text-gray-500 mb-6">
                            Shipping and taxes calculated at checkout.
                        </p>


                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary w-full py-3 text-lg">Proceed to Checkout</button>
                          </form>

                    </div>
                </div>
                </template>
                <template x-if="!cartItems.length">
                    <div class="text-gray-500 py-8 text-center">
                        <h4>You don't have any items in cart</h4>
                    </div>
                </template>


            </div>
        </div>

    </x-app-layout>
