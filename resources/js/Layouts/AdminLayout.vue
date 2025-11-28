<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permission";
import { loadLanguageAsync } from "laravel-vue-i18n";
import { useDark, useToggle } from "@vueuse/core";
import moment from "moment";
import { initFlowbite } from "flowbite";
const { hasRole, hasRoles } = usePermission();
import SidebarLink from "@/Components/SidebarLink.vue";

// Get the page props
const { props } = usePage();
const auth = props.auth;

// Computed property for user roles
const userRoles = computed(() => {
  return auth.user.roles.join(", "); // Join the array into a string
});

// Function to format date
const formatDate = (date) => {
  return moment(date).format("DD/MMM/YYYY");
};


// Dark mode toggle
const isDark = useDark();
const toggleDark = useToggle(isDark);

// Get notifications from page props
const notification = props.notifications;
const contnitification = props.contnitification;

// Initialize Flowbite on component mount
onMounted(() => {
  initFlowbite();
  notificationShowDelete.value = true;
  notificationShow.value = true;
  setTimeout(() =>(notificationShow.value = false),2000);
  setTimeout(() =>(notificationShowDelete.value = false),2000);
});

// Determine profile URL
const profileUrl = auth.user?.profile?.profile
  ? `/storage/${auth.user.profile.profile}`
  : "";

// Reactive items for language selection
const items = reactive({
  item: [
    { title: "English", value: "en" },
    { title: "Español", value: "es" },
    { title: "ខ្មែរ", value: "kh" },
  ],
});

// Function to change locale
const changeLocale = (item) => {
  router.get(route("language", item.value));
  localStorage.setItem("lang", item.value);
  loadLanguageAsync(item.value);
};

const notificationShow = ref(false);
const notificationShowDelete = ref(false);

// Ref for showing navigation dropdown
const showingNavigationDropdown = ref(false);
</script>

<style>
@media print {
  .navbar, .sidebar {
    display: none !important;
  }
}
</style>

<template>
  <div class="antialiased bg-gray-50 dark:bg-gray-900 font-sans">
    <nav
      class=" navbar btn-primary bg-white border-b border-gray-200 px-2 py-2 dark:bg-gray-800 dark:shadow-md dark:shadow-gray-700 dark:border-gray-700 fixed left-0 md:left-72 right-0 md:right-8 top-0 z-50 shadow-md rounded-md"
    >
      <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
          <button
            data-drawer-target="drawer-navigation"
            data-drawer-toggle="drawer-navigation"
            aria-controls="drawer-navigation"
            class="p-2 text-yellow-700 dark:text-yellow-500 dark:hover:bg-gray-700 rounded-lg hover:text-green-950 cursor-pointer md:hidden hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:hover:text-white"
          >
            <svg
              aria-hidden="true"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <svg
              aria-hidden="true"
              class="hidden w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="sr-only">Toggle sidebar</span>
          </button>
          <a
            :href="route('home.index')"
            :active="false"
            class="flex items-center justify-between mr-2 text-yellow-700 dark:text-yellow-400 dark:hover:bg-gray-700 rounded-lg hover:text-yellow-900 hover:bg-gray-200 p-2"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"
              />
            </svg>
          </a>
          <span class=" hidden md:block text-yellow-700 dark:text-yellow-500"
            >{{ $t("Hello") }}! : {{ $page.props.auth.user.name }}</span
          >
          <div v-if="(notificationShow && $page.props.flash.success) || (notificationShowDelete && $page.props.flash.dsuccess)">
            <div
             class="absolute mt-10 ml-16 flex items-center p-3 mb-4 text-sm text-green-800 rounded-lg bg-green-50 shadow-md dark:bg-gray-800 dark:text-blue-400"
                role="alert"
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
                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
              />
            </svg>
            <span> {{ $page.props.flash.success }}</span>
            </div>
          </div>
          <div >
            <div
            v-if="$page.props.flash.dsuccess"
              class="absolute mt-10 ml-16 flex items-center p-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 shadow-md dark:bg-gray-800 dark:text-red-400"
              role="alert"
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
                  d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
              </svg>
              <span> {{ $page.props.flash.dsuccess }}</span>
            </div>
          </div>
        </div>
        <div class="flex items-center lg:order-2">
          <!-- Notifications -->
          <button
            type="button"
            data-dropdown-toggle="notification-dropdown"
            class="p-2 rounded-lg text-yellow-700 dark:hover:bg-gray-700 hover:text-yellow-900 dark:text-yellow-400 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 hover:bg-gray-200"
          >
            <span
              v-if="contnitification != 0"
              class="-mt-2 md:-mt-4 absolute -mr-6 px-1 text-xs font-bold text-white bg-red-500 border-2 border-red-500 rounded-full lg:top-6 lg:end-40 dark:border-gray-900 2xl:end-auto"
            >
              {{ contnitification }}
            </span>
            <span v-else class="-mt-5 absolute -mr-6"> </span>
            <span class="sr-only">View notifications</span>
            <!-- Bell icon -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
              />
            </svg>
          </button>
          <!-- Dropdown menu -->
          <div
            class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white divide-y divide-gray-100 shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl"
            id="notification-dropdown"
          >
            <div
              class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300"
            >
              Notifications
            </div>
            <div v-for="notifications in notification" :key="notifications.id">
              <Link
                :href="route('orders.index')"
                class="flex py-3 px-4 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600"
              >
                <div class="flex-shrink-0">
                  <div
                    class="h-11 w-11 mt-4 rounded-full border-2 border-yellow-200 text-amber-500 justify-center items-center flex"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="size-5"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </div>
                </div>
                <div class="pl-3 w-56 ml-6">
                  <div
                    class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400"
                  >
                    <span class="font-semibold text-gray-900 dark:text-white">
                      {{ notifications.name }}
                    </span>
                  </div>
                  <div class="truncate w-64 text-sm">
                    <span>Location : {{ notifications.address }}</span>
                  </div>
                  <div class="truncate w-64 text-sm">
                    <span>Amount : ${{ notifications.amount }}</span>
                  </div>
                  <div
                    class="text-xs font-medium text-primary-600 dark:text-primary-500"
                  >
                    Date: {{ formatDate(notifications.created_date) }}
                  </div>
                </div>
              </Link>
            </div>
            <Link
              v-if="contnitification > 0"
              :href="route('clear.infor')"
              class="block py-2 text-md font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-600 dark:text-white dark:hover:underline"
            >
              <div
                class="inline-flex text-red-500 hover:text-red-800 items-center"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 -mt-1"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"
                  />
                </svg>
                {{ $t("Clear All") }}
              </div>
            </Link>
          </div>

          <!-- Dark Mode -->
          <button
            @click="toggleDark()"
            type="button"
            class="text-sm text-yellow-700 dark:text-yellow-400 dark:hover:bg-gray-700 rounded-lg hover:text-yellow-900 hover:bg-gray-200 p-2 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-6 h-6"
              v-if="isDark == false"
            >
              <path
                d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z"
              />
            </svg>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-6 h-6"
              v-if="isDark == true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"
              />
            </svg>
          </button>
          <div
            class="cursor-pointer group flex mr-3 text-sm hover:bg-hovercolorBG rounded-lg md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 dark:hover:bg-gray-700"
            aria-expanded="false"
            data-dropdown-toggle="dropdown"
          >
            <button
              type="button"
              data-dropdown-toggle="language-dropdown-menu"
              class="text-sm text-yellow-700 dark:text-yellow-400 dark:hover:bg-gray-700 rounded-lg hover:text-yellow-900 hover:bg-gray-200 p-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-6 h-6"
              >
                <path
                  fill-rule="evenodd"
                  d="M9 2.25a.75.75 0 0 1 .75.75v1.506a49.384 49.384 0 0 1 5.343.371.75.75 0 1 1-.186 1.489c-.66-.083-1.323-.151-1.99-.206a18.67 18.67 0 0 1-2.97 6.323c.318.384.65.753 1 1.107a.75.75 0 0 1-1.07 1.052A18.902 18.902 0 0 1 9 13.687a18.823 18.823 0 0 1-5.656 4.482.75.75 0 0 1-.688-1.333 17.323 17.323 0 0 0 5.396-4.353A18.72 18.72 0 0 1 5.89 8.598a.75.75 0 0 1 1.388-.568A17.21 17.21 0 0 0 9 11.224a17.168 17.168 0 0 0 2.391-5.165 48.04 48.04 0 0 0-8.298.307.75.75 0 0 1-.186-1.489 49.159 49.159 0 0 1 5.343-.371V3A.75.75 0 0 1 9 2.25ZM15.75 9a.75.75 0 0 1 .68.433l5.25 11.25a.75.75 0 1 1-1.36.634l-1.198-2.567h-6.744l-1.198 2.567a.75.75 0 0 1-1.36-.634l5.25-11.25A.75.75 0 0 1 15.75 9Zm-2.672 8.25h5.344l-2.672-5.726-2.672 5.726Z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
            <!-- Dropdown -->
            <div
              class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700"
              id="language-dropdown-menu"
            >
              <ul class="py-2 font-medium" role="none">
                <li>
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem"
                    v-for="(item, index) in items.item"
                    :key="index"
                    @click="changeLocale(item)"
                  >
                    <div class="inline-flex items-center">
                      <svg
                        aria-hidden="true"
                        class="w-4 h-4 rounded-full me-2"
                        xmlns="http://www.w3.org/2000/svg"
                        id="flag-icon-css-us"
                        viewBox="0 0 512 512"
                        v-if="item.title == `English`"
                      >
                        <g fill-rule="evenodd">
                          <g stroke-width="1pt">
                            <path
                              fill="#bd3d44"
                              d="M0 0h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                              transform="scale(3.9385)"
                            />
                            <path
                              fill="#fff"
                              d="M0 10h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                              transform="scale(3.9385)"
                            />
                          </g>
                          <path
                            fill="#192f5d"
                            d="M0 0h98.8v70H0z"
                            transform="scale(3.9385)"
                          />
                          <path
                            fill="#fff"
                            d="M8.2 3l1 2.8H12L9.7 7.5l.9 2.7-2.4-1.7L6 10.2l.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7L74 8.5l-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 7.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 24.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 21.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 38.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 35.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 52.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 49.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 66.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 63.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9z"
                            transform="scale(3.9385)"
                          />
                        </g>
                      </svg>
                        <svg
                            aria-hidden="true"
                            class="w-4 h-4 rounded-full me-2"
                            xmlns="http://www.w3.org/2000/svg"
                            id="flag-icon-css-es"
                            viewBox="0 0 640 480"
                            v-if="item.title == `Español`"
                        >
                            <g fill-rule="evenodd">
                            <path fill="#aa151b" d="M0 0h640v480H0z"/>
                            <path fill="#f1bf00" d="M0 120h640v240H0z"/>
                            </g>
                        </svg>
                      <svg
                        version="1.1"
                        id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 799.999 799.999"
                        xml:space="preserve"
                        fill="#000000"
                        class="w-4 h-4 me-2"
                        v-if="item.value == `kh`"
                      >
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g
                          id="SVGRepo_tracerCarrier"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        ></g>
                        <g id="SVGRepo_iconCarrier">
                          <g>
                            <path
                              style="fill: #103b9b"
                              d="M695.774,259.924v-1c0-6.563-5.34-11.903-11.903-11.903H24.807v-93.183h750.387v93.183h-39.709 c-6.563,0-11.903,5.34-11.903,11.903v1H695.774z"
                            ></path>
                            <rect
                              x="24.807"
                              y="552.978"
                              style="fill: #103b9b"
                              width="750.387"
                              height="93.183"
                            ></rect>
                            <path
                              style="fill: #ed1f34"
                              d="M24.807,529.171V270.827h659.064c6.563,0,11.903-5.34,11.903-11.903v-1h27.807v1 c0,6.563,5.34,11.903,11.903,11.903h39.709v258.344H24.807z M243.441,471.967c-6.563,0-11.903,5.34-11.903,11.903 s5.34,11.903,11.903,11.903H556.56c6.56,0,11.896-5.34,11.896-11.903s-5.34-11.903-11.902-11.903h-5.302v-71.538 c0-6.563-5.34-11.903-11.903-11.903h-10.635l-0.198-0.742c-6-22.507-26.365-34.104-27.229-34.586 c-1.771-0.99-3.778-1.513-5.808-1.513s-4.037,0.523-5.807,1.513c-0.864,0.483-21.236,12.106-27.229,34.586l-0.198,0.742h-7.105 l-0.102-0.886c-5.97-52.02-46.626-80.185-48.354-81.358c-1.98-1.347-4.293-2.058-6.688-2.058s-4.707,0.711-6.687,2.058 c-1.728,1.175-42.389,29.371-48.354,81.358l-0.102,0.886h-7.105l-0.198-0.742c-5.997-22.494-26.365-34.104-27.229-34.586 c-1.77-0.99-3.778-1.513-5.807-1.513s-4.037,0.523-5.806,1.513c-0.864,0.483-21.237,12.106-27.23,34.586l-0.198,0.742h-10.635 c-6.563,0-11.903,5.34-11.903,11.903v71.538H243.441z"
                            ></path>
                            <path
                              style="fill: #103b9b"
                              d="M683.871,246.02c7.128,0,12.903,5.775,12.903,12.903h25.807c0-7.128,5.775-12.903,12.903-12.903 h38.709v-91.183H25.807v91.183L683.871,246.02L683.871,246.02z"
                            ></path>
                            <rect
                              x="25.807"
                              y="553.978"
                              style="fill: #103b9b"
                              width="748.387"
                              height="91.183"
                            ></rect>
                            <path
                              style="fill: #ed1f34"
                              d="M683.871,271.827H25.807v256.344h748.387V271.827h-38.709c-7.128,0-12.903-5.775-12.903-12.903 h-25.807C696.774,266.052,690.999,271.827,683.871,271.827z M556.56,496.773H243.441c-7.128,0-12.903-5.775-12.903-12.903 s5.775-12.903,12.903-12.903h4.301v-70.538c0-7.128,5.775-12.903,12.903-12.903h9.867c6.094-22.857,26.688-34.63,27.708-35.202 c3.91-2.187,8.679-2.187,12.59,0c1.021,0.571,21.613,12.344,27.707,35.202h5.445c6.017-52.43,46.915-80.8,48.785-82.071 c4.375-2.975,10.124-2.975,14.499,0c1.872,1.271,42.769,29.641,48.785,82.071h5.445c6.094-22.857,26.687-34.63,27.707-35.202 c3.91-2.187,8.68-2.187,12.59,0c1.022,0.571,21.614,12.344,27.708,35.202h9.866c7.128,0,12.903,5.775,12.903,12.903v70.538h4.302 c7.127,0,12.902,5.775,12.902,12.903S563.687,496.773,556.56,496.773z"
                            ></path>
                            <path
                              d="M787.097,129.031H12.903C5.775,129.031,0,134.807,0,141.935v516.129c0,7.128,5.775,12.903,12.903,12.903h774.193 c7.128,0,12.903-5.775,12.903-12.903V141.935C800,134.807,794.225,129.031,787.097,129.031z M774.193,154.838v91.183h-38.709 c-7.128,0-12.903,5.775-12.903,12.903s5.775,12.903,12.903,12.903h38.709v256.344H25.807V271.827h658.064 c7.128,0,12.903-5.775,12.903-12.903s-5.775-12.903-12.903-12.903H25.807v-91.183L774.193,154.838L774.193,154.838z M25.807,645.16 v-91.183h748.387v91.183H25.807z"
                            ></path>
                            <path
                              style="fill: #ffffff"
                              d="M526.451,470.967v-57.634h-8.182c-7.117,0-12.892-5.764-12.903-12.881 c-0.018-9.291-5.334-16.344-9.865-20.673c-4.54,4.341-9.882,11.415-9.899,20.673c-0.012,7.12-5.785,12.881-12.903,12.881H443.87 c-7.124,0-12.898-5.771-12.903-12.896c-0.022-34.36-19.852-57.435-30.968-67.671c-11.099,10.219-30.941,33.299-30.964,67.671 c-0.005,7.124-5.779,12.896-12.903,12.896h-28.829c-7.118,0-12.892-5.764-12.903-12.881c-0.018-9.291-5.334-16.344-9.865-20.673 c-4.54,4.341-9.882,11.415-9.899,20.673c-0.012,7.12-5.786,12.881-12.903,12.881h-8.183v57.634H526.451z"
                            ></path>
                            <path
                              d="M556.56,470.967h-4.302v-70.538c0-7.128-5.775-12.903-12.903-12.903h-9.866c-6.094-22.857-26.688-34.63-27.708-35.202 c-3.91-2.187-8.679-2.187-12.59,0c-1.021,0.571-21.613,12.344-27.707,35.202h-5.445c-6.017-52.43-46.915-80.8-48.785-82.071 c-4.375-2.975-10.124-2.975-14.499,0c-1.872,1.271-42.769,29.641-48.785,82.071h-5.445c-6.094-22.857-26.687-34.63-27.707-35.202 c-3.91-2.187-8.68-2.187-12.59,0c-1.022,0.571-21.614,12.344-27.708,35.202h-9.874c-7.127,0-12.903,5.775-12.903,12.903v70.538 h-4.301c-7.128,0-12.903,5.775-12.903,12.903s5.775,12.903,12.903,12.903H556.56c7.127,0,12.903-5.775,12.903-12.903 S563.687,470.967,556.56,470.967z M281.731,413.333c7.117,0,12.891-5.764,12.903-12.881c0.018-9.258,5.359-16.331,9.899-20.673 c4.533,4.329,9.85,11.381,9.865,20.673c0.012,7.12,5.785,12.881,12.903,12.881h28.829c7.124,0,12.898-5.771,12.903-12.896 c0.022-34.372,19.865-57.452,30.964-67.671c11.116,10.236,30.945,33.311,30.968,67.671c0.005,7.124,5.779,12.896,12.903,12.896 h28.829c7.118,0,12.892-5.764,12.903-12.881c0.018-9.258,5.359-16.331,9.899-20.673c4.533,4.329,9.85,11.381,9.865,20.673 c0.012,7.12,5.786,12.881,12.903,12.881h8.182v57.634H273.548v-57.634H281.731z"
                            ></path>
                          </g>
                        </g>
                      </svg>
                      {{ item.title }}
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <button
            type="button"
            class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            id="user-menu-button"
            aria-expanded="false"
            data-dropdown-toggle="dropdown"
          >
            <span class="sr-only">Open user menu</span>
            <img
              v-if="!auth.user.profile || auth.user.profile === ''"
              class="w-8 h-8 rounded-full shadow-md border-2 border-white"
              src="/profile.png"
              alt="Profile Image"
            />
            <img
              v-else
              class="w-8 h-8 object-cover rounded-full shadow-md border-2 border-white"
              :src="profileUrl"
              alt="Profile Image"
            />
          </button>
          <!-- Dropdown menu -->
          <div
            class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
            id="dropdown"
          >
            <div class="py-3 px-4">
              <span
                class="block text-sm font-semibold text-gray-900 dark:text-white"
                >{{ $page.props.auth.user.name }}</span
              >
              <span
                class="block text-sm text-gray-500 truncate dark:text-gray-400"
                >{{ $page.props.auth.user.email }}</span
              >
            </div>
            <ul
              class="py-1 text-gray-500 dark:text-gray-400"
              aria-labelledby="dropdown"
            >
              <li v-if="auth.user.name">
                <Link
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                  >Position: {{ userRoles }}</Link
                >
              </li>
              <li v-if="auth.user.name">
                <Link
                  :href="route('profile.index')"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                  >Account settings</Link
                >
              </li>
            </ul>
            <ul
              class="py-1 text-gray-500 dark:text-gray-400"
              aria-labelledby="dropdown"
            >
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-600 group"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                  />
                </svg>
                <span class="group-hover:text-gray-700">Logout</span>
              </Link>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- Sidebar -->

    <aside
      class="sidebar fixed overflow-auto top-14 md:top-0 left-0 shadow-xl z-40 w-64 h-full pt-4 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
      aria-label="Sidenav"
      id="drawer-navigation"
    >
      <div
        class="flex items-center justify-center text-green-950 dark:text-white rounded-lg p-2"
      >
        <div>
          <div class="flex justify-center pb-2">
            <div class="flex items-center justify-center w-20 h-20 bg-yellow-500 rounded-lg shadow-lg hover:scale-110 -mt-5 hover:shadow-xl transition-transform">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-14 h-14 text-white">
                <rect x="20" y="30" width="60" height="50" rx="4" fill="currentColor"/>
                <path d="M 30 30 L 30 25 Q 30 20 35 20 L 65 20 Q 70 20 70 25 L 70 30" stroke="currentColor" stroke-width="3" fill="none"/>
                <circle cx="40" cy="50" r="3" fill="white"/>
                <circle cx="60" cy="50" r="3" fill="white"/>
              </svg>
            </div>
          </div>
          <div
            class="hover:scale-110 font-khmer text-sm -mt-4 cursor-default text-yellow-700"
          >
            {{ $t("systemName") }}
          </div>
        </div>
      </div>
      <div
        class="overflow-y-auto py-2 px-2 h-full bg-white dark:bg-gray-800 dark:text-white"
      >
        <ul class="space-y-1 pb-2">
          <li>
            <SidebarLink
              :href="route('admin.index')"
              :active="false"
              class="dark:hover:bg-gray-700 dark:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="size-6"
              >
                <path
                  d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z"
                />
                <path
                  d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z"
                />
              </svg>

              <span class="font-sans">{{ $t("dashbourd") }}</span>
            </SidebarLink>
          </li>
          <!-- suppliers -->
          <li>
            <SidebarLink
              :href="route('suppliers.index')"
              :active="route().current('suppliers.index')"
              class="dark:hover:bg-gray-700 dark:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="size-6"
              >
                <path
                  d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z"
                />
              </svg>

              <span class="font-sans">{{ $t("Supplier") }}</span>
            </SidebarLink>
          </li>
        </ul>
        <ul
          class="pt-3 space-y-1 border-t border-gray-200 dark:border-gray-700"
        >
          <template v-if="hasRoles(['staff','admin','view'])">
            <!-- Category -->
            <li>
              <SidebarLink
                :href="route('categorys.index')"
                :active="route().current('categorys.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="size-6"
                >
                  <path
                    fill-rule="evenodd"
                    d="M1.5 9.832v1.793c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875V9.832a3 3 0 0 0-.722-1.952l-3.285-3.832A3 3 0 0 0 16.215 3h-8.43a3 3 0 0 0-2.278 1.048L2.222 7.88A3 3 0 0 0 1.5 9.832ZM7.785 4.5a1.5 1.5 0 0 0-1.139.524L3.881 8.25h3.165a3 3 0 0 1 2.496 1.336l.164.246a1.5 1.5 0 0 0 1.248.668h2.092a1.5 1.5 0 0 0 1.248-.668l.164-.246a3 3 0 0 1 2.496-1.336h3.165l-2.765-3.226a1.5 1.5 0 0 0-1.139-.524h-8.43Z"
                    clip-rule="evenodd"
                  />
                  <path
                    d="M2.813 15c-.725 0-1.313.588-1.313 1.313V18a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-1.688c0-.724-.588-1.312-1.313-1.312h-4.233a3 3 0 0 0-2.496 1.336l-.164.246a1.5 1.5 0 0 1-1.248.668h-2.092a1.5 1.5 0 0 1-1.248-.668l-.164-.246A3 3 0 0 0 7.046 15H2.812Z"
                  />
                </svg>

                <span class="font-sans">{{ $t("Category") }}</span>
              </SidebarLink>
            </li>

            <!-- products -->

            <li>
              <SidebarLink
                :href="route('products.index')"
                :active="route().current('products.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="size-6"
                >
                  <path
                    d="M12.378 1.602a.75.75 0 0 0-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03ZM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 0 0 .372-.648V7.93ZM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 0 0 .372.648l8.628 5.033Z"
                  />
                </svg>

                <span class="font-sans">{{ $t("Product") }}</span>
              </SidebarLink>
            </li>
            <!-- Delivery -->
            <li>
              <SidebarLink
                :href="route('deliverys.index')"
                :active="route().current('deliverys.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="size-6"
                >
                  <path
                    d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z"
                  />
                  <path
                    d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z"
                  />
                  <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                </svg>

                <span class="font-sans">{{ $t("Deliverys") }}</span>
              </SidebarLink>
            </li>
          </template>
        </ul>
        <ul
          class="pt-3 space-y-1 border-t border-gray-200 dark:border-gray-700"
        >
        <template v-if="hasRoles(['staff','admin','view'])">
            <li>
              <SidebarLink
                :href="route('orders.index')"
                :active="route().current('orders.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  class="w-6 h-6 dark:text-white"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"
                  />
                </svg>
                <span class="font-sans">{{ $t("Order") }}</span>
              </SidebarLink>
            </li>
            <li v-if="hasRoles(['admin','view'])">
              <SidebarLink
                :href="route('reports.index')"
                :active="route().current('reports.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="size-6"
                >
                  <path
                    fill-rule="evenodd"
                    d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 0 0 3 3h15a3 3 0 0 1-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125ZM12 9.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H12Zm-.75-2.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H12a.75.75 0 0 1-.75-.75ZM6 12.75a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5H6Zm-.75 3.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5H6a.75.75 0 0 1-.75-.75ZM6 6.75a.75.75 0 0 0-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-3A.75.75 0 0 0 9 6.75H6Z"
                    clip-rule="evenodd"
                  />
                  <path
                    d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 0 1-3 0V6.75Z"
                  />
                </svg>

                <span class="font-sans">{{ $t("Reports") }}</span>
              </SidebarLink>
            </li>
            <li v-if="hasRoles(['admin','view'])">
              <SidebarLink
                :href="route('staffs.index')"
                :active="route().current('staffs.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="size-6"
                >
                  <path
                    fill-rule="evenodd"
                    d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z"
                    clip-rule="evenodd"
                  />
                </svg>

                <span class="font-sans">{{ $t("Staff") }}</span>
              </SidebarLink>
            </li>
          </template>
        </ul>
        <ul
          class="pt-3 space-y-1 border-t border-gray-200 dark:border-gray-700"
        >
          <template v-if="hasRole('admin')">
            <li>
              <SidebarLink
                :href="route('users.index')"
                :active="route().current('users.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  class="w-5 h-5"
                >
                  <path
                    d="M10 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM1.615 16.428a1.224 1.224 0 0 1-.569-1.175 6.002 6.002 0 0 1 11.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 0 1 7 18a9.953 9.953 0 0 1-5.385-1.572ZM16.25 5.75a.75.75 0 0 0-1.5 0v2h-2a.75.75 0 0 0 0 1.5h2v2a.75.75 0 0 0 1.5 0v-2h2a.75.75 0 0 0 0-1.5h-2v-2Z"
                  />
                </svg>
                <span class="font-sans">{{ $t("user") }}</span>
              </SidebarLink>
            </li>
            <li>
              <SidebarLink
                :href="route('roles.index')"
                :active="route().current('roles.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  class="w-5 h-5"
                >
                  <path
                    d="M13.024 9.25c.47 0 .827-.433.637-.863a4 4 0 0 0-4.094-2.364c-.468.05-.665.576-.43.984l1.08 1.868a.75.75 0 0 0 .649.375h2.158ZM7.84 7.758c-.236-.408-.79-.5-1.068-.12A3.982 3.982 0 0 0 6 10c0 .884.287 1.7.772 2.363.278.38.832.287 1.068-.12l1.078-1.868a.75.75 0 0 0 0-.75L7.839 7.758ZM9.138 12.993c-.235.408-.039.934.43.984a4 4 0 0 0 4.094-2.364c.19-.43-.168-.863-.638-.863h-2.158a.75.75 0 0 0-.65.375l-1.078 1.868Z"
                  />
                  <path
                    fill-rule="evenodd"
                    d="m14.13 4.347.644-1.117a.75.75 0 0 0-1.299-.75l-.644 1.116a6.954 6.954 0 0 0-2.081-.556V1.75a.75.75 0 0 0-1.5 0v1.29a6.954 6.954 0 0 0-2.081.556L6.525 2.48a.75.75 0 1 0-1.3.75l.645 1.117A7.04 7.04 0 0 0 4.347 5.87L3.23 5.225a.75.75 0 1 0-.75 1.3l1.116.644A6.954 6.954 0 0 0 3.04 9.25H1.75a.75.75 0 0 0 0 1.5h1.29c.078.733.27 1.433.556 2.081l-1.116.645a.75.75 0 1 0 .75 1.298l1.117-.644a7.04 7.04 0 0 0 1.523 1.523l-.645 1.117a.75.75 0 1 0 1.3.75l.644-1.116a6.954 6.954 0 0 0 2.081.556v1.29a.75.75 0 0 0 1.5 0v-1.29a6.954 6.954 0 0 0 2.081-.556l.645 1.116a.75.75 0 0 0 1.299-.75l-.645-1.117a7.042 7.042 0 0 0 1.523-1.523l1.117.644a.75.75 0 0 0 .75-1.298l-1.116-.645a6.954 6.954 0 0 0 .556-2.081h1.29a.75.75 0 0 0 0-1.5h-1.29a6.954 6.954 0 0 0-.556-2.081l1.116-.644a.75.75 0 0 0-.75-1.3l-1.117.645a7.04 7.04 0 0 0-1.524-1.523ZM10 4.5a5.475 5.475 0 0 0-2.781.754A5.527 5.527 0 0 0 5.22 7.277 5.475 5.475 0 0 0 4.5 10a5.475 5.475 0 0 0 .752 2.777 5.527 5.527 0 0 0 2.028 2.004c.802.458 1.73.719 2.72.719a5.474 5.474 0 0 0 2.78-.753 5.527 5.527 0 0 0 2.001-2.027c.458-.802.719-1.73.719-2.72a5.475 5.475 0 0 0-.753-2.78 5.528 5.528 0 0 0-2.028-2.002A5.475 5.475 0 0 0 10 4.5Z"
                    clip-rule="evenodd"
                  />
                </svg>

                <span class="font-sans">{{ $t("role") }}</span>
              </SidebarLink>
            </li>
            <li>
              <SidebarLink
                :href="route('permissions.index')"
                :active="route().current('permissions.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  class="w-5 h-5"
                >
                  <path
                    fill-rule="evenodd"
                    d="M14.5 1A4.5 4.5 0 0 0 10 5.5V9H3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-1.5V5.5a3 3 0 1 1 6 0v2.75a.75.75 0 0 0 1.5 0V5.5A4.5 4.5 0 0 0 14.5 1Z"
                    clip-rule="evenodd"
                  />
                </svg>

                <span class="font-sans">{{ $t("permission") }}</span>
              </SidebarLink>
            </li>
          </template>
        </ul>
        <ul
          class="pt-3 space-y-1 border-t border-gray-200 dark:border-gray-700"
        >
          <template v-if="hasRole('admin')">
            <li>
              <SidebarLink
                :href="route('banners.index')"
                :active="route().current('banners.index')"
                class="dark:hover:bg-gray-700 dark:text-white"
              >
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke="currentColor"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5Zm16 14a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2ZM4 13a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6Zm16-2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6Z"
                  />
                </svg>

                <span class="font-sans">{{ $t("Banner") }}</span>
              </SidebarLink>
            </li>
          </template>
        </ul>
      </div>
    </aside>

    <main class="p-4 md:ml-64 h-auto pt-20">
      <slot />
    </main>
  </div>
</template>
