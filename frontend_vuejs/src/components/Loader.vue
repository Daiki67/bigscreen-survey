<script setup>
</script>

<template>
<div class="DivLoader">
  <div class="loader-container">
    <div class="loader"></div>
  </div>
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
  backdrop-filter: blur(4px);
}

.loader-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.loader {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  border: 5px solid rgba(255, 255, 255, 0.12);
  border-top-color: #00b8ff;
  border-right-color: #00b8ff;
  box-sizing: border-box;
  animation: spin 0.9s cubic-bezier(0.4, 0, 0.2, 1) infinite;
  filter: drop-shadow(0 0 12px rgba(0, 184, 255, 0.8));
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