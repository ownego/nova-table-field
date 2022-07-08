<template>
  <panel-item :field="field">
    <template slot="value">
      <TableBody
        v-if="field.headers.length > 0"
        :edit-mode="false"
        class="overflow-hidden"
      >
        <TableHeader :headers="field.headers"/>

        <div class="bg-white overflow-hidden key-value-items">
          <TableItem
            v-for="item in theData"
            :item="item"
            :disabled="true"
            :key="item.key"
          />
        </div>
      </TableBody>
    </template>
  </panel-item>
</template>

<script>
import TableBody from "./TableBody";
import TableHeader from "./TableHeader";
import TableItem from "./TableItem";

export default {
  props: ['resource', 'resourceName', 'resourceId', 'field'],
  components: {TableBody, TableHeader, TableItem},

  data: () => ({
    theData: [],
  }),

  created() {
    this.theData = this.field.value.map(item => {
      const values = this.field.headers.map(header => {
        const key = _.snakeCase(header);
        return _.get(item, key, null);
      });

      return {
        values
      }
    });
  },
}
</script>
