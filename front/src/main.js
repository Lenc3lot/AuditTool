import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

class Util {
  static install (vue, options = {}) {
    function generateFormData (data) {
      const bodyFormData = new FormData()
      try {
        Object.keys(data).forEach(key => {
          if (typeof data[key] === 'string' || typeof data[key] === 'number') {
            bodyFormData.set(key, data[key])
          } else if (typeof data[key] === 'object' && data[key] !== null) {
            try {
              data[key].forEach(elem => {
                bodyFormData.append('key', elem)
              })
            } catch (e) {
              console.error('data: ' + JSON.stringify(data), 'key: ' + key, 'data[key]: ' + data[key], 'error: ' + e)
            }
          }
        })
      } catch (e) {
        console.error('data: ' + JSON.stringify(data), 'error: ' + e)
      }
      return bodyFormData
    }

    function decodeTokenData (input) {
      return JSON.parse(atob(decodeBase64URL(input.split('.')[1])))
    }

    function decodeBase64URL (input) {
      // Replace non-url compatible chars with base64 standard chars
      input = input
        .replace(/-/g, '+')
        .replace(/_/g, '/')
      // Pad out with standard base64 required padding characters
      var pad = input.length % 4
      if (pad) {
        if (pad === 1) {
          throw new Error('InvalidLengthError: Input base64url string is the wrong length to determine padding')
        }
        // eslint-disable-next-line
        input += new Array(5-pad).join('=')
      }
      return input
    }

    if (vue.config?.globalProperties && !vue.config.globalProperties.$genFD) {
      // vue 3
      vue.config.globalProperties.$genFD = generateFormData
      vue.provide('$genFD', generateFormData)
    } else if (!Object.prototype.hasOwnProperty.call(vue, '$genFD')) {
      // vue 2

      // eslint-disable-next-line
        vue.prototype.$genFD = generateFormData
      vue.genFD = generateFormData
    }

    if (vue.config?.globalProperties && !vue.config.globalProperties.$decodeToken) {
      // vue 3
      vue.config.globalProperties.$decodeToken = decodeTokenData
      vue.provide('$decodeToken', decodeTokenData)
    } else if (!Object.prototype.hasOwnProperty.call(vue, '$decodeToken')) {
      // vue 2

      // eslint-disable-next-line
        vue.prototype.$decodeToken = decodeTokenData
      vue.decodeToken = decodeTokenData
    }
  }
}
createApp(App).use(router).use(Util).use(VueSweetalert2).mount('#app')
