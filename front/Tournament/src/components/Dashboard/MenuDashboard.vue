<template>
  <div class="dashboard-menu__container">
    <div class="dashboard-aside">
        <aside>
            <div class="dashboard-menu__item">
                <button @click="showMenu('teams')">Mon équipe</button>
            </div>
            <div class="dashboard-menu__item">
                <button @click="showMenu('tournaments')">Mes tournois</button>
            </div>
            <div class="dashboard-menu__item">
                <button @click="showMenu('signup')">Mes inscriptions</button>
            </div>
            <div class="dashboard-menu__item">
                <button @click="logout">Se déconnecter</button>
            </div>
        </aside>
        
    </div>
    <div class="dashboard-content">
        <div class="dashboard-content__item" v-if="activeContent == 'teams'" :key="team">
            <my-teams-component :team="team" @reloadTeam="reloadTeam"/>
            <my-teams-component :team="team" @reloadTeam="reloadTeam"/>
            
        </div>
        <div class="dashboard-content__item" v-if="activeContent == 'tournaments'">
            <my-tournament-component :data="tournaments"/>
            <my-tournament-component :data="tournaments"/>
        </div>
        <div class="dashboard-content__item" v-if="activeContent == 'signup'">
            <registration-component :team="team"/>
        </div>
    </div>
    <aside-right-dashboard v-if="team && Object.keys(team).length > 0" :data="team"  :key="team"/>
    <aside-right-dashboard v-if="team && Object.keys(team).length > 0" :data="team"  :key="team"/>
    
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import axios from "axios";
import _const from "@/const.js";
import AsideRightDashboard from './AsideRightDashboard.vue';
import { useRouter } from 'vue-router';
import MyTournamentComponent from './Tournament/MyTournamentComponent.vue';
import MyTeamsComponent from './Teams/MyTeamsComponent.vue';
import { jwtDecode } from 'jwt-decode';
import RegistrationComponent from './Registration/RegistrationComponent.vue';

export default {
  components: { AsideRightDashboard, MyTournamentComponent, MyTeamsComponent, RegistrationComponent },
    name: "MenuDashboard",
    setup(context){
        const activeContent = ref('');
        const token = localStorage.getItem('token');
        const team = ref({});
        const findUserMessage = ref('');
        const name = ref('');
        const router = useRouter();
        const tournaments = ref([]);
        const isAdmin = ref(false);

        const tournaments = ref([]);
        const isAdmin = ref(false);


        const showMenu = (content) => {
            activeContent.value = content;
        }



        const getTeam = async () => {
            try {
                const res = await axios({
                    url: _const.axios + "/team/myteam",
                    headers: {
                        'Content-Type': _const.content,
                        'Authorization': 'Bearer ' + token
                    }
                });
                team.value = res.data;
            } catch (error) {
                console.error(error);
            }
        }

        const getTournament = async () => {
        const getTournament = async () => {
            try {
                const res = await axios.get(_const.axios + '/tournament/myTournament', {
                const res = await axios.get(_const.axios + '/tournament/myTournament', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.content
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.content
                    }
                });
                tournaments.value = res.data['hydra:member'];
                tournaments.value = res.data['hydra:member'];
            } catch (error) {
                
                
            }
        }

        

        

        const createTeam = async () => {
            try {
                const res = await axios({
                    method: 'post',
                    url: _const.axios + '/teams',
                    data: {
                        name: name.value,
                        user: []
                    },
                    headers: {
                        'Content-Type': _const.content,
                        'Authorization': 'Bearer ' + token
            }
            });
            if(res.data.name){
                message.value = '';
                message.value = "L'équipe a été créer !";
                name.value = '';
            }
            } catch (error) {
                console.error(error);
            }
        }


        const reloadTeam = async () => {
            await getTeam();
        }


        const reloadTeam = async () => {
            await getTeam();
        }
        const logout = () => {
            if(token){
                localStorage.setItem('token', '');
                router.push('/');
            }
        }

        onMounted(async () => {
            await getTeam();
            await getTournament();
            
            await getTournament();
            
        })

        

        return {
            activeContent,
            showMenu,
            team,
            findUserMessage,
            createTeam,
            name,
            logout,
            tournaments,
            isAdmin,
            reloadTeam
            logout,
            tournaments,
            isAdmin,
            reloadTeam
        }
    }
}
</script>

<style scoped>
    .dashboard-menu__container {
        display: flex;
        flex-direction: row;
        gap: 30px;
    }

    .dashboard-content {
        width: 80%;
    }

    .dashboard-content {
        width: 80%;
    }

    p {
        color: var(--text-color);
    }

    aside {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

        form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        grid-row: 2;
        grid-column: 6 / 9 ;
        background: #1A0B0B;
        padding: 20px;
        border-radius: 20px;
    }

    .dashboard-menu__item button {
        background: var(--secondary-color);
        color: var(--background-color);
        color: var(--background-color);
        font-family: var(--font-family);
        border: 2px solid transparent;
        border: 2px solid transparent;
        outline: none;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: .9em;
        width: 150px;
        text-align: start;
        transition: all .2s ease;
        cursor: pointer;
    }
        transition: all .2s ease;
        cursor: pointer;
    }

    .dashboard-menu__item button:hover {
        background: none;
        color: var(--secondary-color);
        border: 2px solid var(--primary-color);
    .dashboard-menu__item button:hover {
        background: none;
        color: var(--secondary-color);
        border: 2px solid var(--primary-color);
    }
    .title {
        font-weight: bold;
        color: var(--secondary-color);
        font-size: 1.3em;
    }

    .primary-button {
        background: var(--primary-color);
        color: var(--background-color);
        padding: 5px 15px;
        border-radius: 20px;
        border: 2px solid transparent;
        transition: all .2s ease;
        width: fit-content;
    }

    .primary-button:hover {
        background: none;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .primary-button {
        background: var(--primary-color);
        color: var(--background-color);
        padding: 5px 15px;
        border-radius: 20px;
        border: 2px solid transparent;
        transition: all .2s ease;
        width: fit-content;
    }

    .primary-button:hover {
        background: none;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    form button{
        color: var(--text-color);
        font-family: var(--font-family);
        width: fit-content;
        border: none;
        outline: none;
        padding: 5px 15px;
        border-radius: 20px;
        background: var(--secondary-color);
    }

    .message {
        color: var(--text-color );
    }

    label {
        color: var(--text-color);
    }

    input {
        background: var(--primary-color);
        border: none;
        outline: none;
        padding: 5px;
        border-radius: 10px;
        font-family: var(--font-family);
    }

    .form-input {
        display: flex;
        flex-direction: column;
    }

    .submit {
        background: var(--secondary-color);
        color: var(--text-color);
        outline: none;
        padding: 5px 10px;
        outline: none;
        border: none;
        border-radius: 20px;
        font-family: var(--font-family);
        cursor: pointer;
    }

    




    




</style>