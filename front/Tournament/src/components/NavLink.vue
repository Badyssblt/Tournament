<script setup>
defineProps(['to']);
</script>

<template>
<router-link :to="to" class="border border-transparent px-6 py-2 bg-primary text-white flex rounded justify-center hover:bg-transparent hover:text-primary  hover:border-primary transition-all">
  <slot/>
</router-link>
</template>

<style scoped>

</style>