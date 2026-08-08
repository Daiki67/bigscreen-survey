<script setup>
</script>

<template>
<div class="DivLoader">
  <div class="loader"></div>
</div>
</template>

<style scoped>
.DivLoader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
  background-color: rgba(0, 0, 0, 0.85);
  display: flex;
  align-items: center;
  justify-content: center;
}

.loader {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 4px solid rgba(255, 255, 255, 0.1);
  border-top: 4px solid #00b8ff;
  background-color: transparent;
  box-shadow: 0px 0px 20px rgba(0, 184, 255, 0.3);
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>