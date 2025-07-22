<script setup>
import { ref, provide, onMounted } from 'vue'
import Loader from '@/components/Loader.vue'
import { setGlobalLoadingSetter } from './utilities/axios.js'

// Variable réactive globale pour le chargement
const isLoading = ref(false)

// Fournit la variable et la fonction pour les composants enfants
provide('isLoading', isLoading)
provide('setLoading', (val) => { isLoading.value = val })

// Connecte le loader à Axios au montage de l'app
onMounted(() => {
  setGlobalLoadingSetter((val) => { isLoading.value = val })
})
</script>

<template>
  <div id="app">
    <Loader v-if="isLoading" />
    <router-view />
  </div>
</template>

<style scoped>
#app{
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
</style>
