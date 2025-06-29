<script setup>

</script>

<script>
const ChartProps = [ 'ChartTitle' ];
const PropsOptions = {};

ChartProps.forEach(PropName => {
  PropsOptions[PropName] = {
    type : String,
    required: true
  }
});

export default {
  props: PropsOptions
}
</script>

<template>
<div class="ChartCard">
  <div class="ChartTitle">
    <h3> {{ ChartTitle }} </h3>
  </div>
  <div class="ChartBlock">

  </div>
</div>
</template>

<style scoped>
.ChartCard {
  border: 1px solid #2c2c2c;
  background-color: #1e1e1e;
  width: 42%;
  padding: 35px 25px;
  margin-top: 50px;
  border-radius: 12px;
}

.ChartCard:hover {
  cursor: pointer;
  transform: translateY(-10px);
  transition: transform 0.4s ease-in-out;
}

.ChartTitle {
  text-align: center;
  color: #b3b3b3;
  /*border: 1px solid #fff;*/
  margin-bottom: 40px;
  font-weight: bold;
}

.ChartBlock {
  border: 1px solid #fff;
  width: 90%;
  height: 330px;
  margin: auto;
  border-radius: 12px;
}
</style>

