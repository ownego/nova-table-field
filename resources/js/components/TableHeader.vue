<template>
  <div class="bg-30 rounded-t-lg flex border-b border-50">
    <div
      class="bg-clip uppercase font-bold text-xs text-80 tracking-wide px-3 py-3"
      v-for="(header, index) in headers"
      :key="index"
      :class="index > 0 ? 'border-l border-50' : ''"
      :style="'flex: 0 0 ' + width + '%'"
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
