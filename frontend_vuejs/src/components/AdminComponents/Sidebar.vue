<!-- ----------------------------------------------------------------------------- -->
<!-- Composant : Sidebar -->
<!-- ----------------------------------------------------------------------------- -->
<!-- Type : Structurel (barre latérale de navigation pour l'administration) -->

<!-- Librairies tierces utilisées : -->
<!-- - vue-router : -->
<!--     - RouterLink : composant pour la navigation sans rechargement de page -->
<!--     - useRouter : hook pour navigation programmatique -->
<!--     - $route : objet global pour accéder à la route courante -->
<!-- - axios : instance personnalisée pour les requêtes HTTP (logout) -->
<!-- - @/utilities/utils.js : -->
<!--     - getAccessToken : fonction pour récupérer le token d'accès -->
<!--     - removeAccessToken : fonction pour supprimer le token d'accès -->

<!-- État local : -->
<!-- - errorMessage (ref<string>) : message d'erreur affiché lors d'un échec de déconnexion -->
<!-- - router (useRouter) : instance du routeur pour navigation programmatique -->

<!-- Méthodes : -->
<!-- - handleLogout (async) : -->
<!--     - Déclenche la déconnexion de l'administrateur -->
<!--     - Appelle l'API /admin/logout -->
<!--     - Supprime le token localement -->
<!--     - Redirige vers la page d'administration -->
<!-- ----------------------------------------------------------------------------->

<script setup>
// Importation des librairies tierces et utilitaires
import { RouterLink } from 'vue-router'; // Composant de navigation (vue-router)
import axios from '@/utilities/axios.js'; // Instance Axios personnalisée
import { ref } from 'vue'; // API de réactivité (Vue 3)
import { useRouter } from 'vue-router'; // Hook pour navigation programmatique (vue-router)
import { getAccessToken, removeAccessToken } from '@/utilities/utils.js'; // Fonctions utilitaires pour le token

// errorMessage : ref<string> - message d'erreur pour la déconnexion
const errorMessage = ref('');
const showMenu = ref(false);
// router : instance du routeur pour navigation programmatique
const router = useRouter();

// handleLogout : Fonction asynchrone pour déconnecter l'utilisateur
// - Appelle l'API de logout
// - Supprime le token d'accès
// - Redirige vers la page d'administration
// - Affiche un message d'erreur en cas d'échec
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

const isOpen = () => {
  showMenu.value = !showMenu.value; 
}

const closeMenu = () => {
  showMenu.value = false;
}
</script>

<template>
  <div>

    <!-- SidebarContainer : conteneur principal de la barre latérale -->
    <div class="SidebarContainer">
      <!-- SidebarDivLogo : zone d'affichage du logo -->
      <div class="SidebarDivLogo">
        <div>
          <h2>bigscreen</h2>
        </div>
      </div>
      <!-- SidebarItems : liste des boutons de navigation -->
      <div class="SidebarItems">
        <hr>
        <!--
          Composant : RouterLink (Accueil)
          - Type : Lien de navigation
          - Props :
            - to : String - '/administration/dashboard' (chemin de destination)
            - class : String - 'router-link' (classe CSS)
          - Contenu :
            - Button
              - Nom : Acceuil
              - Type : bouton de navigation
              - Paramètres : active si $route.name === 'Dashboard'
              - Rôle : Accéder au tableau de bord admin
        -->
        <router-link to="/administration/dashboard" class="router-link">
          <button type="button" :class="{ 'active' : $route.name === 'Dashboard' }">
              Acceuil
          </button>
        </router-link>
        <!--
          Composant : RouterLink (Questionnaire)
          - Type : Lien de navigation
          - Props :
            - to : String - '/administration/quiz'
            - class : String - 'router-link'
          - Contenu :
            - Button
              - Nom : Questionnaire
              - Type : bouton de navigation
              - Paramètres : active si $route.name === 'Quiz'
              - Rôle : Accéder à la gestion des questionnaires
        -->
        <router-link to="/administration/quiz" class="router-link">
          <button type="button" :class="{ 'active' : $route.name === 'Quiz' }">
            Questionnaire
          </button>
        </router-link>
        <!--
          Composant : RouterLink (Réponses)
          - Type : Lien de navigation
          - Props :
            - to : String - '/administration/response'
            - class : String - 'router-link'
          - Contenu :
            - Button
              - Nom : Réponses
              - Type : bouton de navigation
              - Paramètres : active si $route.name === 'Response'
              - Rôle : Accéder à la gestion des réponses
        -->
        <router-link to="/administration/response" class="router-link">
          <button type="button" :class="{ 'active' : $route.name === 'Response' }">
            Réponses
          </button>
        </router-link>
        <!--
          Composant : RouterLink (Logout)
          - Type : Lien d'action
          - Props :
            - to : String - '#'
            - class : String - 'router-link'
            - @click : Fonction - handleLogout (déclenche la déconnexion)
          - Contenu :
            - Button
              - Nom : Logout
              - Type : bouton d'action
              - Rôle : Déconnecter l'administrateur
        -->
        <router-link to="#" class="router-link" @click="handleLogout">
          <button type="button">
            Logout
          </button>
        </router-link>
      </div>
    </div>

    <div  class="TopBar">
      <div class="TopBarTitle">
        <router-link class="routerlink" to="/admin">
          bigscreen
        </router-link>
      </div>
      <div class="TopBarMenu" @click="isOpen">
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>

    <div class="PhoneMenu" v-if="showMenu" :class="{ 'nav-open': isOpen }">
      
      <router-link to="/administration/dashboard" class="router-link" @click.native="closeMenu">
        <button type="button" :class="{ 'active' : $route.name === 'Dashboard' }">
          Acceuil
        </button>
      </router-link>

      <hr>
      
      <router-link to="/administration/quiz" class="router-link" @click.native="closeMenu">
        <button type="button" :class="{ 'active' : $route.name === 'Quiz' }">
          Questionnaire
        </button>
      </router-link>

      <hr>
      
      <router-link to="/administration/response" class="router-link" @click.native="closeMenu">
        <button type="button" :class="{ 'active' : $route.name === 'Response' }">
          Réponses
        </button>
      </router-link>

      <hr>
      
      <router-link to="#" class="router-link" @click="handleLogout" @click.native="closeMenu">
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

.TopBar,
.PhoneMenu {
  display: none;
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
  font-size: 2.5rem;
  color: #fff;
  font-family: 'Orbitron', sans-serif;
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

@media screen and (max-width: 1024px) {
  
  .SidebarDivLogo div h2 {
    font-size: 2.8rem;
  }
  
}

@media screen and (max-width: 768px) {
  
  .SidebarDivLogo div h2 {
    font-size: 2.2rem;
  }
  
}

@media screen and (max-width: 480px) {
  
  .SidebarContainer {
    display: none;
  }

  .TopBar {
    position: absolute;
    top: 0;
    height: 60px;
    width: 100%;
    background-color: #00b8ff;
    display: flex;
    z-index: 999;
    align-items: center;
    justify-content: space-between;
  }

  .TopBarTitle {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin-left: 20px;
    font-family: 'Orbitron', sans-serif;
  }
  
  .routerlink {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
  }

  .TopBarMenu {
    border: 1.5px solid white;
    width: 50px;
    height: 35px;
    margin-right: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-evenly;
    border-radius: 8px;
  }

  .TopBarMenu div {
    height: 2px;
    width: 70%;
    background-color: #fff;
  }

  .PhoneMenu {
    position: absolute;
    z-index: 999;
    background-color: #2c2c2c;
    width: 100%;
    height: 100vh;
    top: 60px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: start;
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
  }

  .PhoneMenu.nav-open{
    transform: translateX(0);
  }

  .PhoneMenu hr {
    border: 1px solid #00b8ff;
    width: 90%;
    margin-bottom: 30px;
  }

  .PhoneMenu .router-link {
    /*border: 1px solid red;*/
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .PhoneMenu .router-link:nth-child(1) {
    margin-top: 100px;
  }
  
  .PhoneMenu .router-link button {
    padding: 14px 15px;
    width: 90%;
    border-radius:8px;
    font-size: 1.4rem;
    text-align: left;
    background-color: #1e1e1e;
    border: none;
    color: #b3b3b3;
  }

  .PhoneMenu .router-link button.active {
    background-color: #00b8ff;
  } 

}
</style>
