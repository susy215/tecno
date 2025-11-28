<script setup>
import { computed } from 'vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { router, Link, usePage } from '@inertiajs/vue3';

defineProps({
  userAddress: Object,
});

const products = computed(() => usePage().props.cart.products);
const carts = computed(() => usePage().props.cart.items);
const total = computed(() => usePage().props.cart.total);

const itemId = (id) => carts.value.findIndex((item) => item.product_id === id);

const update = (product, quantity) =>
  router.patch(route('cart.update', product), {
    quantity,
  });

const remove = (product) => router.delete(route('cart.delete', product));

function submit() {
  router.visit(route('checkout.view'), {
    method: 'get',
    data: {
      carts: usePage().props.cart.data.items,
      products: usePage().props.cart.data.products,
      total: usePage().props.cart.data.total,
      totals: usePage().props.cart.data.total,
    },
  });
}

const totalSellingPrice = computed(() => {
  return products.value.reduce((sum, product) => {
    const cartItem = carts.value.find(item => item.product_id === product.id);
    if (cartItem) {
      return sum + (parseFloat(product.sellingprice) * cartItem.quantity);
    }
    return sum;
  }, 0).toFixed(2);
});
</script>


<template>
    <HomeLayout>
      <div>
        <div class="relative max-w-screen-lg px-4 mx-auto md:px-8">
          <div>
            <h2 class="mb-2 mt-10 md:mt-5 text-2xl font-bold text-center text-gray-800 dark:text-white">
                {{$t('Cart Lists')}}
            </h2>
          </div>
          <div class="block gap-2 mb-6 lg:mr-64 sm:mb-8 md:gap-1 h-96 mt-5 overflow-auto">
            <!-- product - start -->
            <div
              v-for="product in products"
              :key="product.id"
              class="flex flex-wrap overflow rounded-lg gap-x-4 sm:gap-y-4 lg:gap-6 h-32 bg-slate-100 shadow-md shadow-slate-300 mb-3"
            >
              <a
                href="#"
                class="relative block overflow-hidden bg-gray-100 group sm:h-32 sm:w-32"
              >
                <img
                  v-if="product.product_images.length > 0"
                  :src="product.product_images[0].src || `/${product.product_images[0].image}`"
                  loading="lazy"
                  alt="No product images!"
                  class="object-cover object-center transition duration-200 group-hover:scale-110 md:h-full md:w-full w-24 h-24"
                />
                <img
                  v-else
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/495px-No-Image-Placeholder.svg.png?20200912122019"
                  loading="lazy"
                  alt="No product images!"
                  class="object-cover object-center transition duration-200 group-hover:scale-110 md:h-full md:w-full w-24 h-24"
                />
              </a>
              <div class="flex justify-between  py-2">
                <div>
                  <a
                    href="#"
                    class="inline-block text-lg font-bold text-gray-800 transition duration-100 hover:text-gray-500 lg:text-xl text-wrap"
                  >{{ product.title }}</a>
                  <span class="md:block hidden w-80 truncate ">{{ product.description }}</span>
                  <span class="block pt-2 font-bold text-gray-800 md:text-base">
                    Bs. {{ product.price }}
                  </span>
                  <span class="flex items-center gap-1 text-sm text-gray-500">
                    <span class="text-base font-bold text-black">{{ product.qty }}</span>
                    <span v-if="product.qty > 0" class="text-green-600">{{ $t("StockIn") }}</span>
                    <span v-else>{{ $t("StockOut") }}</span>
                  </span>
                </div>
              </div>
              <div class="-mt-28 ml-48 md:ml-0 md:-mt-2 justify-between w-full md:p-4 border-t sm:w-auto sm:border-none sm:pl-0 lg:p-6 lg:pl-0">
                <div class="flex flex-col items-center gap-2">
                  <div class="flex w-20 h-12 ">
                    <div class="relative flex items-center -mb-12 md:mb-0">
                      <button
                        @click.prevent="update(product, carts[itemId(product.id)].quantity - 1)"
                        :disabled="carts[itemId(product.id)].quantity <= 1"
                        type="button"
                        id="decrement-button"
                        data-input-counter-decrement="counter-input"
                        :class="[carts[itemId(product.id)].quantity > 1 ? 'cursor-pointer text-purple-600' : 'cursor-not-allowed text-gray-300 dark:text-gray-500', 'inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-gray-100 border border-gray-300 rounded-md dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none']"
                      >
                        <svg
                          class="w-2.5 h-2.5 text-gray-900 dark:text-white"
                          aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 18 2"
                        >
                          <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 1h16"
                          />
                        </svg>
                      </button>
                      <input
                        v-model="carts[itemId(product.id)].quantity"
                        type="text"
                        id="counter-input"
                        data-input-counter
                        class="flex-shrink-0 text-gray-900 dark:text-slate-700 border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                        placeholder=""
                        value="1"
                        required
                      />
                      <button
                        @click.prevent="update(product, carts[itemId(product.id)].quantity + 1)"
                        type="button"
                        id="increment-button"
                        data-input-counter-increment="counter-input"
                        class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-gray-100 border border-gray-300 rounded-md dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none"
                      >
                        <svg
                          class="w-2.5 h-2.5 text-gray-900 dark:text-white"
                          aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 18 18"
                        >
                          <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 1v16M1 9h16"
                          />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <button
                    @click="remove(product)"
                    class="p-2 text-sm font-semibold transition duration-100 rounded-lg select-none hover:bg-white"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="size-6 text-red-600"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                      />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <!-- product - end -->
          </div>
          <form @submit.prevent="submit">
            <!-- totals - start -->
            <div class="flex flex-col items-end lg:absolute top-14 -end-16">
              <div
                class="p-4 bg-slate-100 rounded-lg w-full h-96 lg:w-80 shadow-md shadow-slate-300"
              >
                <h2 class="text-lg font-semibold text-center mb-6 mt-4 text-gray-900 ">
                  {{$t('Order summary')}}
                </h2>
                <div class="space-y-4">
                  <div class="flex justify-between gap-6 text-gray-500">
                    <span>{{$t('Subtotal')}}</span>
                    <span>Bs. {{ totalSellingPrice }}</span>
                  </div>
                  <div class="flex justify-between gap-4 text-gray-500">
                    <span>{{$t('Discount')}}</span>
                    <span>Bs. {{ totalSellingPrice-total }}</span>
                  </div>
                </div>
                <div class="pt-4 mt-4 border-t">
                  <div class="flex items-start justify-between gap-4 text-gray-800">
                    <span class="text-lg font-bold">{{$t('Total')}}</span>
                    <span class="flex flex-col items-end">
                      <span class="text-lg font-bold">Bs. {{ total }}</span>
                    </span>
                  </div>
                </div>
                <div class="border-t mt-4">
                  <Link
                    :href="route('checkout.view')"
                    class="inline-block px-8 py-3 w-full mt-4 text-sm font-semibold text-center text-white transition duration-100 bg-yellow-600 rounded-lg outline-none hover:bg-yellow-500 focus-visible:ring md:text-base"
                  >
                    {{$t('Proceed to Checkout')}}
                  </Link>
                  <div class="text-center mt-3 cursor-pointer flex justify-center">
                    <div class="flex items-center justify-center gap-2">
                      <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        {{$t('or')}}
                      </span>
                      <Link
                        :href="route('home.index')"
                        title=""
                        class="inline-flex items-center gap-2 text-sm font-medium text-yellow-700 underline hover:no-underline dark:text-yellow-500"
                      >
                        {{$t('Continue Shopping')}}
                        <svg
                          class="w-5 h-5"
                          aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 12H5m14 0-4 4m4-4-4-4"
                          />
                        </svg>
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- totals - end -->
          </form>
        </div>
      </div>
    </HomeLayout>
  </template>
