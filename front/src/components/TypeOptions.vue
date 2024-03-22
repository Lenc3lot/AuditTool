<template>
    <option v-for="option in tabOptions" :key="option.auto_ts" :value="option.name">{{ option.name }}</option>
</template>

<script>
import store from '@/store'
export default {
  name: 'TypeOptions',
  head () {
    return {
      title: 'Document',
      meta: [
        {
          hid: 'description',
          name: 'description',
          content: 'Your Page Description'
        }
      ]
    }
  },
  components: {
    // components here
  },
  props: {
    // props here
  },
  watch: {
    // variables to watch here
  },
  data () {
    return {
      // variables here
      dataStore: store,
      tabOptions: []
    }
  },
  methods: {
    // methods here
    getOptions () {
      const formData = new FormData()
      formData.append('type', 'typeOption')
      // Appel ajax
      fetch(this.dataStore.baseUrl + 'readDB.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(response => {
          if (response.status === 200) {
            this.tabOptions = response.data
          }
        })
        .catch(error => console.error(error))
    }
  },
  mounted () {
    // mounted here
    this.getOptions()
  },
  created () {
    // created here
  }
}
</script>

<style scoped>
/* Style here */
</style>
