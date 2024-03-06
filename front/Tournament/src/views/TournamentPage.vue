<template>
  <header-component/>
  <div class="admin-container" v-if="adminShowed">
        <button @click="toggleTeamForm()" id="admin-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#757de8" d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg></button>
      <add-team-form-component v-show="teamForm" :teams="data.Team" @reloadTeams="handleReloadTeams" />

  </div>
  <div class="tournament-container">
    <bracket-component :data="matches" v-if="matches && matches.length > 0" :adminShowed="adminShowed" @reload-teams="handleReloadTeams" :key="matches"/>
  </div>
</template>

<script>
import axios from "axios";
import HeaderComponent from '../components/HeaderComponent.vue';
import _const from "@/const.js";
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import BracketComponent from '../components/Bracket/BracketComponent.vue';
import AddTeamFormComponent from '../components/Bracket/AdminPanel/Form/AddTeamFormComponent.vue';
import { jwtDecode } from "jwt-decode";

export default {
    name: "TournamentPage",
    components: {
        HeaderComponent,
        BracketComponent,
        AddTeamFormComponent,
    },
    title: "Tournoi",
    setup(){
        const id = ref(0);
        const route = useRoute();
        const token = localStorage.getItem('token');
        const matches = ref([]);
        const teamForm = ref(false);
        const adminShowed = ref(false);
        const data = ref([]);


        onMounted(async () => {
            id.value = route.params.id;
            await getData();
        });

        const showAdmin = (data) => {
            const decoded = jwtDecode(token);
            if(decoded.email === data.email){
                adminShowed.value = true;
            }else {
                adminShowed.value = false;
            }
        }
        const getData = async () => {
            try {
                const res = await axios({
                    url: _const.axios + "/tournaments/" + id.value,
                    headers: {
                        'Content-Type': _const.content,
                        'Authorization': 'Bearer ' + token
                    }
                });
                data.value = res.data;
                console.log(data.value);
                sortData(res.data);
                showAdmin(res.data.CreatorTournament);
            } catch (error) {
                console.error(error);
            }
        }

        const handleReloadTeams = async () => {
            await getData();
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


        const toggleTeamForm = () => {
            if(teamForm.value){
                teamForm.value = false;
            }else {
                teamForm.value = true;
            }
            
            
        }


        return {
            matches,
            teamForm,
            toggleTeamForm,
            adminShowed,
            data,
            handleReloadTeams
        }
    }
}
</script>

<style scoped>
    .tournament-container {
        grid-row: 2;
        grid-column: 2 / 12;
        margin-top: 140px;
    }

    .admin-container {
        background: var(--form-color);
        padding: 20px;
        border-radius: 20px;
        grid-row: 2;
        grid-column: 2 / 12;
        z-index: 3;
        height: fit-content;
        width: fit-content;
        z-index: 20;
        width: 100%;
    }

    #admin-button {
        width: 40px;
        height: 40px;
        background: none;
        border: none;
        cursor: pointer;
    }

    #admin-button svg {
        transition: all .3s ease;
    }
    #admin-button:hover svg {
        opacity: .8;
    }

    svg {
        width: 100%;
        height: 100%;
    }
</style>