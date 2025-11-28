<script setup>
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permission";
// import { usePage } from '@inertiajs/inertia-vue3';
import { router } from "@inertiajs/vue3";

import moment from "moment";

defineProps({
  products: Array,
});

const i = 1;

const formatDate = (date) => {
  return moment(date).format("DD/MMM/YYYY");
};
const formatNumber = (number) => {
  return number.toString().padStart(4, "0");
};

const form = useForm({});
const OrderId = ref("");

const { hasPermission } = usePermission();
</script>

<template>
  <AdminLayout>
    <div class="px-4 dark:bg-slate-900">
      <div class="flex justify-between pb-4">
        <!-- Path for Back -->
        <div class="text-md font-sans cursor-pointer flex">
          <div
            class="flex hover:text-yellow-700 dark:hover:text-yellow-500 dark:text-gray-200"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-5 mt-1"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
              />
            </svg>

            <span class="m-1">
              <a :href="route('admin.index')" :active="false">
                <span class="font-sans">{{ $t("dashbourd") }}</span>
              </a>
            </span>
          </div>

          <div
            class="flex hover:text-yellow-700 dark:hover:text-yellow-500 dark:text-gray-200"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-5 h-5 mt-1"
            >
              <path
                fill-rule="evenodd"
                d="M13.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L11.69 12 4.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                clip-rule="evenodd"
              />
              <path
                fill-rule="evenodd"
                d="M19.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06L17.69 12l-6.97-6.97a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                clip-rule="evenodd"
              />
            </svg>
            <span class="m-1">
              <Link :href="route('products.index')" :active="false">
                <span class="font-sans">{{ $t("Product") }}</span>
              </Link>
            </span>
          </div>
        </div>
      </div>

      <div class="shadow-md bg-gray-200 rounded-md p-5">
        <h1 class="text-2xl mb-4">{{ $t("Product") }}/ {{ $t("Detail") }}</h1>
        <div class="flex justify-center space-x-5">
          <div class="w-96flex justify-center">
            <div class="block">
              <div>
                <img
                  v-if="products.product_images.length > 0"
                  class="w-56 h-56 rounded-xl"
                  :src="products.product_images[0].src || `/${products.product_images[0].image}`"
                  alt=""
                />
                <img
                  v-else
                  class="w-56 h-56 rounded-xl"
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png"
                  alt=""
                />
              </div>
              <div class="mt-2 flex flex-wrap">
                <!-- Loop through the product_images array -->
                <img
                  v-for="(image, index) in products.product_images"
                  :key="index"
                  class="w-24 h-24 rounded-xl m-1"
                  :src="image.src || `/${image.image}`"
                  alt=""
                />
                <!-- Placeholder image for the case when there are no images -->
                <img
                  v-if="products.product_images.length === 0"
                  class="w-56 h-56 rounded-xl"
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png"
                  alt=""
                />
              </div>
            </div>
          </div>

          <div class="w-96">
            <span class="text-xl">{{ $t('Product Information') }}</span>
            <div class="flex mb-2">
              <p class="text-sm">{{ products.category.category }}</p>
            </div>
            <div class="flex mb-2">
              <p class="text-3xl">{{ products.title }}</p>
            </div>
            <div class="flex mb-2">
              <p class="text-sm">{{ products.description }}</p>
            </div>
            <div class="flex mb-2">
              <p class="text-lg">{{ products.qty }}</p>
              <p
                class="text-lg ml-2 text-green-600"
                v-if="products.inStock == 0"
              >
                {{ $t("StockIn") }}
              </p>
              <p class="text-lg ml-2 text-red-600" v-else>
                {{ $t("Stock Out") }}
              </p>
            </div>

            <div class="border-t-2 border-white mt-5 pt-2">
              <div
                class=" rounded-md p-2 flex justify-start space-x-5"
              >
                <div>
                  <div class="flex mb-2">
                    <h1 class="font-bold text-lg mr-2">{{ $t("Cost") }} :</h1>
                    <p class="text-lg">Bs.{{ products.cost }}</p>
                  </div>
                  <div class="flex mb-2">
                    <h1 class="font-bold text-lg mr-2">
                      {{ $t("Discount") }} :
                    </h1>
                    <p class="text-lg">{{ products.discount }}%</p>
                  </div>
                  <div class="flex mb-2">
                    <h1 class="font-bold text-lg mr-2">{{ $t("Total") }} :</h1>
                    <p class="text-lg">Bs.{{ products.total_cost }}</p>
                  </div>
                </div>
                <div>
                  <div class="flex mb-2">
                    <h1 class="font-bold text-lg mr-2">
                      {{ $t("Sellings") }} :
                    </h1>
                    <p class="text-lg">Bs.{{ products.sellingprice }}</p>
                  </div>
                  <div class="flex mb-2">
                    <h1 class="font-bold text-lg mr-2">
                      {{ $t("Selling") }} :
                    </h1>
                    <p class="text-lg">Bs.{{ products.price }}</p>
                  </div>
                  <div class="flex mb-2">
                    <h1 class="font-bold text-lg mr-2">
                      {{ $t("Total Price") }} :
                    </h1>
                    <p class="text-lg">Bs.{{ products.total_price }}</p>
                  </div>
                </div>
              </div>

            </div>
            <div class="border-t-2 border-white pt-2">
              <div
                class=" rounded-md p-2 flex justify-start space-x-5"
              >
                <div>
                  <div class="flex mb-2">
                    <h1 class="font-bold text-lg mr-2">{{ $t("Supplier") }} :</h1>
                    <p class="text-lg">{{ products.supplier.name }}</p>
                  </div>
                </div>
                <div>
                  <div class="flex mb-2">
                    <h1 class="font-bold text-lg mr-2">
                      {{ $t("Phone Number") }} :
                    </h1>
                    <p class="text-lg">{{ products.supplier.number }}</p>
                  </div>
                </div>
              </div>
              <div class="flex ml-2 mb-2">
                    <h1 class="font-bold text-lg mr-2">
                      {{ $t("Email") }} :
                    </h1>
                    <p class="text-lg">{{ products.supplier.email }}</p>
                  </div>
                  <div class="flex ml-2">
                    <h1 class="font-bold text-lg mr-2">
                      {{ $t("Address") }} :
                    </h1>
                    <p class="text-lg">{{ products.supplier.address }}</p>
                  </div>
              <!-- <div class="flex mb-2 mt-3">
                <h1 class="font-bold text-lg mr-2">{{ $t("Status") }} :</h1>
                <p class="text-lg" v-if="products.published == 0">
                  {{ $t("Unpublish") }}
                </p>
                <p class="text-lg text-green-500" v-else>
                  {{ $t("Published") }}
                </p>
              </div> -->
            </div>
          </div>
        </div>
        <div class="flex justify-center">
          <div class="flex justify-between">
            <div></div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
