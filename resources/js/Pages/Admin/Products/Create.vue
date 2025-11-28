<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

import { Plus } from "@element-plus/icons-vue";
import { router } from "@inertiajs/vue3";

// const categories = usePage().props.categories;
// defineProps(["categories"]);
defineProps({
  categories: Array,
  suppliers: Array,
});
const form = useForm({
  description: "",
  title: "",
  price: "",
  cost: "",
  qty: "",
  category_id: "",
  supplier_id: "",
  discount: "",
  sellingprice: "",
  product_images: [],
  total_cost: "",
  total_price: "",
});

const Cdiscount = () => {
  form.price = form.sellingprice - form.sellingprice * (form.discount / 100);
  form.total_price = form.price * form.qty;
};
const CtotalCost = () => {
  form.total_cost = form.cost * form.qty;
};
// const product_images = ref([])
const productImages = ref([]);
const dialogImageUrl = ref("");
const dialogVisible = ref(false);

const handleFileChange = (file) => {
  productImages.value.push(file);
};

const handleRemove = (file) => {
  console.log(file);
};

const handlePictureCardPreview = (file) => {
  dialogImageUrl.value = file.url;
  dialogVisible.value = true;
};
const Addimage = async () => {
  // Validar campos requeridos
  if (
    !form.title ||
    !form.price ||
    !form.cost ||
    !form.category_id
  ) {
    alert("Please Input Value");
    return;
  }

  // Append product images to the form
  if (productImages.value.length > 0) {
    form.product_images = [];
    for (const image of productImages.value) {
      if (image.raw) {
        form.product_images.push(image.raw);
      }
    }
  }

  try {
    form.post(route('products.store'), {
      onSuccess: (page) => {
        Swal.fire({
          toast: true,
          icon: "success",
          position: "top-end",
          showConfirmButton: false,
          title: page.props.flash.success,
        });
        if (dialogVisible.value !== undefined) {
          dialogVisible.value = false;
        }
        form.reset();
        productImages.value = [];
      },
    });
  } catch (err) {
    console.log(err);
  }
};
</script>

<template>
  <Head title="Create New Items" />

  <AdminLayout>
    <div class="px-8 w-full">
      <div class="">
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
              <span class="font-sans">{{ $t("Create") }}</span>
            </span>
          </div>
        </div>
      </div>
      <div class="mt-6 bg-slate-200 p-6 rounded-lg">
        <h1 class="pl-4 pb-6 text-xl">
          {{ $t("Create") }} / {{ $t("Product") }}
        </h1>
        <form @submit.prevent="Addimage">
          <div class="justify-between md:flex mx:flex ms:block">
            <div class="md:w-1/2 md:mr-3 ms:w-full">
              <div>
                <span>{{ $t("Product") }}</span>

                <TextInput
                  id="title"
                  type="text"
                  class="mt-1 mb-2 block w-full"
                  v-model="form.title"
                  required
                  autofocus
                />

                <InputError class="mt-2" :message="form.errors.title" />
              </div>

              <div class="md:flex justify-between ms:block md:w-full mx:w-full">
                <div class="md:mr-2 w-1/2">
                  <span>{{ $t("Category") }}</span>
                  <select
                    id="category_id"
                    v-model="form.category_id"
                    class="bg-gray-50 border my-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  >
                    <option disabled value="">{{ $t("Select") }}</option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.category }}
                    </option>
                  </select>
                </div>
                <div class="w-1/2">
                  <span>{{ $t("Supplier") }}</span>
                  <select
                    id="supplier_id"
                    v-model="form.supplier_id"
                    class="bg-gray-50 border my-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  >
                    <option disabled value="">{{ $t("Select") }}</option>
                    <option
                      v-for="supplier in suppliers"
                      :key="supplier.id"
                      :value="supplier.id"
                    >
                      {{ supplier.name }}
                    </option>
                  </select>
                </div>
              </div>
              <div>
                <span>{{ $t("Image") }}</span>
                <el-upload
                  v-model:file-list="productImages"
                  list-type="picture-card"
                  multiple
                  :on-preview="handlePictureCardPreview"
                  :on-change="handleFileChange"
                  :on-remove="handleRemove"
                >
                  <el-icon><Plus /></el-icon>
                </el-upload>
                <InputError class="mt-2" :message="form.errors.name" />
              </div>

            </div>
            <div class="md:w-1/2 md:ml-3 ms:w-full">
              <div class="md:flex justify-between ms:block md:w-full mx:w-full">


                    <div class="w-1/2 mr-2">
                      <span>{{ $t("Cost") }}</span>
                      <TextInput
                        @mouseout="CtotalCost"
                        id="cost"
                        name="cost"
                        type="text"
                        class="mt-1 mb-2 block w-full"
                        v-model="form.cost"
                        autocomplete="cost"
                      />
                    </div>

                    <div class="w-1/2">
                      <span>{{ $t("Selling") }}</span>
                      <TextInput
                        @mouseout="Cdiscount"
                        id="sellingprice"
                        type="text"
                        class="mt-1 w-full mb-2 block"
                        v-model="form.sellingprice"
                        autocomplete="sellingprice"
                      />
                      <InputError class="mt-2" :message="form.errors.cost" />
                    </div>

              </div>
              <div class="md:flex justify-between ms:block md:w-full mx:w-full">
                <div class="flex w-1/2">
                  <div class="md:mr-2">
                    <span>{{ $t("Discount") }}</span>
                    <TextInput
                      @mouseout="Cdiscount"
                      id="discount"
                      type="text"
                      class="mt-1 mb-2 block w-full"
                      v-model="form.discount"
                      autocomplete="discount"
                    />
                  </div>
                  <div>
                    <span>{{ $t("Quantity") }}</span>
                    <TextInput
                      id="qty"
                      @mouseout="CtotalCost"
                      type="number"
                      class="mt-1 mb-2 block w-full"
                      v-model="form.qty"
                      required
                      autocomplete="qty"
                    />
                    <InputError class="mt-2" :message="form.errors.qty" />
                  </div>
                </div>

                <div class="w-1/2 ml-2">
                  <span>{{ $t("Price") }}</span>
                  <TextInput
                    id="price"
                    type="text"
                    class="mt-1 mb-2 block w-full"
                    v-model="form.price"
                    autocomplete="price"
                    disabled
                  />
                  <InputError class="mt-2" :message="form.errors.cost" />
                </div>
              </div>
              <div>
                <span>{{ $t("Description") }}</span>

                <TextArea
                  v-model="form.description"
                  id="description"
                  type="text"
                  class="mt-1 mb-2 h-24 block w-full"
                />

                <InputError class="mt-2" :message="form.errors.description" />
              </div>
              <div class=" border-t-2 border-white mt-5 pt-5">
                <div>
                  <div class="flex space-x-5">
                    <div>
                      Total Cost:
                      <TextInput
                        class="w-24 bg-gray-200"
                        id="total_cost"
                        v-model="form.total_cost"
                        disabled
                      />
                      $
                    </div>
                    <div>
                      Total Price:
                      <TextInput
                        id="total_price"
                        class="w-24 bg-gray-200"
                        v-model="form.total_price"
                        disabled
                      />
                      $
                    </div>
                  </div>

                </div>

              </div>

            </div>

          </div>
          <div class="flex items-center -mt-5">
                <PrimaryButton @click="UpdateProduct">
                  {{ $t("Save") }}
                </PrimaryButton>
              </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
