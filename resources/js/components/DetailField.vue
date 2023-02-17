<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <TableBody
        v-if="theData.length > 0"
        :edit-mode="false"
        class="overflow-hidden"
      >
        <TableHeader :headers="field.headers"/>

        <div
          class="bg-gray-50 dark:bg-gray-700 overflow-hidden key-value-items"
        >
          <TableItem
            v-for="(item, index) in theData"
            :index="index"
            :item="item"
            :disabled="true"
            :key="item.key"
          />
        </div>
      </TableBody>
    </template>
  </PanelItem>
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
    console.log(this.theData);
  },
}
</script>
