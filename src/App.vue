<script setup>
import axios from 'axios'
import { useAppStore } from './stores/app'
import { ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
//
import ErrorDialog from './components/ErrorDialog.vue'
//
const store = useAppStore()
const { refresh, search } = storeToRefs(store)
// refs
const error = ref()
// watchers
watch(refresh, () => {
  if ( store.refresh === true ) {
    getData()
    setTimeout(() => {
      store.refresh = false
    },500)
  }
})

watch(search, () => {
  if ( store.search !='' ) {
    getSearch(store.search)
  } else {
    getData()
  }
})
//
const testingBd = async () => {
  await axios.get(store.url+'conn/pdo.php?fetch=1')
    .then(r => {
      let bd = r.data.bd
      if ( bd === true ) {
        testingTable()
      } else {
        error.value.open('Não foi possível se conectar ao banco de dados. Por favor, verifique os dados e tente novamente...')
      }
    })
}

const testingTable = async () => {
  await axios.get(store.url+'getBdtable.php')
    .then(r => {
      let table = r.data.table
      if ( table === true ) {
        getData()
      } else {
        error.value.open('A tabela necessária para o funcionamento desta página não foi encontrada. Clique em INSTALAR TABELA para continuar.', true)
      }
    })
}

const getData = async () => {
  await axios.get(store.url+'data.php')
    .then(r => {
      store.desserts = r.data
      setTimeout(() => {
        store.initialLoading = false
      },1000)
      getJson()
    })
}

const getSearch = async (s) => {
  await axios.get(store.url+'data.php?s='+s)
    .then(r => {
      store.desserts = r.data
    })
}

const getJson = async () => {
  await axios.get('https://cdn.statically.io/gh/blbsouza/cdn/main/json/web-app.json')
    .then(r => {
      store.json = r.data
    })
}

testingBd()
</script>

<style>
@import './styles/style.css';
</style>

<template>
  <v-app>
    <ErrorDialog ref="error" />
    <v-main class="bg-grey-lighten-4">
      <router-view />
    </v-main>
  </v-app>
</template>
