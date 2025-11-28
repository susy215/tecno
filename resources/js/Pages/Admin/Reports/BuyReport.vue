<script setup>
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permission";
import { router } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import moment from "moment";

const props = defineProps({
  products: Array,
  filters: Object,
  totalPrice: Object,
  totalCost: Object,
});
const printPage = () => {
  window.print();
};

// Setup reactive form fields for dates
const start_date = ref(props.filters.start_date || "");
const end_date = ref(props.filters.end_date || "");

// Function to filter records
const filterRecords = () => {
  router.get(route("BuyReport.BuyReport"), {
    start_date: start_date.value,
    end_date: end_date.value,
  });
};
const ClearFilter = () => {
  router.get(route("BuyReport.BuyReport"), {});
};

const formatDate = (date) => moment(date).format("DD/MMM/YYYY");
const formatNumber = (number) => number.toString().padStart(4, "0");

const { hasPermission } = usePermission();

// Function to export products
const exportProducts = () => {
  window.location.href = `/reports/prdocts/download?start_date=${start_date.value}&end_date=${end_date.value}`;
};

// Function to toggle image scaling
const toggleImageScale = (product) => {
  product.isScaled = !product.isScaled;
};

// Calculate profit for each product
const productsWithProfit = props.products.map((product) => {
  const price = parseFloat(product.total_price) || 0;
  const cost = parseFloat(product.total_cost) || 0;
  const profit = price - cost;
  return {
    ...product,
    profit,
  };
});
</script>


<template>
  <Head title="Report" />

  <AdminLayout>
    <div class="px-8 w-full">
      <div class="md:flex block justify-between pb-4">
        <!-- Path for Back -->
        <div class="md:flex block font-sans cursor-pointer navbar">
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
              <Link :href="route('reports.index')" :active="false">
                <span class="font-sans">{{ $t("Reports") }}</span>
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
              <Link>
                <span class="font-sans">{{ $t("Buy Reports") }}</span>
              </Link>
            </span>
          </div>
        </div>
        <div class="flex space-x-3">
          <div class=" ">
            <button
              @click="exportProducts"
              class="middle navbar none center flex items-center justify-center rounded-lg w-24 h-11 hover:scale-110 hover:skew-y-3 border-2 border-green-600 font-sans text-green-600 shadow-md transition-all hover:shadow-lg hover:shadow-green-700"
              data-ripple-light="true"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="size-4 mr-1"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z"
                  clip-rule="evenodd"
                />
                <path
                  d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"
                />
              </svg>

              {{ $t("Excel") }}
            </button>
          </div>

          <div class="relative">
            <button
              @click="printPage"
              class="flex print-button btn middle none center rounded-lg hover:scale-110 hover:skew-y-3 border-2 border-yellow-600 py-2.5 px-4 font-sans text-sm text-yellow-600 shadow-md transition-all hover:shadow-lg hover:shadow-yellow-700"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-5"
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
        </div>
      </div>

      <div
        class="py-2 navbar px-6 bg-white dark:bg-gray-800 rounded-md shadow-lg"
      >
        <form @submit.prevent="filterRecords" class="flex space-x-2">
          <div class="flex flex-col space-y-1">
            <label
              class="font-sans text-sm dark:text-gray-300"
              for="start_date"
              >{{ $t("Start Date") }}</label
            >
            <input
              type="date"
              class="dark:bg-gray-500 h-11 text-gray-700 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-200 bg-transparent font-sans text-sm outline-none border border-gray-500 rounded-[7px] transition-all focus:border-yellow-500 focus:outline-none"
              v-model="start_date"
              name="start_date"
              id="start_date"
              required
            />
          </div>

          <div class="flex flex-col space-y-1">
            <label
              class="font-sans text-sm dark:text-gray-300"
              for="end_date"
              >{{ $t("End Date") }}</label
            >
            <input
              type="date"
              class="dark:bg-gray-500 h-11 text-gray-700 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-200 bg-transparent px-3 py-2.5 font-sans text-sm outline-none border border-gray-500 rounded-[7px] transition-all focus:border-yellow-500 focus:outline-none"
              v-model="end_date"
              name="end_date"
              id="end_date"
              required
            />
          </div>

          <div class="flex items-end">
            <div>
              <button type="submit" @dblclick="ClearFilter()" class="mt-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="size-6 text-yellow-600"
                >
                  <path
                    fill-rule="evenodd"
                    d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </div>
          </div>
        </form>
      </div>

      <div
        class="contentBuyReport overflow-auto text-sm bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6"
      >
        <div class="Titel hidden">
          <h1
            class="text-center font-khmer text-yellow-700 underline -mb-2 mt-2 text-lg"
          >
            {{ $t("Rany Online Shop") }}
          </h1>
          <h1
            class="text-center font-khmer text-yellow-700 underline py-5 text-md"
          >
            {{ $t("Buy Reports") }}
          </h1>
        </div>
        <Table class="bg-white dark:bg-slate-100">
          <template #header>
            <TableRow>
              <TableHeaderCell>{{ $t("ID") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Image") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Date") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Product") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Quantity") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Unit Cost") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Unit Selling") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Total Cost") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Total Selling") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Profit") }}</TableHeaderCell>
            </TableRow>
          </template>
          <template #default>
            <TableRow
              v-for="product in productsWithProfit"
              :key="product.id"
              :class="{
                'dark:bg-gray-700': product.isScaled,
                'bg-gray-200': product.isScaled,
              }"
              @click="toggleImageScale(product)"
            >
              <TableDataCell>P-{{ formatNumber(product.id) }}</TableDataCell>
              <TableDataCell>
                <img
                  v-if="product.product_images.length > 0"
                  class="w-10 h-10 rounded"
                  :src="product.product_images[0].src || `/${product.product_images[0].image}`"
                  alt="" />
                <img
                  v-else
                  class="w-10 h-10 rounded"
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png"
                  alt=""
              /></TableDataCell>
              <TableDataCell>{{
                formatDate(product.created_date)
              }}</TableDataCell>
              <TableDataCell>{{ product.title }}</TableDataCell>
              <TableDataCell>{{ product.qty }}</TableDataCell>
              <TableDataCell>Bs. {{ product.cost }}</TableDataCell>
              <TableDataCell>Bs. {{ product.price }}</TableDataCell>
              <TableDataCell>Bs. {{ product.total_cost }}</TableDataCell>
              <TableDataCell>Bs. {{ product.total_price }}</TableDataCell>
              <TableDataCell>Bs. {{ product.profit.toFixed(2) }}</TableDataCell>
            </TableRow>
            <TableRow class="bg-gray-200">
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell></TableDataCell>
              <TableDataCell>{{ $t("Total") }}</TableDataCell>
              <TableDataCell>Bs. {{ totalCost }}</TableDataCell>
              <TableDataCell>Bs. {{ totalPrice }}</TableDataCell>
              <TableDataCell>Bs. {{ totalPrice - totalCost }}</TableDataCell>
            </TableRow>
          </template>
        </Table>
      </div>
    </div>
  </AdminLayout>
</template>
