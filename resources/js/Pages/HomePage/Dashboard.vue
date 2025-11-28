<script setup>
import { ref, watch } from "vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
import moment from 'moment';
import { router } from "@inertiajs/vue3";
defineProps({
  orders: Array,
});

const i = 1;
const applyFilter = () => {
  router.get("/history", filters.value, { preserveState: true });
};
const filters = ref({
  status: 'All',

});
const formatDate = (date) => {
  return moment(date).format('DD/MMM/YYYY');
};

</script>
<template>
  <HomeLayout>

<div class=" px-24 relative">
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
              <a :href="route('home.index')" :active="false">
                <span class="font-sans">{{ $t("Home") }}</span>
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
              class="w-5 h-4 mt-2"
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
              <a>
                <span class="font-sans">{{ $t("History") }}</span>
              </a>
            </span>
          </div>
        </div>
        <div class="grid grid-cols-4 w-96 mb-3">
    <div class="flex mt-5">
      <label for="all-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        {{ $t("Filter") }}:
      </label>
    </div>
    <div class="flex items-center mt-5">
      <input
        id="all-checkbox"
        type="radio"
        v-model="filters.status"
        value='All'
        @change="applyFilter"
        class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
      />
      <label for="all-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        {{ $t("All") }}
      </label>
    </div>
    <div class="flex items-center mt-5">
      <input
        id="published-checkbox"
        type="radio"
        v-model="filters.status"
        value="1"
        @change="applyFilter"
        class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
      />
      <label for="published-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        {{ $t("Complete") }}
      </label>
    </div>
    <div class="flex items-center mt-5">
      <input
        id="unpublished-checkbox"
        type="radio"
        v-model="filters.status"
        value="0"
        @change="applyFilter"
        class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
      />
      <label for="unpublished-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        {{ $t("Orders") }}
      </label>
    </div>
  </div>
  <div class="bg-gray-200 p-10 rounded-md shadow-md">
    <div v-for="(order, i) in orders" :key="order.id" class="mb-8">
        <div>{{$t('ORDER ID')}} # {{ i + 1 }}</div>
        <table v-show="order.order_items.length > 0" class="w-full text-sm text-left rtl:text-right text-gray-800">
            <thead>
                <tr class="bg-gray-300 rounded-lg shadow-2xl border-2">
                    <th scope="col" class="px-6 py-3">{{$t('Images')}}</th>
                    <th scope="col" class="px-6 py-3">{{$t('Products')}}</th>
                    <th scope="col" class="px-6 py-3">{{$t('Quantity')}}</th>
                    <th scope="col" class="px-6 py-3 text-right">{{$t('Prices')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in order.order_items" :key="item.id" class="odd:bg-white even:bg-gray-50 border-b">
                    <td class="px-6 py-4">
                        <img v-if="item.product.product_images.length > 0" class="w-10 h-10 rounded" :src="item.product.product_images[0].src || `/${item.product.product_images[0].image}`" alt="" @error="$event.target.src='https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png'" />
                        <img v-else class="w-10 h-10 rounded" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png" alt="" />
                    </td>
                    <td class="px-6 py-4">{{ item.product.title }}</td>
                    <td class="px-6 py-4">{{ item.quantity }}</td>
                    <td class="px-6 py-4 text-right">${{ item.product.price }}</td>
                </tr>
                <tr class="odd:bg-white even:bg-gray-50 border-b">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <div class="mb-2">{{$t('Date')}}: {{ formatDate(order.updated_at) }}</div>
                        <div class="mb-2">
                            {{$t('Status')}}:
                            <span v-if="order.status == 0" class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded-full">{{$t('Please Wait...!')}}</span>
                            <span v-else class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-full">{{ $t('Order completed') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"></td>
                    <td class="px-6 py-4"></td>
                    <td class="px-6 py-4 text-right">
                        <div>{{$t('Total Price')}}: Bs.{{ order.total_price }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <span v-show="order.order_items.length === 0">No History!</span>
    </div>
</div>

</div>

  </HomeLayout>
</template>
