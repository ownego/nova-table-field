<template>
  <div class="flex items-center table-item">
    <div
      class="flex flex-grow border-b border-gray-200 dark:border-gray-700 table-fields"
    >
      <div
        class="flex-grow border-l border-gray-200 dark:border-gray-700"
        :class="[
          !isEditable
            ? 'bg-gray-50 dark:bg-gray-800'
            : 'bg-white dark:bg-gray-900',
        ]"
        v-for="(cell, index) in cells"
      >
        <textarea
          rows="1"
          :dusk="`table-key-${index}`"
          v-model="item.values[index]"
          @focus="handleCellFocus"
          ref="keyField"
          type="text"
          class="font-mono text-xs resize-none block w-full px-3 py-3 dark:text-gray-400 bg-clip-border focus:outline-none focus:ring focus:ring-inset"
          :readonly="!isEditable"
          :tabindex="!isEditable ? -1 : 0"
          style="background-clip: border-box"
          :class="{
            'bg-white dark:bg-gray-800 focus:outline-none cursor-not-allowed':
              !isEditable,
            'hover:bg-20 focus:bg-white dark:bg-gray-900 dark:focus:bg-gray-900':
              isEditable,
          }"
        />
      </div>
    </div>

    <div
      v-if="isEditable"
      class="flex justify-center h-11 w-11 absolute -right-[50px]"
    >
      <BasicButton
        @click="$emit('remove-row', item.id)"
        :dusk="`remove-table-${index}`"
        type="button"
        tabindex="0"
        class="flex items-center appearance-none cursor-pointer text-red-500 hover:text-red-600 active:outline-none active:ring focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600"
        :title="__('Delete')"
      >
        <Icon type="minus-circle" />
      </BasicButton>
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
