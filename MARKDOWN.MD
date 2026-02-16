
nano ~/.bashrc
ln -s ~/Laravel/XXXXX----laravel-vue-ecommerce/LaravelVue-Ecommerce-production/laravel-vue-ecommerce-production ~/laravel
source ~/.bashrc


sail artisan test --filter=test_guest_cannot_access_products_api


sail artisan test --filter=ProductApiTest





