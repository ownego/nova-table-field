import DetailField from "./components/DetailField.vue";
import FormField from "./components/FormField.vue";

Nova.booting((app, store) => {
  app.component('detail-table', DetailField);
  app.component('form-table', FormField);
})
