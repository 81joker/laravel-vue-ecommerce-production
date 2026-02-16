
nano ~/.bashrc
ln -s ~/Laravel/XXXXX----laravel-vue-ecommerce/LaravelVue-Ecommerce-production/laravel-vue-ecommerce-production ~/laravel
source ~/.bashrc


sail artisan test --filter=test_admin_can_update_product


sail artisan test --filter=ProductApiTest





