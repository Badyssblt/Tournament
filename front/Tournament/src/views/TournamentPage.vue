<template>
  <header-component/>
  <div class="admin-container" v-if="adminShowed">
        <button @click="toggleTeamForm()" id="admin-button"><svg fill="#D72D38" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.973 45.973" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M43.454,18.443h-2.437c-0.453-1.766-1.16-3.42-2.082-4.933l1.752-1.756c0.473-0.473,0.733-1.104,0.733-1.774 c0-0.669-0.262-1.301-0.733-1.773l-2.92-2.917c-0.947-0.948-2.602-0.947-3.545-0.001l-1.826,1.815 C30.9,6.232,29.296,5.56,27.529,5.128V2.52c0-1.383-1.105-2.52-2.488-2.52h-4.128c-1.383,0-2.471,1.137-2.471,2.52v2.607 c-1.766,0.431-3.38,1.104-4.878,1.977l-1.825-1.815c-0.946-0.948-2.602-0.947-3.551-0.001L5.27,8.205 C4.802,8.672,4.535,9.318,4.535,9.978c0,0.669,0.259,1.299,0.733,1.772l1.752,1.76c-0.921,1.513-1.629,3.167-2.081,4.933H2.501 C1.117,18.443,0,19.555,0,20.935v4.125c0,1.384,1.117,2.471,2.501,2.471h2.438c0.452,1.766,1.159,3.43,2.079,4.943l-1.752,1.763 c-0.474,0.473-0.734,1.106-0.734,1.776s0.261,1.303,0.734,1.776l2.92,2.919c0.474,0.473,1.103,0.733,1.772,0.733 s1.299-0.261,1.773-0.733l1.833-1.816c1.498,0.873,3.112,1.545,4.878,1.978v2.604c0,1.383,1.088,2.498,2.471,2.498h4.128 c1.383,0,2.488-1.115,2.488-2.498v-2.605c1.767-0.432,3.371-1.104,4.869-1.977l1.817,1.812c0.474,0.475,1.104,0.735,1.775,0.735 c0.67,0,1.301-0.261,1.774-0.733l2.92-2.917c0.473-0.472,0.732-1.103,0.734-1.772c0-0.67-0.262-1.299-0.734-1.773l-1.75-1.77 c0.92-1.514,1.627-3.179,2.08-4.943h2.438c1.383,0,2.52-1.087,2.52-2.471v-4.125C45.973,19.555,44.837,18.443,43.454,18.443z M22.976,30.85c-4.378,0-7.928-3.517-7.928-7.852c0-4.338,3.55-7.85,7.928-7.85c4.379,0,7.931,3.512,7.931,7.85 C30.906,27.334,27.355,30.85,22.976,30.85z"></path> </g> </g> </g></svg></button>
      <add-team-form-component v-show="teamForm" :teams="data.Team"/>

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
        margin-top: 90px;
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