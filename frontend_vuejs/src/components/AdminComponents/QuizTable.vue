<script setup>
import axios from '@/utilities/axios.js'
import { ref, onMounted } from 'vue';
import { getAccessToken } from '@/utilities/utils';

const Questions = ref([]);
const errorMessage = ref('');

const fetchQuestions = async () => {
  try {
    errorMessage.value = '';
    const response = await axios.get('/admin/survey/questions', {
      headers: { Authorization: 'Bearer ' + getAccessToken() }
    });
    Questions.value = response.data.data;
    //console.log(Questions.value);
  }catch(e){
    console.error('Erreur lors de la récupération des questions: ', e);
    errorMessage.value = 'Erreur lors de la récupération des questions:';
    alert(errorMessage.value);
  }
}

onMounted(fetchQuestions);
</script>

<template>
<table>
  <thead>
    <tr>
      <td>N°</td>
      <td>Corps de la question</td>
      <td>Type</td>
    </tr>
  </thead>
  <tbody v-if="Questions">
    <tr v-for="Q in Questions" :key="Q.id">
      <td> {{ Q.id }} </td>
      <td> {{ Q.body }} </td>
      <td> {{ Q.type }} </td>
    </tr>
  </tbody>
</table>
</template>


<style scoped>
table {
  width: 100%;
  /*border: 1px solid white;*/
  margin-top: 20px;
  color: #b3b3b3;
  border-collapse: collapse;
}

thead {
  color: #00b8ff;
  border: 1px solid #2c2c2c;
}

thead td,tbody td {
  padding: 15px;
  background: #2c2c2c;
  font-weight: 700;
  font-size: 1.2rem;
}

tbody td {
  background: #1e1e1e;
  border-bottom: 1px solid #2c2c2c;
  font-weight: 500;
}

/*tbody td:nth-child(2) {
  background: #2c2c2c;
}*/
</style>

