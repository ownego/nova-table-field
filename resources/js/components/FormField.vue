<template>
  <default-field :field="field" :errors="errors" :full-width-content="true">
    <template slot="field">
      <TableBody>
        <TableHeader :headers="field.headers"/>

        <div class="bg-white overflow-hidden key-value-items">
          <TableItem
            v-for="(item, index) in theData"
            :index="index"
            @remove-row="removeRow"
            :item.sync="item"
            :key="item.id"
            :ref="item.id"
            :read-only="field.readonly"
          />
        </div>
      </TableBody>

      <div class="mr-11" v-if="!field.readonly">
        <button
          @click="addRowAndSelect"
          type="button"
          class="btn btn-link dim cursor-pointer rounded-lg mx-auto text-primary mt-3 px-3 rounded-b-lg flex items-center"
        >
          <icon type="add" width="24" height="24" view-box="0 0 24 24"/>
          <span class="ml-1">{{ field.actionText }}</span>
        </button>
      </div>
    </template>
  </default-field>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import TableBody from "./TableBody";
import TableHeader from "./TableHeader";
import TableItem from "./TableItem";

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

  data: () => ({
    theData: [],
  }),

  created() {
    this.theData = this.field.value.map(item => {
      const values = this.field.headers.map(header => _.get(item, _.snakeCase(header)));

      return {
        id: guid(),
        values
      };
    });
  },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, JSON.stringify(this.finalPayload))
    },

    /**
     * Add a row to the table.
     */
    addRow() {
      return _.tap(guid(), id => {
        this.theData = [...this.theData, {id, values: this.field.headers.map(header => null)}]
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
      return _.tap(
        _.findIndex(this.theData, row => row.id == id),
        index => this.theData.splice(index, 1)
      )
    },

    /**
     * Select the first field in a row with the given ref ID.
     */
    selectRow(refId) {
      return this.$nextTick(() => {
        this.$refs[refId][0].$refs.cell[0].select()
      })
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
          result[key] = _.get(values, index);
        });

        return result;
      });
    },
  },
}
</script>
