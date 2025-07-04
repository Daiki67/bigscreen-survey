<script setup>
import { ref } from 'vue';
import Carousel from './Carousel.vue';

const OpenDetail = ref(false);
const selectedResponse = ref(null);

function handleOpenDetail(response) {
  selectedResponse.value = response;
  OpenDetail.value = true;
}

</script>

<template>
<section class="Response">
  
  <article class="ResponseTitle">
    <h2>Réponses des Utilisateurs</h2>
    <hr>
  </article>

  <article class="ResponseContent">

    <Carousel @open-detail="handleOpenDetail" />

  </article>

  <article class="DetailShadow" v-if="OpenDetail">
    <div class="DetailResponse">
      <div class="DetailHeader">
        <div class="DetailTitle">
          <h2>Détails pour alex@email.com</h2>
          <br>
          <span>Soumis le 20/06/2025</span>
        </div>
        <button type="button" @click="OpenDetail = false">×</button>
      </div>
      <hr>
      <table>
        <tbody>
          <tr>
            <td>(1) Votre adresse mail</td>
            <td>alex@email.com</td>
          </tr>
          <tr>
            <td>(2) Votre age</td>
            <td>23</td>
          </tr>
        </tbody>
      </table>
    </div>
  </article>

</section>
</template>

<style scoped>
.Response {
  /*border: 1px solid white;*/
  width: 68vw;
  padding: 40px 0px;
}

.ResponseTitle h2 {
  color: #00b8ff;
  font-weight: bold;
  margin-bottom: 10px;
  font-size: 1.8rem;
}

.ResponseTitle hr {
  border: 1px solid #00b8ff;
  width: 100%;
}

.DetailShadow {
  position: absolute;
  z-index: 100;
  background: rgba(0, 0, 0, 0.7);
  width: 100%;
  height: 100vh;
  left: 0;
  top: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}

.DetailResponse{
  overflow-y: scroll;
  width: 60%;
  height: 500px;
  background: #1e1e1e;
  border: 1px solid #2c2c2c;
  border-radius: 12px;
  padding: 30px;
}

.DetailHeader {
  display: flex;
  justify-content: space-between;
}

.DetailHeader .DetailTitle h2 {
  color: #00b8ff;
  font-size: 1.7rem;
}

.DetailHeader .DetailTitle span {
  color: #fff;
}

.DetailHeader button {
  width: 20px;
  height: 20px;
  margin-right: 30px;
  font-size: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  background: transparent;
  border: 0px;
  color: #bebebe;
  cursor: pointer;
}

.DetailHeader button:hover {
  color: #00b8ff;
}

/* Pour les détalls des réponses afficher en survol */

.DetailResponse hr {
  margin-top: 20px;
  border: 1px solid #2c2c2c;
}

.DetailResponse table {
  /*border: 1px solid #2c2c2c;*/
  margin-top: 30px;
  width: 100%;
}

.DetailResponse td {
  border-bottom: 1px solid #2c2c2c;
  padding: 10px 0px;
}

.DetailResponse td:nth-child(1) {
  color: #bebebe;
}

.DetailResponse td:nth-child(2) {
  color: #fff;
  font-weight: bold;
  text-align: end;
}

/* Pour le carousel */

.ResponseContent {
  /*border: 1px solid #fff;*/
  width: 100%;
  height:300px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-top: 80px;
}

.ResponseCard {
  /*border: 1px solid white;*/
  width: 40%;
  padding: 70px 30px;
  text-align: center;
  color: #bebebe;
  background-color: #1e1e1e;
  border: 1px solid #2c2c2c;
  border-radius: 12px;
  cursor: pointer;
  transform: translateZ(-200px) rotateY(30deg);
  transition: transform 0.5s ease-out, box-shadow 0.3s;
}

.ResponseCard:hover {
  transform: translateZ(150px) rotateY(0deg) scale(1.05);
  box-shadow: 0 10px 20px rgba(0, 184, 255, 0.2);
}

.ResponseCardContainer {
  border: 1px solid #fff;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow-x: hidden;
  perspective: 1000px;
  transform-style: preserve-3d;
}

.ResponseCardContainer:hover .ResponseCard {
  transform: translateZ(150px) rotateX(5deg) rotateY(-5deg) scale(1.05);
}

.ResponseCardEmail {
  font-size: 1.4rem;
  margin-bottom: 20px;
  color: #00b8ff;
  font-weight: bold;
}

.ResponseCardDate {
  font-size: 1.1rem;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.ResponseCardDate p {
  font-size: 1rem;
  margin-top: 15px;
  font-weight: bold;
}

.ResponseButtonNavigation button {
  position: absolute;
  z-index: 2;
  background: transparent;
  border: none;
  color: #00b8ff;
  font-weight: bold;
  font-size: 3rem;
  top: 48%;
  transition: all 0.3s;
}

.ResponseButtonNavigation button:hover {
  text-shadow: 0px 0px 10px rgba(10, 184, 255, 1);
  cursor: pointer;
  transform: scale(1.3);
}

.left-button {
  margin-left: -30%;
}

.right-button {
  right: 8%;
}
</style>

