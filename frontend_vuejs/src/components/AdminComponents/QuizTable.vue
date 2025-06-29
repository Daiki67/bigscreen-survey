<script setup>

</script>

<template>
<table>
  <thead>
    <td>N°</td>
    <td>Corps de la question</td>
    <td>Type</td>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>Votre adresse mail</td>
      <td>B</td>
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
</style>

