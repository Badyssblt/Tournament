<template>
  <header-component/>
  <div class="tournament-container">
    <bracket-component :data="matches" v-if="matches && matches.length > 0"/>
  </div>
</template>

<script>
import axios from "axios";
import HeaderComponent from '../components/HeaderComponent.vue';
import _const from "@/const.js";
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import BracketComponent from '../components/Bracket/BracketComponent.vue';


export default {
    name: "TournamentPage",
    components: {
        HeaderComponent,
        BracketComponent,
    },
    setup(){
        const id = ref(0);
        const route = useRoute();
        const token = localStorage.getItem('token');
        const matches = ref([]);
        onMounted(async () => {
            id.value = route.params.id;
            await getData();
        });
        const getData = async () => {
            try {
                const res = await axios({
                    url: _const.axios + "/tournaments/" + id.value,
                    headers: {
                        'Content-Type': _const.content,
                        'Authorization': 'Bearer ' + token
                    }
                });
                sortData(res.data);
            } catch (error) {
                console.error(error);
            }
        }

        const sortData = (tournamentData) => {
            const data = tournamentData.matche;
            const _matches = [];
            data.forEach(match => {
                _matches.push(match);
            });

            _matches.sort((a, b) => {
                return a.round - b.round;
            });

            matches.value = _matches;
        }


        return {
            matches
        }
    }
}
</script>

<style scoped>
    .tournament-container {
        grid-row: 2;
        grid-column: 2 / 12;
    }
</style>