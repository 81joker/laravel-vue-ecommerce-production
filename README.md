1. Install the database. You can find the schema in this link.

2. Install Vite.

3. Install Vue.

4. Install Tailwind CSS.

5. Install [Headless UI](https://headlessui.com/) because we need templates and JavaScript with Tailwind CSS.
   - [Tailwind UI](https://tailwindui.com/)
   - [Headless UI](https://headlessui.com/)
   - [Heroicons](https://heroicons.com/)

   ```bash
   npm install -D @headlessui/vue@latest @heroicons/vue @tailwindcss/forms
   ```

6. Install [Laravel Sluggable](https://github.com/spatie/laravel-sluggable) to generate slugs.


sail artisan cache:clear
sail artisan view:clear
sail artisan route:clear
sail artisan clear-compiled
sail artisan config:cache
sail aritisan make:controller ProductController --api --model=Product


Note: We can make the show  product controller available to id  like $product->id and display the product
   ##
   but when we need to display show with slug we should make model/api/product becuse the route in axios not 
   intgrate with like /product/slug instaed product/id in action store 
   the resoultion for this issue 
   we make in copy from Model product to folder API/Prduct model and implement in Product model

## Stripe Checkout & Orders
### 1-Make account in Stripe

1. Go to https://dashboard.stripe.com/
2. Create an account and add your API keys.
3. Create an account.
4. Create a test card.
5. Add your API keys to your .env file.   


### 2- Instal https://github.com/stripe/stripe-php

1- Go to the https://docs.stripe.com/payments/accept-a-payment and we pick the type from payment 


reviw muss https://thecodeholic.teachable.com/courses/build-and-deploy-laravel-e-commerce-website/lectures/50071132