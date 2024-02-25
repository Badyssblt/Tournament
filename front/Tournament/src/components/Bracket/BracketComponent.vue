<template>
  <div class="bracket-container">
    <template v-for="(matchesInRound, roundNumber) in groupMatchesByRound(matches)">
      <template v-for="(match, index) in matchesInRound" :key="index">
        <div class="bracket-team__wrapper"
             :ref="`match-${roundNumber}-${index}`"
             :class="[
               'round-' + roundNumber + '-' + (index + 1),
               'round-' + roundNumber,
               {'even': (index + 1) % 2 == 0 && roundNumber == 1, 'odd': (index + 1) % 2 !== 0 && roundNumber == 1},
               {'last': index === matchesInRound.length - 1} // Ajoute la classe 'last' si c'est le dernier élément
             ]">
             <button @click="showWinnerForm(index, roundNumber)" class="edit" v-if="adminShowed">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#3f51b5" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
             </button>
             <div class="winner-form" v-if="isWinnerFormVisible(index, roundNumber)">
                <set-winner-component :teams="match" @reloadTeams="handleReloadTeams"/>
             </div>
          <bracket-team-component :data="match" v-if="matches && matches.length > 0" />
        </div>
      </template>
    </template>
  </div>
</template>





<script>
import { ref, onMounted } from 'vue';
import BracketTeamComponent from './BracketTeamComponent.vue';
import SetWinnerComponent from './AdminPanel/Form/SetWinnerComponent.vue';

export default {
  components: { BracketTeamComponent, SetWinnerComponent },
  name: "BracketContainer",
  props : {
    data: {
      type: Object,
      required: true
    },
    adminShowed: {
      required: true,
      type: Boolean
    }
  },
  methods: {
        handleReloadTeams(){
            this.$emit('reload-teams');
        }
  },
  setup(props){
    const matches = props.data;
    const token = localStorage.getItem('token');
    const adminShowed = ref(false);
    onMounted(() => {
      adminShowed.value = props.adminShowed;
    });
    

    const groupMatchesByRound = (matches) => {
      const groupedMatches = {};

      matches.forEach(match => {
        const round = match.round;
        if (!groupedMatches[round]) {
          groupedMatches[round] = [];
        }
        groupedMatches[round].push(match);
      });
      return groupedMatches;
    };

    const currentWinnerFormIndex = ref(null);

   const showWinnerForm = (index, roundNumber) => {
      if (currentWinnerFormIndex.value && 
          currentWinnerFormIndex.value.index === index &&
          currentWinnerFormIndex.value.roundNumber === roundNumber) {
        currentWinnerFormIndex.value = null;
      } else {
        currentWinnerFormIndex.value = { index, roundNumber };
      }
    };

    const isWinnerFormVisible = (index, roundNumber) => {
      return currentWinnerFormIndex.value && 
             currentWinnerFormIndex.value.index === index &&
             currentWinnerFormIndex.value.roundNumber === roundNumber;
    };

    return {
      matches,
      groupMatchesByRound,
      adminShowed,
      currentWinnerFormIndex,
      isWinnerFormVisible,
      showWinnerForm
    };
  }
}
</script>

<style scoped>
.bracket-container {
  display: grid;
  grid-template-columns: repeat(3, minmax(160px, 1fr));
  grid-template-rows: repeat(16, 1fr);
  gap: 20px;
}

.round {
  width: 100%;
  display: grid;
  grid-auto-rows: auto;
  gap: 40px;
  position: relative;
}

.last::after {
  position: absolute;
  content: "";
  width: 0px !important;
  height: 0px !important;

}

.round-1 {
  position: relative;
  grid-column: 1;
}

  .round-1:nth-child(1){
    grid-row: 1;
  }

  .round-1:nth-child(2){
    grid-row: 3;
  }

  .round-1:nth-child(3){
    grid-row: 5;
  }

  .round-1:nth-child(4){
    grid-row: 7;
  }

  .round-1:nth-child(5){
    grid-row: 9;
  }
  
  .round-1:nth-child(6){
    grid-row: 11;
  }

  .round-1:nth-child(7){
    grid-row: 13;
  }

  .round-1:nth-child(8){
    grid-row: 15;
  }

  .round-1:nth-child(9){
    grid-row: 17;
  }

  .round-1:nth-child(10){
    grid-row: 19;
  }

  .round-1:nth-child(11){
    grid-row: 21;
  }

  .round-1:nth-child(12){
    grid-row: 23;
  }

  .round-1:nth-child(13){
    grid-row: 25;
  }

  .round-1:nth-child(14){
    grid-row: 28;
  }

  .round-1:nth-child(15){
    grid-row: 30;
  }

  .round-1:nth-child(16){
    grid-row: 32;
  }

  .round-2 {
    grid-column: 2;
  }

  .round-2-1 {
    grid-row: 2;
  }

  .round-2-2 {
    grid-row: 6;
  }

  .round-2-3 {
    grid-row: 10;
  }

  .round-2-4 {
    grid-row: 14;
  }

  .round-2-5 {
    grid-row: 18;
  }

  .round-3-1 {
    grid-row: 4;
  }

  .round-3-2 {
    grid-row: 12;
  }

  .round-3-3 {
    grid-row: 12;
  }

.round-3 {
  grid-column: 3;
}

  .round-3:nth-child(11){
    background: red;
  }

  .bracket-team__wrapper {
    width: fit-content;
  }

  .odd::after {
    position: absolute;
    content: "";
    width: 30%;
    height: 2px;
    right: -40px;
    top: 50%;
    bottom: 50%;
    background: var(--primary-color);
  }

  .odd::before {
    position: absolute;
    content: "";
    width: 50%;
    height: 2px;
    transform: rotate(90deg);
    right: -50%;
    bottom: -10px;
    background: var(--primary-color);
  }

  .even::after {
    position: absolute;
    content: "";
    width: 30%;
    height: 2px;
    right: -40px;
    top: 50%;
    bottom: 50%;
    background: var(--primary-color);
  }

  .even::before {
    position: absolute;
    content: "";
    width: 60%;
    height: 2px;
    transform: rotate(90deg);
    right: -55%;
    top: -15px;
    background: var(--primary-color);
  }

  .round-2 {
    position: relative;
  }

  .round-2::before {
    position: absolute;
    content: "";
    width: 145%;
    height: 2px;
    left: -143%;
    top: 50%;
    bottom: 50%;
    background: var(--primary-color);
  }

.round-2:nth-child(odd)::after {
    position: absolute;
    content: "";
    width: 30px;
    right: -20px;
    top: 50%;
    bottom: 50%;
    border-top: 2px solid var(--primary-color);
    border-right: 2px solid var(--primary-color);
    border-bottom: 2px solid var(--primary-color);
    height: 341px;
}

.round-3 {
  position: relative;
}

.round-3::before {
  position: absolute;
  content: "";
  width: 160%;
  height: 2px;
  left: -156%;
  top: 50%;
  bottom: 50%;
  background: var(--primary-color);
}

.edit {
  width: 20px;
  height: 20px;
  padding: 0;
  background: none;
  border: none;
  position: absolute;
  z-index: 5;
  right: -30px;
  top: -20px;
}

.edit svg {
  width: 100%;
  height: 100%;
}

.winner-form {
  position: absolute;
  padding: 10px;
  z-index: 10;
  width: fit-content;
  border-radius: 5px;
  background: var(--form-color);
  box-shadow: rgba(0, 0, 0, 0.06) 0px 2px 4px 0px inset;
}
</style>