<template>
    <div class="tournamentRow-container">
        <p class="category-title">{{ category }}</p>
        <div class="tournamentRow-wrapper">
            <template v-for="(tournamentData, index) in data" :key="index">
                <tournament-card-component :datas="tournamentData"/>
            </template>
        </div>

    </div>
  
</template>

<script>
import { onMounted, ref } from 'vue';
import TournamentCardComponent from './TournamentCardComponent.vue'
import axios from 'axios';
import _const from '@/const.js'
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
                const res = await axios.get(_const.axios + '/tournaments?category=' + category.value,
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
        grid-column: 2 / 12;
        display: flex;
        flex-direction: column;
        gap: 40px;
        justify-content: center;
        margin-top: 90px;
    }

    .tournamentRow-wrapper {
        display: flex;
        flex-direction: row;
        gap: 20px;
    }

    .category-title {
        font-weight: bold;
        font-size: 1.3em;
    }
</style>