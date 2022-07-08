<template>
  <textarea
    :dusk="`table-field-key-${index}`"
    v-model="cells[index].value"
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
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'text',
    },
    value: [String, Boolean],
  }
}
</script>
