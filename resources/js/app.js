require('./bootstrap')

import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import VueMeta from 'vue-meta'
import route from 'ziggy'
import { BootstrapVue } from 'bootstrap-vue'
import VueDayjs from 'vue-dayjs-plugin'
import relativeTime from 'dayjs/plugin/relativeTime'
import LocalizedFormat from 'dayjs/plugin/localizedFormat'

Vue.use(InertiaApp)
Vue.use(VueMeta)
Vue.use(BootstrapVue)
Vue.use(VueDayjs)

Vue.prototype.$route = (...args) => route(...args).url()
Vue.prototype.$router = route()
Vue.prototype.$dayjs.extend(relativeTime)
Vue.prototype.$dayjs.extend(LocalizedFormat)

new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => require(`./Pages/${name}`).default,
    },
  }),
}).$mount('#app')
