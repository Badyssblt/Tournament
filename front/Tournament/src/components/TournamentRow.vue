<template>
    <div class="tournamentRow-container">
        <p>{{ category }}</p>
        <template v-for="(tournamentData, index) in data" :key="index">
            <tournament-card-component :datas="tournamentData"/>
        </template>
    </div>
  
</template>

<script>
import { onMounted, ref } from 'vue';
import TournamentCardComponent from './TournamentCardComponent.vue'
import axios from 'axios';
export default {
  components: { TournamentCardComponent },
    name: "TournamentRow",
    props: {
        category: {
            type: String,
            required: true
        }
    },
    setup(props){
        const data = ref([]);
        const category = ref(props.category);
        const getData = async () => {
            try {
                const res = await axios.get('http://localhost:8080/api/tournaments',
                    {
                        headers: {
                            "Content-Type": "application/ld+json"
                        }
                    });
                data.value = res.data['hydra:member'];
            }catch(error){
                console.error('Erreur');
                throw error;
            }
           

        }
        onMounted(async () => {
            await getData();
        })

        return {
            data,
            category
        }
    }
}
</script>

<style scoped>
    .tournamentRow-container {
        grid-row: 3;
        grid-column: 2 / 12;
        display: flex;
        flex-direction: row;
        gap: 40px;
        justify-content: center;
        margin-top: 90px;
    }
</style>