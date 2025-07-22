<script setup>
</script>

<template>
<div class="DivLoader">
    <div class="loader">
    </div>
</div>
</template>

<style scoped>
.DivLoader {
  position: absolute;
  z-index: 10000;
  background-color: rgba(0, 0, 0, 0.8);
  width: 100vw;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.loader {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border-top: 4px solid #fff;
  background-color: transparent;
  box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0%{
    transform: rotate(0deg);
  }
  100%{
    transform: rotate(360deg);
  }
}
</style>