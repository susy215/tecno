<template>
    <HomeLayout>
        <div class="py-6 sm:py-8 lg:py-12 dark:bg-slate-900">
            <div class="max-w-screen-xl px-4 mx-auto md:px-40">
                <div class="grid gap-8 md:grid-cols-2">
                    <!-- images - start -->
                    <div class="grid gap-4 lg:grid-cols-5">
                        <div class="flex order-last h-64 gap-4 lg:order-none lg:flex-col small-images">
                            <div class="overflow-hidden bg-gray-100 shadow-md rounded-lg"
                                v-for="(image, index) in product.product_images" :key="index"
                                @click="setCurrentImage(image)">
                                <img :src="image.src || `/${image.image}`" loading="lazy" alt="Product Image Thumbnail"
                                    class="object-cover object-center w-full h-full cursor-pointer" 
                                    @error="$event.target.src='https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png'" />
                            </div>
                        </div>

                        <div class="relative overflow-hidden shadow-md rounded-lg h-80 lg:col-span-4">
                            <img
                                :src="currentImage && (currentImage.src || currentImage.image) ? (currentImage.src || `/${currentImage.image}`) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png'"
                                loading="lazy"
                                alt="Main Product Image"
                                class="object-cover object-center w-full h-full"
                                @error="$event.target.src='https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png'"
                            />

                            <span
                                class="absolute left-0 top-0 rounded-br-lg bg-red-500 px-3 py-1.5 text-sm uppercase tracking-wider text-white">
                                {{ $t('sale') }}
                            </span>
                        </div>
                    </div>
                    <!-- images - end -->

                    <!-- content - start -->
                    <div class="md:py-8">
                        <!-- name - start -->
                        <div class="mb-2 md:mb-3">
                            <span class="mb-0.5 inline-block text-gray-500 dark:text-slate-400">
                                {{ product.category.category }}
                            </span>
                            <h2 class="text-2xl font-bold text-gray-800 lg:text-3xl dark:text-slate-50">
                                {{ product.title }}
                            </h2>
                        </div>
                        <!-- name - end -->
                        <!-- price - start -->
                        <div class="mb-4">
                            <div class="flex items-end gap-2">
                                <span class="text-xl font-bold text-gray-800 md:text-2xl dark:text-slate-100">
                                    Bs. {{ product.price }}
                                </span>
                                <span class="mb-0.5 text-red-500 line-through">${{ product.sellingprice }}</span>
                            </div>

                            <span class="text-sm text-gray-500 dark:text-slate-400">{{ product.description }}</span>

                            <form class="mt-2">
                                <label for="counter-input"
                                    class="block mb-1 text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $t('Choose quantity') }}
                                </label>
                                <div class="relative flex items-center">
                                    <button type="button" id="decrement-button"
                                        class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-gray-100 border border-gray-300 rounded-md dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none"
                                        @click="decrementQuantity">
                                        <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 1h16" />
                                        </svg>
                                    </button>
                                    <input type="text" id="counter-input"
                                        class="flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                        v-model="quantity" readonly required />
                                    <button type="button" id="increment-button"
                                        class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-gray-100 border border-gray-300 rounded-md dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none"
                                        @click="incrementQuantity">
                                        <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 1v16M1 9h16" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- price - end -->
                        <!-- buttons - start -->
                        <div class="flex gap-2.5">
                            <a href="#"
                                class="flex-1 inline-block px-8 py-3 text-sm font-semibold text-center text-white transition duration-100 bg-yellow-500 rounded-lg outline-none ring-indigo-300 hover:bg-yellow-600 focus-visible:ring active:bg-yellow-700 sm:flex-none md:text-base"
                                @click="addToCart(product)">{{ $t('Add to cart') }}</a>

                            <a @click="addToCartBuy(product)" href="#"
                                class="inline-block px-8 py-3 text-sm font-semibold text-center text-gray-500 transition duration-100 bg-gray-200 rounded-lg outline-none ring-indigo-300 hover:bg-gray-300 focus-visible:ring active:text-gray-700 md:text-base dark:bg-slate-200">{{
                                $t('Buy now') }}</a>
                        </div>
                        <!-- buttons - end -->
                    </div>
                    <!-- content - end -->
                </div>
            </div>
        </div>
    </HomeLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import HomeLayout from "@/Layouts/HomeLayout.vue";

const props = defineProps({
    product: Object,
    users: Object,
});

// Imagen principal reactiva, con fallback si no hay imágenes
const currentImage = ref(
    props.product.product_images && props.product.product_images.length > 0
        ? props.product.product_images[0]
        : { image: '' }
);

const setCurrentImage = (image) => {
    currentImage.value = image;
};

const quantity = ref(1);

const incrementQuantity = () => {
    quantity.value++;
};

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const addToCartBuy = (product) => {
    const productData = {
        quantity: quantity.value
    };
    router.post(route("cart.store", { product: product.id }), productData, {
        onSuccess: () => {
            router.get(route("cart.view"));
        }
    });
};
const addToCart = (product) => {
    const productData = {
        quantity: quantity.value
    };
    router.post(route("cart.store", { product: product.id }), productData, {});
};
</script>

<style scoped>
.small-images .overflow-hidden {
    cursor: pointer;
}
</style>
