<script setup>
import {computed, ref} from 'vue';

const SelectedGender = ref('');
const SelectedNumber =ref(0);
const RadioNumber = ref(0);
const openModal = ref(false);

const SelectGender = (GenderValue) => {
  SelectedGender.value = GenderValue
};

const SelectNumber = (NumberValue) => {
  SelectedNumber.value = NumberValue;
  for ( let i = 1 ; i <=  5 ; i++ ) {
    if ( i === SelectedNumber.value ){
      RadioNumber.value = i;
    }
  }
};

const SurveySubmitted = (e) => {
  e.preventDefault();
};


</script>

<template>
  <form v-on:submit="SurveySubmitted">

    <section class="LogoContainer">
      <figure>
        <img src="" alt="">
      </figure>
      <div class="LogoContainerSpanDiv">
        <span>Merci de répondre à toutes les questions et de valider le formulaire en bas de page.</span>
      </div>
    </section>

    <section class="QuestionContainer">

      <article class="QuestionAnswer">
        <div class="QuestionNumber">Question 1/20</div>
        <div class="QuestionBody">Votre adresse mail</div>
        <input type="email" placeholder="Votre réponse ici..." required>
        <hr>
      </article>

      <article class="QuestionAnswer">
        <div class="QuestionNumber">Question 2/20</div>
        <div class="QuestionBody">Votre âge</div>
        <input type="text" placeholder="Votre réponse ici..." required>
        <hr>
      </article>

      <article class="QuestionAnswer">
        <div class="QuestionNumber">Question 3/20</div>
        <div class="QuestionBody">Votre sexe</div>
        <div class="QuestionRadioGroup">
          <div class="QuestionRadioOption" @click="SelectGender('Homme')" >
          <input
          type="radio"
          name="gender"
          value="Homme"
          required
          :checked="SelectedGender === 'Homme'"
          >
          <span>Homme</span>
          </div>
          <div class="QuestionRadioOption" @click="SelectGender('Femme')">
            <input
              type="radio"
              name="gender"
              value="Femme"
              required
              :checked="SelectedGender === 'Femme'"
            >
            <span>Femme</span>
          </div>
          <div class="QuestionRadioOption" @click="SelectGender('Préfère ne pas répondre')">
            <input
              type="radio"
              name="gender"
              value="Préfère ne pas répondre"
              required
              :checked="SelectedGender === 'Préfère ne pas répondre'"
            >
            <span>Préfère ne pas répondre</span>
          </div>
          <!-- <p>{{ SelectedGender }}</p> -->
        </div>
        <hr>
      </article>

      <article class="QuestionAnswer">
        <div class="QuestionNumber">Question 4/20</div>
        <div class="QuestionBody">Nombre de personne dans votre foyer (adulte & enfants)</div>
        <div class="QuestionRadioGroupSelect">
          <div class="QuestionRadioSelect">
          <input
          type="radio"
          name="number1"
          value=1
          :checked="RadioNumber >= 1"
          >
          <span
            @click="SelectNumber(1)"
            ></span>
            <input
              type="radio"
              name="number2"
              value=2
              :checked="RadioNumber >= 2"
            >
            <span
              @click="SelectNumber(2)"
            ></span>
            <input
              type="radio"
              name="number3"
              value=3
              :checked="RadioNumber >= 3"
            >
            <span
              @click="SelectNumber(3)"
            ></span>
            <input
              type="radio"
              name="number4"
              value=4
              :checked="RadioNumber >= 4"
            >
            <span
              @click="SelectNumber(4)"
            ></span>
            <input
              type="radio"
              name="number5"
              value=5
              :checked="RadioNumber >= 5"
            >
            <span
              @click="SelectNumber(5)"
            ></span>
          </div>
          <p>{{ RadioNumber }}</p>
        </div>
        <hr>
      </article>

    </section>

    <section class="SubmitButtonSection">
      <button type="submit" @click="openModal = true">Finaliser</button>
    </section>

    <section>
      <div v-if="openModal" class="modal-overlay">
        <div class="modal-content">
          <h1>Merci pour votre engagement !</h1>
          <p>
            Toute l’équipe de Bigscreen vous remercie. Grâce à votre investissement, nous vous préparons une application toujours plus facile à utiliser,
             seul ou en famille.
             <br>
             <br>
              Si vous désirez consulter vos réponse ultérieurement, voici votre lien unique :
          </p>
          <button @click="openModal = false"><router-link to="/answer" class="router-link">http://example.com/answers/s-mcfghuiii08xr4qil4p</router-link></button>
        </div>
      </div>
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

  .QuestionAnswer input[type = 'text'],
  .QuestionAnswer input[type = 'email'] {
    width: 97%;
    padding: 12px 15px;
    margin: 25px 0px;
    background-color: #121212;
    border: 1px solid #2c2c2c;
    border-radius: 6px;
    color: #ffffff;
    font-size: 1rem;
    border-style: dotted;
    border-width: 2px;
    border-color: #00b8ff
  }

  .QuestionAnswer input[type = 'text']:focus,
  .QuestionAnswer input[type = 'email']:focus {
    outline: none;
    border-style:double;
    border-color: #00b8ff;
    transition: border-color 0.4s;
  }

  .QuestionRadioGroup {
    /*border: 1px solid white;*/
    margin: 25px 0px;
  }

  .QuestionRadioOption,
  .QuestionRadioSelect {
    margin: 25px 0px;
    padding: 12px 0px 12px 10px;
    border-radius: 6px;
    font-size: 1.1rem;
    color: #ffffff;
    border-style: dotted;
    border-width: 2px;
    border-color: #00b8ff
  }

  .QuestionRadioOption:hover {
    background-color: #2c2c2c;
    transition: 0.3s;
    cursor: pointer;
  }

  .QuestionRadioOption:first-of-type {
    margin-top: 0px;
  }

  .QuestionRadioOption:last-of-type {
    margin-bottom: 0px;
  }

  .QuestionRadioOption input[type = 'radio'],
  .QuestionRadioSelect input[type = 'radio'] {
    position: absolute;
    display: none;
    opacity: 0;
    width: 0;
    height:0;
  }

  .QuestionRadioOption span,
  .QuestionRadioSelect span {
    position: relative;
    padding-left: 35px;
    display: inline-block;
    line-height: 25px;
    transition: background-color 0.3s;
  }

  .QuestionRadioSelect span {
    margin-bottom: 20px;
    cursor: pointer;
  }

  .QuestionRadioOption span::before,
  .QuestionRadioSelect span::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 20px;
    border: 2px solid #00b8ff;
    border-radius: 50%;
    transition: border-color 0.3s ease;
  }
  .QuestionRadioSelect span::before {
    border: 2px solid #2c2c2c;
    background-color: #2c2c2c;
  }

  .QuestionRadioOption span::after,
  .QuestionRadioSelect span::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 6px;
    width: 12px;
    height: 12px;
    background-color: #00b8ff;
    border-radius:50%;
    transform: scale(0);
    transition: transform 0.4s;
  }

  .QuestionRadioSelect span::after {
    left: 0;
    top: 0;
    width: 23px;
    height: 23px;
    background-color: red;
  }

  .QuestionRadioOption input[type = 'radio']:checked + span::after,
  .QuestionRadioSelect input[type = 'radio']:checked + span::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 6px;
    width: 12px;
    height: 12px;
    background-color: #00b8ff;
    border-radius:50%;
    transform: scale(1);
    transition:transform 0.4s;
  }

  .QuestionRadioSelect input[type = 'radio']:checked + span::after {
    left: 0;
    top: 0;
    width: 23px;
    height: 23px;
  }

  .QuestionRadioGroupSelect {
    display: flex;
    align-items: center;
  }

  .QuestionRadioGroupSelect p {
    display: inline-flex;
    /*border: 1px solid white;*/
    height: auto;
    margin: 0px 0px 0px 20px;
    color: #00b8ff;
    font-family: 'Times New Roman', Times, serif;
    font-size: 2rem;
  }

  /*Pour le bloc du bouton*/
  .SubmitButtonSection {
    /*border: 1px solid white;*/
    width: 100%;
    height: auto;
    margin-top: 30px;
  }

  .SubmitButtonSection button {
    background-color: #00b8ff;
    color: #121212;
    border: none;
    border-radius: 8px;
    width: 30%;
    margin-left: 70%;
    padding: 10px 0px;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
  }

  /*Pour le teleport, modal*/
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .modal-content {
    background-color: #1e1e1e;
    padding: 50px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0, 0.1);
    border: 1px solid #00b8ff;
    max-width: 500px;
    width: 90%;
    text-align: center;
    color: #ffffff;

  }

  .modal-content h1 {
    margin-bottom: 40px;
    color: #00b8ff;
  }

  .modal-content button {
    background: none;
    border: none;
    margin-top: 20px;
    font-size: 1.2rem;
    color: #00b8ff;
    cursor: pointer;
  }

  .router-link{
    color: #00b8ff;
  }
</style>
