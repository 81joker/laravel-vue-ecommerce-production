<?php
/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();
?>
<x-app-layout>
    <div  class="-mt-5 -mr-5 -ml-5">
        <x-category-list :category-list="$categoryList"   />
    </div>
     <div class="gird md:flex gap-2 items-centerp-3 pb-0 p-3" x-data="{
        selectedSort: '{{ request()->get('sort', '-updated_at') }}',
        searchKeyword: '{{ request()->get('search') }}',
        updateUrl() {
            {{-- First way --}}
            {{-- let url = new URL(window.location);
                  url.searchParams.set('sort', this.selectedSort);
                  window.location.href = url; --}}
    
            {{-- Second way --}}
            const params = new URLSearchParams(window.location.search);
            params.append('sort', this.selectedSort);
            if(this.searchKeyword){
                params.append('search', this.searchKeyword);
            } else {
                params.delete('search');
                }
            window.location.href = window.location.pathname + '?' + params.toString();
        }
    }">
        <form method="GET" action="" class="flex-1" @submit.prevent="updateUrl">
            <x-text-input type="text" name="search" placeholder="Search for Products"
                value="{{ request()->get('search') }}" x-model="searchKeyword" />
        </form>
        <div class="mt-2 md:mt-0">
            <x-text-input x-model="selectedSort" @change="updateUrl()" type="select" name="sort"
                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                <option value="price">Price (ASC)</option>
                <option value="-price">Price (DESC)</option>
                <option value="title">Title (ASC)</option>
                <option value="-title">Title (ASC)</option>
                <option value="-updated_at">Last Modified at the top</option>
                <option value="updated_at">Last Modified at the bottom</option>
            </x-text-input>
        </div>
    </div>
    <?php if ($products->count() === 0): ?>
    <div class="text-center text-gray-600 py-16 text-xl">
        There are no products published
    </div>
    <?php else: ?>
    <div class="grid gap-1 md:gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5 overflow-hidden">
        @foreach ($products as $product)
            <!-- Product Item -->
            <div x-data="productItem({{ json_encode([
                'id' => $product->id,
                'title' => $product->title,
                'image' => $product->image,
                'description' => $product->description,
                'price' => $product->price,
                'addToCartUrl' => route('cart.add', $product),
            ]) }})"
                class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg  w-full hover:border-purple-600 transition-colors">

                <a href="{{ route('product.view', $product->slug) }}"
                    class="relative p-2.5 h-96 overflow-hidden rounded-xl bg-clip-border">
                    <img src="{{ $product->image ?: '/images/no-image.png' }}"
                        alt="{{ Str::limit($product->title, 10) }}"
                        class="h-full w-full object-cover rounded-md hover:rotate-1 transition-transform" />
                </a>
                <div class="p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-slate-800 text-xl font-semibold overflow-hidden">
                            {{ Str::limit($product->title, 25) }}
                        </p>
                        <p class="text-purple-600 text-xl font-semibold">
                            ${{ $product->price }}
                        </p>
                    </div>
                    <p class="text-slate-600 leading-normal font-light overflow-hidden">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    <button
                        class="btn-primary w-full mt-6 py-2 px-4 border border-transparent 
                  text-sm transition-all shadow-md hover:shadow-lg focus:bg-purple-700
                  focus:shadow-none active:bg-purple-700 hover:bg-purple-700 
                  active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        @click="addToCart()">
                        Add to Cart
                    </button>
                </div>
            </div>
            <!--/ Product Item -->
        @endforeach
    </div>
    <div class="p-5 text-start">
        {{ $products->links() }}
    </div>
    <?php endif; ?>

</x-app-layout>
