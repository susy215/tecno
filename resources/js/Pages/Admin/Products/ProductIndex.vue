<script setup>
import { ref, watch } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm, router } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permission";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PaginationLink from "@/Components/PaginationLink.vue";
import { debounce } from "lodash";
import { Inertia } from "@inertiajs/inertia";

defineProps({
  products: Array,
});

const formatNumber = (number) => {
  return number.toString().padStart(4, "0");
};
const form = useForm({});
const ProductID = ref("");

const showComfirmDeleteProductModel = ref(false);

const { hasPermission } = usePermission();

const ComfimDeleteProduct = (id) => {
  showComfirmDeleteProductModel.value = true;
  ProductID.value = id;
};

const closeModal = () => {
  showComfirmDeleteProductModel.value = false;
};

const deleteProduct = () => {
  form.delete(route("products.destroy", ProductID.value), {
    onSuccess: () => closeModal(),
  });
};

const updateToPublic = (id) => {
  ProductID.value = id;
  router.put(route('products.updateToPublished', ProductID.value), {});
};

const updateToUnpublished = (id) => {
  ProductID.value = id;
  router.put(route('products.updateToUnpublished', ProductID.value), {});
};

const search = ref("");
watch(
  search,
  debounce(
    (q) =>
      router.get("/admin/products", { search: q }, { preserveState: true }),
    500
  )
);
const filters = ref({
  published: "",
});
const filtersStock = ref({
  inStock: "",
});

const applyFilter = () => {
  router.get("/admin/products", filters.value, { preserveState: true });
};
const applyFilterStock = () => {
  router.get("/admin/products", filtersStock.value, { preserveState: true });
};
</script>

<template>
  <Head title="Products" />

  <AdminLayout>
    <div class="px-8 w-full">
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
        <div class="flex">
          <div class="flex">
            <a
              :href="route('products.export')"
              class="middle none center flex items-center justify-center rounded-lg pl-1 md:w-24 h-10 hover:scale-110 hover:skew-y-3 border-2 border-green-600 font-sans text-sm text-green-600 shadow-md transition-all hover:shadow-lg hover:shadow-green-700"
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

              <span class="hidden md:block">{{ $t("Excel") }}</span>
            </a>
          </div>

          <Link
            v-if="hasPermission('Create')"
            :href="route('products.create')"
            class="middle none justify-center items-center flex center ml-2 w-24 h-10 rounded-lg hover:scale-110 hover:skew-y-3 border-2 border-yellow-600 font-sans text-sm text-yellow-600 shadow-md transition-all hover:shadow-lg hover:shadow-yellow-700"
            data-ripple-light="true"
          >
            {{ $t("Create") }}
          </Link>
        </div>
      </div>

      <form class="mx-auto">
        <div class="flex justify-between">
          <div class="relative w-1/3 mb-2 hidden md:block">
            <input
              type="search"
              v-model="search"
              id="search-dropdown"
              class="block w-full rounded-lg h-10 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-2 border border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
              placeholder="Search Shoes, Bags, Electronic,..."
              required
            />
            <button
              type="submit"
              class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-yellow-700 rounded-e-lg border border-yellow-500 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
              <svg
                class="w-4 h-4"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 20"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                />
              </svg>
              <span class="sr-only">Search</span>
            </button>
          </div>
          <div class="grid grid-cols-3 md:grid-cols-5 space-x-2">
            <div class="flex items-center mt-5">
              <label
                for="yellow-checkbox"
                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                >{{ $t("Filter By Pub") }}:</label
              >
            </div>
            <div class="flex items-center mt-5">
              <input
                id="yellow-checkbox"
                type="radio"
                v-model="filters.published"
                value="1"
                @change="applyFilter"
                class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
              <label
                for="yellow-checkbox"
                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                >{{ $t("Published") }}</label
              >
            </div>
            <div class="flex items-center mt-5">
              <input
                type="radio"
                v-model="filters.published"
                value="0"
                @change="applyFilter"
                id="yellow-checkbox"
                class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
              <label
                for="yellow-checkbox"
                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                >{{ $t("Unpublish") }}</label
              >
            </div>
            <div class="flex items-center mt-5">
              <input
                type="radio"
                v-model="filtersStock.inStock"
                value="1"
                @change="applyFilterStock"
                id="yellow-checkbox"
                class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
              <label
                for="yellow-checkbox"
                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                >{{ $t("StockIn") }}</label
              >
            </div>
            <div class="flex items-center mt-5">
              <input
                type="radio"
                v-model="filtersStock.inStock"
                value="0"
                @change="applyFilterStock"
                id="yellow-checkbox"
                class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
              <label
                for="yellow-checkbox"
                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                >{{ $t("StockOut") }}</label
              >
            </div>
          </div>
        </div>
      </form>

      <div>
        <!-- <p>{{ $en.test }}</p> -->
      </div>
      <div
        class="shadow overflow-x-auto rounded-lg border-b dark:border-gray-800 dark:shadow-md dark:shadow-gray-600"
      >
        <Table class="bg-white dark:bg-slate-100">
          <template #header>
            <TableRow>
              <TableHeaderCell>{{ $t("ProID") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Image") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Products") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Cost") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Price") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Quantity") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Status") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Published") }}</TableHeaderCell>
              <TableHeaderCell>{{ $t("Action") }}</TableHeaderCell>
            </TableRow>
          </template>
          <template #default>
            <TableRow
              v-for="Product in products.data"
              :key="Product.id"
              class="border-b"
            >
              <TableDataCell>P-{{ formatNumber(Product.id) }}</TableDataCell>
              <TableDataCell>
                <img
                  v-if="Product.product_images.length > 0"
                  class="w-10 h-10 rounded"
                  :src="`/${Product.product_images[0].image}`"
                  alt=""
                />
                <img
                  v-else
                  class="w-10 h-10 rounded"
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png"
                  alt=""
                />
              </TableDataCell>
              <TableDataCell>{{ Product.title }}</TableDataCell>
              <TableDataCell>Bs.{{ Product.cost }}</TableDataCell>
              <TableDataCell>Bs.{{ Product.price }}</TableDataCell>
              <TableDataCell>{{ Product.qty }}</TableDataCell>
              <TableDataCell>
                <span
                  v-if="Product.qty > 0"
                  class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 -mt-2 -mb-2 rounded-full"
                  >{{ $t("StockIn") }}</span
                >
                <span
                  v-else
                  class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded-full -mt-2 -mb-2"
                  >{{ $t("StockOut") }}</span
                >
              </TableDataCell>

              <TableDataCell>
                <button
                  type="button"
                  v-if="Product.published == 1"
                  @click="updateToUnpublished(Product.id)"
                  class="text-green-600 hover:text-white border border-green-600 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm px-2 py-1 -mt-2 -mb-2 text-center dark:border-green-300 dark:hover:text-white dark:hover:bg-green-500 dark:text-white dark:bg-green-400 dark:focus:ring-green-900"
                >
                  {{ $t("Published") }}
                </button>
                <button
                  type="button"
                  v-else
                  @click="updateToPublic(Product.id)"
                  class="text-yellow-800 hover:text-white border border-yellow-800 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-full text-sm px-2 py-1 -mt-2 -mb-2 text-center dark:border-yellow-300 dark:hover:text-white dark:hover:bg-yellow-500 dark:text-white dark:bg-yellow-400 dark:focus:ring-yellow-900"
                >
                  {{ $t("Unpublish") }}
                </button>
              </TableDataCell>

              <TableDataCell>
                <span class="text-yellow-500 flex">
                  <span class="text-yellow-500 flex justify-end">
                    <Link :href="route('products.show', Product.id)">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="size-5"
                      >
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path
                          fill-rule="evenodd"
                          d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </Link>
                    <span class="mx-1">||</span>

                    <Link
                      v-if="hasPermission('Update')"
                      :href="route('products.edit', Product.id)"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-yellow-600 mx-2 hover:text-hovercolorBG"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"
                        />
                        <path
                          fill-rule="evenodd"
                          d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </Link>
                    <span class="mx-1">||</span>
                    <button
                      v-if="hasPermission('Delete')"
                      @click="ComfimDeleteProduct(Product.id)"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-red-600 hover:text-red-900"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>

                    <Modal
                      :show="showComfirmDeleteProductModel"
                      @click="closeModal"
                    >
                      <div class="relative p-4 text-center rounded-lg">
                        <svg
                          class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto"
                          aria-hidden="true"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                        <p class="mb-4 text-gray-500 dark:text-gray-300">
                          {{ $t("comfimdelete") }}
                        </p>

                        <DangerButton @click="deleteProduct">{{
                          $t("delete")
                        }}</DangerButton>
                        <SecondaryButton @click="closeModal">{{
                          $t("cancel")
                        }}</SecondaryButton>
                      </div>
                    </Modal>
                  </span>
                </span>
              </TableDataCell>
            </TableRow>
          </template>
        </Table>

        <div class="pr-4">
          <!-- pagination -->
          <PaginationLink :paginator="products" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
