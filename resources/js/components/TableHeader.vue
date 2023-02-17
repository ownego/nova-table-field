<template>
  <div
    class="bg-gray-100 dark:bg-gray-800 rounded-t-lg flex border-b border-gray-200 dark:border-gray-700"
  >
    <div
      class="bg-clip uppercase font-bold text-xxs text-gray-500 tracking-wide px-3 py-2"
      :class="index > 0 ? 'border-l border-gray-200 dark:border-gray-700' : ''"
      :style="'width: ' + this.width + '%'"
      v-for="(header, index) in headers"
    >
      {{ header }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    headers: {
      type: Object,
    },
  },
  data: () => ({
    width: 100,
  }),

  created() {
    this.width = 100 / this.headers.length;
  }
}
</script>

<style scoped>

</style>
