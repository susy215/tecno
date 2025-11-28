<script setup>
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permission";
import moment from "moment";
// import { defineProps } from "vue";
import { defineProps } from "vue";
import { router } from "@inertiajs/vue3";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";

const props = defineProps({
  order: {
    type: Object,
    required: true,
  },
});
const i = 1;
const formatNumber = (number) => {
  return number.toString().padStart(4, "0");
};
const formaTableDataCellate = (date) => {
  return moment(date).format("DD/MMM/YYYY");
};

const printPage = () => {
  window.print();
};
</script>

<template>
  <AdminLayout>
    <div class="mx-5 relative">
      <!-- Path Order -->
      <div class="flex justify-between mr-10">
        <div class="text-md font-sans cursor-pointer block navbar md:flex">
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
              <Link :href="route('orders.index')" :active="false">
                <span class="font-sans">{{ $t("Order") }}</span>
              </Link>
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
              <span class="font-sans">{{ $t("Detail") }}</span>
            </span>
          </div>
        </div>
        <button
          type="button"
          @click="printPage"
          class="flex -mr-10 h-11 print-button btn focus:outline-none text-white bg-yellow-600 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
            />
          </svg>
          <span class="mt-0.5 ml-1">{{ $t("Print") }}</span>
        </button>
      </div>
      <!-- End Path -->
      <!-- Main Order Detial -->
      <div class="content md:px-24 text-lg bg-white rounded-md mt-2">
        <!-- Hearder Logo and Rany-E_Commerce -->
        <div class="flex text-center justify-center mb-10">
          <div>
            <div class="">
              <div class="flex items-center justify-center w-28 h-28 -mb-4 ml-14 bg-yellow-500 rounded-lg shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-20 h-20 text-white">
                  <rect x="20" y="30" width="60" height="50" rx="4" fill="currentColor"/>
                  <path d="M 30 30 L 30 25 Q 30 20 35 20 L 65 20 Q 70 20 70 25 L 70 30" stroke="currentColor" stroke-width="3" fill="none"/>
                  <circle cx="40" cy="50" r="3" fill="white"/>
                  <circle cx="60" cy="50" r="3" fill="white"/>
                </svg>
              </div>
            </div>
            <div>
              <div class="text-gray-900 dark:text-white font-khmer">
                <span class="text-yellow-600">{{ $t("Rany") }}-</span
                >{{ $t("E-Commerce") }}
              </div>
            </div>
          </div>
        </div>
        <div class="flex justify-between py-3">
          <div class="text-left">
            <h1 class="font-bold">
              {{ $t("orderID") }} {{ formatNumber(order.id) }}
            </h1>
            <h1 class="font-bold">{{ $t("billTo") }}</h1>
            <div>
              <p>+591 {{ order.user_address.phone }}</p>
              <h1 class="font-bold">
                {{ $t("Address") }}:
                <span class="font-normal">
                  {{ order.user_address.address }}</span
                >
              </h1>
              <!-- <p class="w-80 pr-1"># {{ $t('locationShop') }}</p> -->
            </div>
          </div>
          <div class="text-right mt-14">
            <div class="font-bold">
              {{ $t("Customer") }}
              <span class="font-normal capitalize">{{
                order.created_by.name
              }}</span>
            </div>

            <div class="font-bold">
              {{ $t("Date") }}
              <span class="font-normal capitalize">
                {{ formaTableDataCellate(order.updated_date) }}</span
              >
            </div>
          </div>
        </div>

        <!-- End Header -->
        <!-- Table Order Detial -->
        <Table
          v-if="order.order_items.length > 0"
          class="w-full text-lg text-left overflow-auto mb-8 rtl:text-right text-gray-800 dark:text-gray-400"
        >
          <template #header>
            <TableRow class="bg-gray-600 rounded-lg border-1 border-gray-500">
              <TableHeaderCell class="border-1 border-gray-500">{{
                $t("No")
              }}</TableHeaderCell>
              <TableHeaderCell class="border-1 border-gray-500">{{
                $t("Images")
              }}</TableHeaderCell>
              <TableHeaderCell class="text-center border-1 border-gray-500">{{
                $t("Product")
              }}</TableHeaderCell>
              <TableHeaderCell class="text-center border-1 border-gray-500">{{
                $t("Quantity")
              }}</TableHeaderCell>
              <TableHeaderCell class="text-center border-1 border-gray-500">{{
                $t("unit_Price")
              }}</TableHeaderCell>
              <TableHeaderCell class="text-center border-1 w-32 border-gray-500">{{
                $t("Total")
              }}</TableHeaderCell>
            </TableRow>
          </template>
          <template #default>
            <TableRow
              v-for="item in order.order_items"
              :key="item.id"
              class="odd:bg-white odd:dark:bg-gray-900 border-1 border-gray-500 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 overflow-auto"
            >
              <TableDataCell class="border-1 text-center border-gray-500">{{
                i++
              }}</TableDataCell>
              <TableDataCell class="border-1 text-center border-gray-500">
                <img
                  v-if="item.product.product_images.length > 0"
                  class="w-10 h-10 rounded"
                  :src="`/${item.product.product_images[0].image}`"
                  alt=""
                />
                <img
                  v-else
                  class="w-10 h-10 rounded"
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png"
                  alt=""
                />
              </TableDataCell>
              <TableDataCell class="border-1 border-gray-500">{{
                item.product.title
              }}</TableDataCell>
              <TableDataCell class="border-1 text-center border-gray-500">{{
                item.quantity
              }}</TableDataCell>
              <TableDataCell class="text-center border-1 border-gray-500"
                >Bs.{{ item.product.price }}</TableDataCell
              >
              <TableDataCell class="text-center border-1 border-gray-500"
                >Bs.{{ item.quantity * item.product.price }}
              </TableDataCell>
            </TableRow>
            <TableRow
              class="odd:bg-white hover:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
            >
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell class="text-right w-48 font-bold bg-gray-200">
                <div>{{ $t("SubTotal") }}:</div></TableDataCell
              >
              <TableDataCell class="text-center bg-gray-200">
                <div>Bs.{{ order.total_price }}</div>
              </TableDataCell>
            </TableRow>
          </template>
        </Table>
        <div v-else>No order items found.</div>
        <!-- End Table Order Detial -->
        <div class="pb-28">
          <div class="flex justify-between pb-8 border-b-8">
            <div class="text-left">
              <h1 class="font-bold">{{ $t("pamentInfor") }}</h1>
              <h1 class="font-bold">
                {{ $t("Type") }}
                <span class="font-normal">{{ order.payment.type }}</span>
              </h1>
              <h1 class="font-bold">
                {{ $t("Status") }}:
                <span class="font-normal">
                  <span
                    v-if="order.payment.status == 0"
                    class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded-full -mt-2 -mb-2"
                    >{{ $t("Unpaid") }}</span
                  >
                  <span
                    v-else
                    class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 -mt-2 -mb-2 rounded-full"
                    >{{ $t("Paid") }}</span
                  ></span
                >
              </h1>
            </div>
            <div class="mt-14 mr-20">
              <div class="text-center">
                <div class="font-bold">{{ $t("ShopName") }}</div>
                <div class="text-xs">{{ $t("ShopOwner") }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
