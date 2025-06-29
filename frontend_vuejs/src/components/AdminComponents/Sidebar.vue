<script setup>
import { RouterLink } from 'vue-router';

</script>

<template>
<div class="SidebarContainer">
  <div class="SidebarDivLogo">
    <figure>
      <img src="" alt="logo">
    </figure>
  </div>
  <div class="SidebarItems">
    <hr>
    <router-link to="/dashboard" class="router-link">
      <!-- Définition de la classe active réactive lorsque le nom de la route correspond à la sélection  -->
      <button type="button" :class="{ 'active' : $route.name === 'Dashboard' }">
          Acceuil
      </button>
    </router-link>
    <router-link to="/quiz" class="router-link">
      <button type="button" :class="{ 'active' : $route.name === 'Quiz' }">
        Questionnaire
      </button>
    </router-link>
    <router-link to="/response" class="router-link">
      <button type="button" :class="{ 'active' : $route.name === 'Response' }">
        Réponses
      </button>
    </router-link>
  </div>
</div>
</template>

<style scoped>
.SidebarContainer {
  position: fixed;
  width: 23%;
  height: 100vh;
  background-color: #1e1e1e;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.SidebarDivLogo {
  width: 100%;
  height: 35%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.SidebarDivLogo figure {
  border: 1px solid #fff;
  width: 55%;
  height: 65%;
}

.SidebarDivLogo figure img {
  width: 100%;
  height: 100%;
}

.SidebarItems {
  width: 90%;
  height: auto;
  /*border: 1px solid white;*/
  display: flex;
  flex-direction: column;
  align-items: start;
  justify-content: space-between;
}

.SidebarItems hr {
  border: 1px solid #2c2c2c;
  width: 100%;
  margin-bottom: 20px;
}

.SidebarItems button {
  background-color: transparent;
  padding: 18px 20px;
  width: 100%;
  text-align: left;
  border: none;
  margin-bottom: 8px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 1rem;
  color: #b3b3b3;
  transition: all 0.4s;
}

.SidebarItems button:hover {
  background-color: #2c2c2c;
  color: #fff;
  cursor: pointer;
}

.router-link {
  color: #b3b3b3;
  text-decoration: none;
  width: 100%;
}

button.active {
  background-color: #00b8ff;
  color: black;
}

button.active:hover {
  background-color: #00b8ff;
  color: black;
}
</style>
