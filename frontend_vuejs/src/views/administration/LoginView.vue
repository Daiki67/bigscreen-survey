<script setup>
import axios from '@/utilities/axios.js';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { setAccessToken } from '@/utilities/utils.js';

const errorMessage = ref('');
const email = ref('');
const password = ref('');

const router = useRouter();

async function handlelogin(e) {
  e.preventDefault();
  try {
    errorMessage.value = '';
    const response = await axios.post('/login', {
      email: email.value,
      password: password.value
    });
    //console.log(response.data);
    setAccessToken(response.data.access_token);
    router.push('/admin')
  } catch (e) {
    console.error('Message', e);
    errorMessage.value = 'Erreur survenue lors de la connexion administrateur';
    alert(errorMessage.value);
  }
};
</script>

<template>
<section class="Login" @submit="handlelogin">
  <div class="LoginBlock">
    <div class="DivTitle">
      <h2>bigscreen</h2>
    </div>
    <form action="">
        <input type="email" v-model="email" placeholder="Entrer votre mail administrateur" required>
        <input type="password" v-model="password" placeholder="Entrer votre mot de passe" required>
        <button type="submit"> Se connecter </button>
    </form>
  </div>
  <div id="Bounce1"></div>
  <div id="Bounce2"></div>
  <div id="Bounce3"></div>
  <div id="Bounce4"></div>
</section>
</template>

<style scoped>
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
