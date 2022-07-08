<template>
  <div class="flex items-center key-value-item">
    <div class="flex flex-grow border-b border-50 key-value-fields">
      <div
        class="flex-grow"
        v-for="(cell, index) in cells"
        :key="index"
        :class="index > 0 ? 'border-l border-50' : 'cursor-text'"
      >
        <textarea
          :dusk="`table-field-key-${index}`"
          v-model="cells[index]"
          @focus="handleCellFocus(index)"
          ref="cell"
          type="text"
          class="font-mono text-sm resize-none block min-h-input w-full form-control form-input form-input-row py-4 text-90"
          :disabled="!isEditable"
          style="background-clip: border-box;"
          :class="{
            'bg-white': !isEditable,
            'hover:bg-20 focus:bg-white': isEditable,
          }"
        />
      </div>
    </div>

    <div
      v-if="isEditable"
      class="flex justify-center h-11 w-11 absolute"
      style="right: -50px"
    >
      <button
        @click="$emit('remove-row', item.id)"
        type="button"
        tabindex="-1"
        class="flex appearance-none cursor-pointer text-70 hover:text-primary active:outline-none active:shadow-outline focus:outline-none focus:shadow-outline"
        title="Delete"
      >
        <icon/>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    index: Number,
    item: Object,
    disabled: {
      type: Boolean,
      default: false,
    },
    readOnly: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    cells: [],
    id: null,
  }),

  created() {
    this.cells = this.item.values;
    this.id = this.item.id;
  },

  methods: {
    handleCellFocus(index) {
      this.$refs.cell[index].select()
    },
  },

  computed: {
    isEditable() {
      return !this.readOnly && !this.disabled
    },
  },
}
</script>
