<script setup>
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permission";
import moment from "moment";
import { defineProps } from "vue";
import { router } from "@inertiajs/vue3";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";

defineProps({
  order: Object,
});
const i = 1;
const formatNumber = (number) => {
  return number.toString().padStart(4, "0");
};
const formaTableDataCellate = (date) => {
  return moment(date).format("DD/MMM/YYYY");
};
</script>

<template>
  <AdminLayout>
    <div class="mx-5 relative">
      <!-- Path Order -->
      <div class="text-md font-sans cursor-pointer flex">
        <div
          class="flex hover:text-yellow-700 dark:hover:text-yellow-500 dark:text-gray-200"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            sTableRowoke-width="1.5"
            sTableRowoke="currentColor"
            class="w-6 h-5 mt-1"
          >
            <path
              sTableRowoke-linecap="round"
              sTableRowoke-linejoin="round"
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
      <!-- End Path -->
      <!-- Main Order Detial -->
      <div class="px-24 bg-white shadow-md rounded-md mt-2">
        <!-- Hearder Logo and Rany-E_Commerce -->
        <div class="flex justify-center">
          <div>
            <div>
              <img
                src="/logo-icon.svg"
                class="w-28 ml-5 -mb-4"
                alt=""
              />
            </div>
            <div>
              <span
                class="text-center font-semibold text-gray-900 dark:text-white"
              >
                <span class="text-yellow-600">{{$t('Rany')}}-</span>{{ $t('E-Commerce') }}</span
              >
            </div>
          </div>
        </div>
        <div class="flex justify-between py-3">
          <div class="text-left">
            <h1 class="font-bold">{{ $t('orderID') }} {{ formatNumber(order.id) }}</h1>
            <h1 class="font-bold">{{ $t('billTo') }}</h1>
            <div>
              <p>+855 8767 2382</p>
              <p class="w-80 pr-1"># {{ $t('locationShop') }}</p>
            </div>
          </div>
          <div class="text-right mt-14">
            <div class="font-bold">
                {{ $t('Customer') }}
              <span class="font-normal capitalize">{{
                order.created_by.name
              }}</span>
            </div>
            <div class="font-bold">
              {{ $t('Phone') }}
              <span class="font-normal capitalize">{{
                order.user_address_id.phone
              }}</span>
            </div>
            <div class="font-bold">
                {{ $t('Date') }}
              <span class="font-normal capitalize">
                {{ formaTableDataCellate(order.updated_at) }}</span
              >
            </div>
          </div>
        </div>

        <!-- End Header -->
        <!-- Table Order Detial -->
        <Table
          v-if="order.order_items.length > 0"
          class="w-full text-sm text-left mb-8 rtl:text-right text-gray-800 dark:text-gray-400"
        >
          <template #header>
            <TableRow> </TableRow>
            <TableRow class="bg-gray-200 rounded-lg">
              <TableHeaderCell>{{ $t('No') }}</TableHeaderCell>
              <TableHeaderCell>{{ $t('Images') }}</TableHeaderCell>
              <TableHeaderCell class="text-center">{{ $t('Product') }}</TableHeaderCell>
              <TableHeaderCell class="text-center">{{$t('Quantity')}}</TableHeaderCell>
              <TableHeaderCell class="text-center">{{$t('unit_Price')}}</TableHeaderCell>
              <TableHeaderCell class="text-center">{{$t('Total')}}</TableHeaderCell>
            </TableRow>
          </template>
          <template #default>
            <TableRow
              v-for="item in order.order_items"
              :key="item.id"
              class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 overflow-auto"
            >
              <TableDataCell>{{ i++ }}</TableDataCell>
              <TableDataCell>
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
              <TableDataCell>{{ item.product.title }}</TableDataCell>
              <TableDataCell>{{ item.quantity }}</TableDataCell>
              <TableDataCell class="text-center"
                >${{ item.product.price }}</TableDataCell
              >
              <TableDataCell class="text-center"
                >${{ item.quantity * item.product.price }}
              </TableDataCell>
            </TableRow>
            <TableRow
              class="odd:bg-white hover:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
            >
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell class="text-right font-bold bg-gray-200">
                <div>{{ $t('SubTotal') }}:</div></TableDataCell
              >
              <TableDataCell class="text-center bg-gray-200">
                <div>${{ order.total_price }}</div>
              </TableDataCell>
            </TableRow>
          </template>
        </Table>
        <div v-else>No order items found.</div>
        <!-- End Table Order Detial -->
        <div class="pb-28">
          <div class="flex justify-between pb-8 border-b-8 ">
            <div class="text-left">
              <h1 class="font-bold">{{ $t('pamentInfor') }}</h1>
              <h1 class="font-bold">
                {{ $t('Type') }} <span class="font-normal">{{ order.payment.type }}</span>
              </h1>
              <h1 class="font-bold">
                {{ $t('Status') }}:
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
              <h1 class="font-bold">
                {{ $t('Address')}}:
                <span class="font-normal">
                  {{ order.user_address_id.address }}</span
                >
              </h1>
            </div>
            <div class="mt-14 mr-20 ">
              <div class="text-center">
                <div class="font-bold">{{ $t('ShopName') }}</div>
                <div class="text-xs">{{ $t('ShopOwner') }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
