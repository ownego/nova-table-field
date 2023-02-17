<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :full-width-content="mode === 'modal'"
    :show-help-text="showHelpText"
  >
    <template #field>
      <TableBody
        :edit-mode="!currentlyIsReadonly"
        :can-delete-row="currentField.canDeleteRow"
      >
        <TableHeader
          :headers="field.headers"
        />

        <div class="bg-white overflow-hidden table-items">
          <TableItem
            v-for="(item, index) in theData"
            :index="index"
            @remove-row="removeRow"
            :item.sync="item"
            :key="item.id"
            :ref="item.id"
          />
        </div>
      </TableBody>

      <div class="mr-11">
        <button
          @click="addRowAndSelect"
          :dusk="`${field.attribute}-add-table`"
          type="button"
          class="cursor-pointer focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 focus:ring-offset-4 dark:focus:ring-offset-gray-800 rounded-lg mx-auto text-primary-500 font-bold link-default mt-3 px-3 rounded-b-lg flex items-center"
        >
          <Icon type="plus-circle" />
          <span class="ml-1">{{ currentField.actionText }}</span>
        </button>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import TableBody from "./TableBody";
import TableHeader from "./TableHeader";
import TableItem from "./TableItem";
import findIndex from 'lodash/findIndex'
import fromPairs from 'lodash/fromPairs'
import map from 'lodash/map'
import reject from 'lodash/reject'
import tap from 'lodash/tap'
import { FormField, HandlesValidationErrors } from 'laravel-nova'

function guid() {
  var S4 = function () {
    return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1)
  }
  return (
    S4() +
    S4() +
    '-' +
    S4() +
    '-' +
    S4() +
    '-' +
    S4() +
    '-' +
    S4() +
    S4() +
    S4()
  )
}

export default {
  components: {TableBody, TableItem, TableHeader},
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data: () => ({ theData: [] }),

  mounted() {
    this.populateKeyValueData()
  },

  methods: {
    /*
     * Set the initial value for the field
     */
    populateKeyValueData() {
      this.theData = this.field.value.map(item => {
        const values = this.field.headers.map(header => _.get(item, _.snakeCase(header)));

        return {
          id: guid(),
          values
        };
      });

      if (this.theData.length == 0) {
        this.addRow()
      }
      console.log(this.theData);
    },

    /**
     * Provide a function that fills a passed FormData object with the
     * field's internal value attribute.
     */
    fill(formData) {
      this.fillIfVisible(
        formData,
        this.field.attribute,
        JSON.stringify(this.finalPayload)
      )
    },

    /**
     * Add a row to the table.
     */
    addRow() {
      return tap(guid(), id => {
        const emptyValues = this.field.headers.map(() => '');
        this.theData = [...this.theData, { id, values: emptyValues }]
        return id
      })
    },

    /**
     * Add a row to the table and select its first field.
     */
    addRowAndSelect() {
      return this.selectRow(this.addRow())
    },

    /**
     * Remove the row from the table.
     */
    removeRow(id) {
      return tap(
        findIndex(this.theData, row => row.id == id),
        index => this.theData.splice(index, 1)
      )
    },

    /**
     * Select the first field in a row with the given ref ID.
     */
    selectRow(refId) {
      return this.$nextTick(() => {
        this.$refs[refId][0].handleCellFocus()
      })
    },

    onSyncedField() {
      this.populateKeyValueData()
    },
  },

  computed: {
    /**
     * Return the final filtered json object
     */
    finalPayload() {
      return this.theData.map(item => {
        const values = item.values;
        const result = {};

        this.field.headers.forEach((header, index)=> {
          const key = _.snakeCase(header);
          let value = _.get(values, index);

          if (value === 'true' || value === 'false') {
            value = value === 'true';
          }

          result[key] = value;
        });

        return result;
      });
    },
  },
}
</script>
