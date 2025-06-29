<script setup>
import {computed, ref} from 'vue';


</script>

<template>
  <form v-on:submit="SurveySubmitted">

    <section class="LogoContainer">
      <figure>
        <img src="" alt="">
      </figure>
      <div class="LogoContainerSpanDiv">
        <span>Nous vous remercions d'avoir eu à répondre à ce formulaire. Voici vos réponses.</span>
      </div>
    </section>

    <section class="QuestionContainer">

      <article class="QuestionAnswer">
        <div class="QuestionNumber">Question 1/20</div>
        <div class="QuestionBody">Votre adresse mail</div>
        <input type="text" value="a@gmail.com" disabled>
        <hr>
      </article>

      <article class="QuestionAnswer">
        <div class="QuestionNumber">Question 2/20</div>
        <div class="QuestionBody">Votre âge</div>
        <input type="text" value="12" disabled>
        <hr>
      </article>

      <article class="QuestionAnswer">
        <div class="QuestionNumber">Question 3/20</div>
        <div class="QuestionBody">Votre sexe</div>
        <input type="text" value="Homme" disabled>
        <hr>
      </article>

      <article class="QuestionAnswer">
        <div class="QuestionNumber">Question 4/20</div>
        <div class="QuestionBody">Nombre de personne dans votre foyer (adulte & enfants)</div>
        <input type="text" value="5" disabled>
        <hr>
      </article>

    </section>
  </form>
</template>

<style scoped>
  form {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 70%;
    height: auto;
    background-color: #1e1e1e;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  }

  /*Pour le bloc logo*/
  .LogoContainer {
    /*border: 1px solid white;*/
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    width: 80%;
    height: 280px;
    text-align: center;
  }

  .LogoContainer figure {
    border: 1px solid green;
    width: 35%;
    height: 80%;
  }

  .LogoContainerSpanDiv {
    color: #b3b3b3;
    font-size: 1rem;
  }

  /*Pour le bloc des questions*/
  .QuestionContainer {
    /*border: 1px solid white;*/
    width: 98%;
    display: flex;
    flex-direction: column;
    height: auto;
    margin: 30px 0px ;
  }

  .QuestionContainer hr {
    border: 1px solid #2c2c2c;
  }

  .QuestionAnswer {
    width: 100%;
    height: auto;
    font-size: 1.1rem;
    margin: 20px 0px ;
  }

  .QuestionNumber {
    color: #00b8ff;
    font-weight: 700;
  }

  .QuestionBody {
    color: #ffffff;
    font-weight: 500;
  }

  .QuestionAnswer input[type = 'text'] {
    width: 97%;
    padding: 12px 15px;
    margin: 40px 0px;
    background-color: #121212;
    border: 1px solid #2c2c2c;
    border-radius: 6px;
    color: #ffffff;
    font-size: 1rem;
    border-style: dotted;
    border-width: 2px;
    border-color: #00b8ff;
  }
</style>
