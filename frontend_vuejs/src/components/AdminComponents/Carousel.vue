<script setup>
import { ref, defineEmits } from 'vue';

const emit = defineEmits(['open-detail']);

const responses = ref([
  { email: 'alex@gmail.com', date: '26/06/2025' },
  { email: 'john.doe@gmail.com', date: '27/06/2025' },
  { email: 'jane.doe@gmail.com', date: '28/06/2025' },
  { email: 'user@example.com', date: '29/06/2025' },
  { email: '1@gmail.com', date: '26/06/2025' },
  { email: '2.doe@gmail.com', date: '27/06/2025' },
  { email: '3.doe@gmail.com', date: '28/06/2025' },
  { email: '4@example.com', date: '29/06/2025' },
  { email: '5@gmail.com', date: '26/06/2025' },
  { email: '6.doe@gmail.com', date: '27/06/2025' },
  { email: '7.doe@gmail.com', date: '28/06/2025' },
  { email: '8@example.com', date: '29/06/2025' },
]);

const activeIndex = ref(0);

function prev() {
  activeIndex.value = (activeIndex.value - 1 + responses.value.length) % responses.value.length;
}
function next() {
  activeIndex.value = (activeIndex.value + 1) % responses.value.length;
}
</script>

<template>
  <section class="carousel">
    <div class="carousel-inner">
      <div
        v-for="(response, i) in responses"
        :key="i"
        class="carousel-card"
        :class="{ active: i === activeIndex, left: i === (activeIndex - 1 + responses.length) % responses.length, right: i === (activeIndex + 1) % responses.length }"
      >
        <div class="ResponseCard" @click="emit('open-detail', response)">
          <div class="ResponseCardEmail">{{ response.email }}</div>
          <div class="ResponseCardDate">
            Réponse soumise le {{ response.date }}
            <p>Cliquez pour voir les détails</p>
          </div>
        </div>
      </div>
      <button class="carousel-arrow left" @click="prev">&#60;</button>
      <button class="carousel-arrow right" @click="next">&#62;</button>
      <div class="carousel-dots">
        <span
          v-for="(r, i) in responses"
          :key="i"
          :class="{ active: i === activeIndex }"
          @click="activeIndex = i"
        ></span>
      </div>
    </div>
  </section>
</template>

<style scoped>
.carousel {
  width: 100%;
  height: 320px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}
.carousel-inner {
  width: 100%;
  max-width: 700px;
  height: 320px;
  position: relative;
  perspective: 1200px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.carousel-card {
  position: absolute;
  top: 45%;
  left: 45%;
  width: 400px;
  padding: 30px;
  max-width: 90vw;
  min-height: 220px;
  transform: translate(-50%, -50%) scale(0.7) rotateY(30deg);
  opacity: 0.3;
  z-index: 1;
  transition:
  transform 0.5s cubic-bezier(.23,1.02,.67,.98),
  opacity 0.5s,
  z-index 0s;
  pointer-events: none;
}
.carousel-card.active {
  transform: translate(-50%, -50%) scale(1) rotateY(0deg);
  opacity: 1;
  z-index: 3;
  pointer-events: auto;
}
.carousel-card.left {
  transform: translate(-120%, -50%) scale(0.8) rotateY(25deg);
  opacity: 0.6;
  z-index: 2;
}
.carousel-card.right {
  transform: translate(20%, -50%) scale(0.8) rotateY(-25deg);
  opacity: 0.6;
  z-index: 2;
}
.ResponseCard {
  width: 100%;
  padding: 70px 40px;
  text-align: center;
  color: #bebebe;
  background-color: #1e1e1e;
  border: 1px solid #2c2c2c;
  border-radius: 16px;
  box-shadow: 0 4px 24px #000a;
  display: flex;
  flex-direction: column;
  justify-content: center;
  transition: transform 0.3s ease-in-out, box-shadow 0.3s;
}
.ResponseCard:hover {
  cursor: pointer;
  box-shadow: 0 10px 20px rgba(0, 184, 255, 0.2);
  transform: scale(1.02);
}
.ResponseCardEmail {
  font-size: 1.4rem;
  margin-bottom: 18px;
  color: #00b8ff;
  font-weight: bold;
  word-break: break-all;
}
.ResponseCardDate {
  font-size: 1.1rem;
}
.ResponseCardDate p {
  font-size: 1rem;
  margin-top: 15px;
  font-weight: bold;
  color: #fff;
  opacity: 0.8;
}
.carousel-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  color: #00b8ff;
  font-size: 2.5rem;
  font-weight: bold;
  z-index: 10;
  cursor: pointer;
  user-select: none;
  transition: color 0.2s, transform 0.2s;
  padding: 0 18px;
  line-height: 1;
}
.carousel-arrow.left { left: 0; }
.carousel-arrow.right { right: 0; }
.carousel-arrow:hover { color: #00e0ff; transform: scale(1.18) translateY(-50%); }
.carousel-dots {
  position: absolute;
  bottom: 0px;
  left: 0; right: 0;
  display: flex;
  justify-content: center;
  gap: 12px;
  z-index: 20;
}
.carousel-dots span {
  display: inline-block;
  width: 10px; height: 10px;
  border-radius: 50%;
  background: #444;
  cursor: pointer;
  transition: background 0.2s, transform 0.2s;
}
.carousel-dots span.active {
  background: #00b8ff;
  transform: scale(1.2);
}
</style>
