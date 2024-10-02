<template>
  <div class="flex justify-between gap-6 w-full">
    <div class="border-r pr-6 min-h-screen w-1/5">
        <aside class="flex flex-col gap-4">
            <div class="dashboard-menu__item">
                <button @click="showMenu('teams')" class="border px-4 py-2 rounded text-nowrap" :class="currentSelect === 'teams' ? 'bg-primary text-white' : 'bg-transparent' ">Mon équipe</button>
            </div>
            <div class="dashboard-menu__item">
                <button @click="showMenu('tournaments')" class="border px-4 py-2 rounded text-nowrap" :class="currentSelect === 'tournaments' ? 'bg-primary text-white' : 'bg-transparent' ">Mes tournois</button>
            </div>
            <div class="dashboard-menu__item">
                <button @click="showMenu('signup')" class="border px-4 py-2 rounded text-nowrap" :class="currentSelect === 'signup' ? 'bg-primary text-white' : 'bg-transparent' ">Mes inscriptions</button>
            </div>
            <div class="dashboard-menu__item">
                <button @click="logout">Se déconnecter</button>
            </div>
        </aside>
        
    </div>
    <div class="flex justify-center w-3/5">
        <div class="dashboard-content__item" v-if="activeContent == 'teams'" :key="team">
            <my-teams-component :team="team" @reloadTeam="reloadTeam"/>
            
        </div>
        <div class="dashboard-content__item" v-if="activeContent == 'tournaments'">
            <my-tournament-component :data="tournaments"/>
        </div>
        <div class="dashboard-content__item" v-if="activeContent == 'signup'">
            <registration-component :team="team"/>
        </div>
    </div>
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
import eventBus from "@/eventBus.js";

export default {
  components: { AsideRightDashboard, MyTournamentComponent, MyTeamsComponent, RegistrationComponent },
    name: "MenuDashboard",
    setup(context){
        const activeContent = ref('teams');
        const token = localStorage.getItem('token');
        const team = ref({});
        const findUserMessage = ref('');
        const name = ref('');
        const router = useRouter();
        const tournaments = ref([]);
        const isAdmin = ref(false);

        const currentSelect = ref('teams');

        const showMenu = (content) => {
            activeContent.value = content;
            currentSelect.value = content;
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
            try {
                const res = await axios.get(_const.axios + '/tournament/myTournament', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.content
                    }
                });
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
        const logout = () => {
            if(token){
                localStorage.setItem('token', '');
              eventBus.emit('tokenChanged', '');
                router.push('/');
            }
        }

        onMounted(async () => {
            await getTeam();
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
            reloadTeam,
            currentSelect
        }
    }
}
</script>

