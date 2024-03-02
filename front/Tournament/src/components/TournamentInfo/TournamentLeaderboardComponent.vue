<template>
  <div>
    <h2>Gagnant du tournoi : </h2>
    <p v-if="data.hasOwnProperty('winnerTournament')">{{ data.winnerTournament.name}}</p>
    <p v-else>Aucun gagnant pour le moment</p>
  </div>
</template>

<script>
export default {
    name: 'TournamentLeaderboardComponent',
    props: {
        data: {
            type: Object,
            required: true
        }
    },
    setup(props){
        const data = props.data;
        return {
            data
        }
    }
}
</script>

<style scoped>
    h2 {
        font-weight: bold;
        font-size: 18px;
    }

</style>