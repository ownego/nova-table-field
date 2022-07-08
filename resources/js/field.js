Nova.booting((Vue, router, store) => {
  Vue.component('detail-table', require('./components/DetailField'))
  Vue.component('form-table', require('./components/FormField'))
})
