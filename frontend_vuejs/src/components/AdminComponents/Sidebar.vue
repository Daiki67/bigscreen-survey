<script setup>
import { RouterLink } from 'vue-router';
import axios from '@/utilities/axios.js';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { getAccessToken, removeAccessToken } from '@/utilities/utils.js';

const errorMessage = ref('');
const router = useRouter();

const handleLogout = async () => {
  try {
    errorMessage.value = '';

    await axios.delete('/admin/logout', {
      headers: { Authorization: 'Bearer ' +  getAccessToken() }
    });

    removeAccessToken();

    router.push('/administration');
  }catch(e){
    console.error('Erreur Logout:', e);
    errorMessage.value = 'Erreur survenue lors de la déconnexion';
    alert(errorMessage.value);
  }
}


</script>

<template>
<div class="SidebarContainer">
  <div class="SidebarDivLogo">
    <div>
      <h2>bigscreen</h2>
    </div>
  </div>
  <div class="SidebarItems">
    <hr>
    <router-link to="/administration/dashboard" class="router-link">
      <!-- Définition de la classe active réactive lorsque le nom de la route correspond à la sélection  -->
      <button type="button" :class="{ 'active' : $route.name === 'Dashboard' }">
          Acceuil
      </button>
    </router-link>
    <router-link to="/administration/quiz" class="router-link">
      <button type="button" :class="{ 'active' : $route.name === 'Quiz' }">
        Questionnaire
      </button>
    </router-link>
    <router-link to="/administration/response" class="router-link">
      <button type="button" :class="{ 'active' : $route.name === 'Response' }">
        Réponses
      </button>
    </router-link>
    <router-link to="#" class="router-link" @click="handleLogout">
      <button type="button">
        Logout
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

.SidebarDivLogo div {
  /*border: 1px solid #fff;*/
  width: 85%;
  height: 65%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.SidebarDivLogo div h2 {
  font-size: 3.2rem;
  color: #fff;
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
