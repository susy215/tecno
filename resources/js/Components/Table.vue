

<script setup>

</script>
<template>
  <!-- responsive table-->
<div class="">
      <table class="w-full">
        <thead class=" text-white dark:shadow-md dark:shadow-gray-600">
                <slot name="header"></slot>

        </thead>
        <tbody>
            <slot name="default"></slot>

        </tbody>
      </table>
    </div>
</template>

<style>

</style>
