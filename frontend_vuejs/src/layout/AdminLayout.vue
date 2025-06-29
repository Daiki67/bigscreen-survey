<script setup>
import { RouterView } from 'vue-router';
import Sidebar from '@/components/AdminComponents/Sidebar.vue';
</script>

<template>
<div class="LayoutContainer">
    <Sidebar />
  <div class="content-wrapper">
    <router-view />
  </div>
</div>
</template>

<style scoped>
.LayoutContainer {
  /*border: 1px solid red;*/
  width: 100%;
  height: auto;
  display: flex;
}

.content-wrapper {
  /*border: 2px solid red;*/
  margin-left: 23%;
  width: calc(100% - 23%);
  height: 100vh;
  background-color: #121212;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  overflow-x: hidden;
}
</style>
