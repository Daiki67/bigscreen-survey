<script setup>
// -----------------------------------------------------------------------------
// Composant : LoginView
// Type : Vue 3 (Composition API, <script setup>)
// Rôle : Affiche la page de connexion administrateur et gère l’authentification.
// Librairies tierces utilisées :
//   - axios (import '@/utilities/axios.js') : client HTTP personnalisé pour requêtes AJAX
//   - vue (import { ref } from 'vue') : framework réactif, gestion de la réactivité
//   - vue-router (import { useRouter } from 'vue-router') : navigation SPA
//   - @/utilities/utils.js (import { setAccessToken }) : stockage du token d’accès
// -----------------------------------------------------------------------------

// Import de l'instance Axios personnalisée pour les requêtes HTTP (librairie tierce : axios)
import axios from '@/utilities/axios.js'; // Type : AxiosInstance
// Import de la fonction ref de Vue pour la réactivité (librairie tierce : vue)
import { ref } from 'vue'; // Type : (valeur initiale: any) => Ref<any>
// Import du composable useRouter pour la navigation (librairie tierce : vue-router)
import { useRouter } from 'vue-router'; // Type : () => Router
// Import de la fonction utilitaire pour stocker le token d'accès
import { setAccessToken } from '@/utilities/utils.js'; // Type : (token: string) => void

// -----------------------------------------------------------------------------
// Variables réactives locales
// -----------------------------------------------------------------------------
// errorMessage : Ref<string> - Message d’erreur affiché en cas d’échec de connexion
const errorMessage = ref('');
// email : Ref<string> - Email saisi par l’administrateur
const email = ref('');
// password : Ref<string> - Mot de passe saisi par l’administrateur
const password = ref('');

// -----------------------------------------------------------------------------
// Navigation
// -----------------------------------------------------------------------------
// router : Router - Instance du routeur Vue pour la redirection
const router = useRouter();

// -----------------------------------------------------------------------------
// Méthodes
// -----------------------------------------------------------------------------
/**
 * Fonction de gestion de la connexion administrateur
 * @param {Event} e - L'événement de soumission du formulaire
 * Utilise :
 *   - axios.post(url, data) : envoie la requête de connexion
 *   - setAccessToken(token) : stocke le token d'accès
 *   - router.push(path) : redirige vers la page admin
 */
async function handlelogin(e) {
  e.preventDefault();
  try {
    errorMessage.value = '';
    // Envoie la requête de connexion à l'API
    const response = await axios.post('/login', {
      email: email.value, // string
      password: password.value // string
    });
    // Stocke le token d'accès dans le localStorage
    setAccessToken(response.data.access_token); // string
    // Redirige vers la page d'administration
    router.push('/admin'); // string
  } catch (e) {
    console.error('Message', e);
    errorMessage.value = 'Erreur survenue lors de la connexion administrateur';
    alert(errorMessage.value);
  }
}
// -----------------------------------------------------------------------------

</script>

<template>
<!-- -------------------------------------------------------------------------- -->
<!-- Section principale de la page de connexion -->
<!-- -------------------------------------------------------------------------- -->
<section class="Login" @submit="handlelogin">
  <div class="LoginBlock">
    <div class="DivTitle">
      <h2>bigscreen</h2>
    </div>
    <form action="">
        <!-- Champ email administrateur (lié à la variable réactive email: Ref<string>) -->
        <input type="email" v-model="email" placeholder="Entrer votre mail administrateur" required>
        <!-- Champ mot de passe administrateur (lié à la variable réactive password: Ref<string>) -->
        <input type="password" v-model="password" placeholder="Entrer votre mot de passe" required>
        <!-- Bouton de soumission du formulaire -->
        <button type="submit"> Se connecter </button>
    </form>
  </div>
  <!-- Effets visuels décoratifs (éléments animés) -->
  <div id="Bounce1"></div>
  <div id="Bounce2"></div>
  <div id="Bounce3"></div>
  <div id="Bounce4"></div>
</section>
</template>

<style scoped>
/* -----------------------------------------------------------------------------
 * Composant : LoginView
 * Rôle : Affiche la page de connexion administrateur
 * Librairies tierces utilisées :
 *   - axios : client HTTP pour les requêtes AJAX
 *   - vue : framework réactif (ref)
 *   - vue-router : gestion de la navigation (useRouter)
 * --------------------------------------------------------------------------- */
.Login {
  position: relative;
  width: 100%;
  height: 100vh;
  background-color: #1c1c1c;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow-x: hidden;
  overflow-y: hidden;
}

.LoginBlock {
  width: 24%;
  height: 55vh;
  padding: 30px 30px;
  border-radius: 8px;
  background-color: #2c2c2c;
  border: 3px solid #00b8ff;
  box-shadow: 0px 0px 25px 4px #00b8ff;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow-x: hidden;
  overflow-y: hidden;
}

.DivTitle {
  /*border: 1px solid #fff;*/
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 2.6rem;
  color: #fff;
}

form {
  width: 100%;
  /*border: 1px solid #fff;*/
  height: 70%;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  align-items: center;
}

form input,
form button {
  width: 70%;
  padding: 8px 10px;
  border: 2px solid #00b8ff;
  background: transparent;
  color: #fff;
  border-radius: 5px;
}

form input:focus {
  outline: 1.2px solid #00b8ff;
}

form button {
  width: 80%;
  background-color: #00b8ff;
  transition: all 0.2s;
  font-weight: bold;
}

form button:hover {
  cursor: pointer;
  transform: scale(1.05);
  color: #2c2c2c;
}

#Bounce1{
  position: absolute;
  top: 0;
  left: 0;
  margin-left: -10%;
  margin-top: -10%;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(0, 184, 255, 0.4) 30%, rgba(0, 184, 255,0) 100%);
  box-shadow: 0 0 20px rgba(0, 184, 255, 0.5);
}

#Bounce2{
  position: absolute;
  bottom: 0;
  right: 0;
  margin-right: -10%;
  margin-bottom: -10%;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(0, 184, 255, 0.4) 30%, rgba(0, 184, 255,0) 100%);
  box-shadow: 0 0 20px rgba(0, 184, 255, 0.5);
}

#Bounce3{
  position: absolute;
  bottom: 0;
  left: 0;
  margin-bottom: 3%;
  margin-left: 3%;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  animation: float 20s infinite ease-in-out alternate;
  background: radial-gradient(circle, rgba(0, 184, 255, 0.4) 30%, rgba(0, 184, 255,0) 100%);
  box-shadow: 0 0 20px rgba(0, 184, 255, 0.5);
}

#Bounce4{
  position: absolute;
  top: 0;
  right: 10%;
  margin-top: -3%;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(0, 184, 255, 0.4) 30%, rgba(0, 184, 255,0) 100%);
  box-shadow: 0 0 20px rgba(0, 184, 255, 0.5);
}

@keyframes float {
  0% {
    transform: translate(0, 0) scale(1); opacity: 0.8 ;
  }
  50% {
    transform: translate(20px, 30px) scale(1.05); opacity: 0.9 ;
  }
  100% {
    transform: translate(0, 0) scale(1); opacity: 0.8 ;
  }
}
</style>
