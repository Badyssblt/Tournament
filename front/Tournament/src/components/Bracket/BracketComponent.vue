<template>
  <div class="bracket-container">
    <template v-for="(matchesInRound, roundNumber) in groupMatchesByRound(matches)">
      <template v-for="(match, index) in matchesInRound" :key="index">
        <div class="bracket-team__wrapper"
             :ref="`match-${roundNumber}-${index}`"
             :class="[
               'round-' + roundNumber + '-' + (index + 1),
               'round-' + roundNumber,
               {'even': (index + 1) % 2 == 0 && roundNumber == 1, 'odd': (index + 1) % 2 !== 0 && roundNumber == 1}
             ]">
          <bracket-team-component :data="match" v-if="matches && matches.length > 0"/>
        </div>
      </template>
    </template>
  </div>
</template>




<script>
import { ref, onMounted } from 'vue';
import BracketTeamComponent from './BracketTeamComponent.vue';

export default {
  components: { BracketTeamComponent },
  name: "BracketContainer",
  props : {
    data: {
      type: Object,
      required: true
    }
  },
  setup(props){
    const matches = props.data;

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
    

    return {
      matches,
      groupMatchesByRound
    };
  }
}
</script>

<style scoped>
.bracket-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
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
    background: white;
  }

  .odd::before {
    position: absolute;
    content: "";
    width: 50%;
    height: 2px;
    transform: rotate(90deg);
    right: -50%;
    bottom: -10px;
    background: white;
  }

  .even::after {
    position: absolute;
    content: "";
    width: 30%;
    height: 2px;
    right: -40px;
    top: 50%;
    bottom: 50%;
    background: white;
  }

  .even::before {
    position: absolute;
    content: "";
    width: 60%;
    height: 2px;
    transform: rotate(90deg);
    right: -55%;
    top: -15px;
    background: white;
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
    background: white;
  }

.round-2:nth-child(odd)::after {
    position: absolute;
    content: "";
    width: 30px;
    right: -20px;
    top: 50%;
    bottom: 50%;
    border-top: 2px solid white;
    border-right: 2px solid white;
    border-bottom: 2px solid white;
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
  background: white;
}
</style>