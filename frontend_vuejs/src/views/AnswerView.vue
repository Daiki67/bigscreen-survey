<script setup>
import AnswerForm from '@/components/AnswerForm.vue';
const props = defineProps(['token']);
</script>

<template>
<div class="Answerbody">
  <AnswerForm :token="props.token" />
</div>
</template>

<style scoped>

.Answerbody{
  width: 100%;
  height: auto;
  display: flex;
  justify-content: center;
  padding: 40px 0px;
  background-color: #121212;
}

</style>
