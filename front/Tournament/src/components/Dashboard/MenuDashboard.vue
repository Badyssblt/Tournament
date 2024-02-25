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
            <div class="create-team" v-if="!team" :key="team">
                <form @submit.prevent="createTeam">
                <p class="title">Créer une équipe</p>
                <div class="form-input">
                    <label for="name">Entrer le nom de l'équipe</label>
                    <input type="text" name="name" id="name" v-model="name" autocomplete="off">
                </div>
                <button type="submit" class="submit">Créer une équipe</button>
                <p class="message">{{ message }}</p>
            </form>
            </div>
            <div class="my-team" v-else>
                <p class="my-team__title">Mon équipe</p>
                <div class="my-team__add-player">
                    <form @submit.prevent="findUser">
                        <div class="form-input">
                            <label for="email">Entrer l'email du joueur</label>
                            <input type="email" name="email" id="email" v-model="searchEmail" autocomplete="off">
                        </div>
                        <button>Rechercher</button>
                        <div class="results">
                            <div class="result-item" v-if="userResult">
                                <p>{{ userResult.email }}</p>
                                <button @click="sendInvite">Inviter</button>
                            </div>
                            <div>
                                <p class="message">{{ findUserMessage }}</p>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            
        </div>
        <div class="dashboard-content__item" v-if="activeContent == 'tournaments'">
            <p>Le contenu de la catégorie mes tournois</p>
        </div>
        <div class="dashboard-content__item" v-if="activeContent == 'signup'">
            <p>Le contenu de la catégorie mes inscriptions</p>
        </div>
    </div>
    <aside-right-dashboard v-if="team && Object.keys(team).length > 0" :data="team"  />
    
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import axios from "axios";
import _const from "@/const.js";
import AsideRightDashboard from './AsideRightDashboard.vue';
import { useRouter } from 'vue-router';

export default {
  components: { AsideRightDashboard },
    name: "MenuDashboard",
    setup(context){
        const activeContent = ref('');
        const token = localStorage.getItem('token');
        const team = ref({});
        const userResult = ref('');
        const searchEmail = ref('');
        const findUserMessage = ref('');
        const name = ref('');
        const router = useRouter();

        const showMenu = (content) => {
            activeContent.value = content;
        }

        const sendInvite = async () => {
            try {
                const res = await axios({
                    url: _const.axios + "/team_join_requests",
                    method: "post",
                    headers: {
                        'Content-Type': _const.content,
                        'Authorization': 'Bearer ' + token
                    },
                    data: {
                        requestingUser: "/api/users/" + userResult.value.id,
                        targetTeam: "/api/teams/" + team.value.id,
                        status: "pending"
                    }
                });
                if(res.data.id){
                    findUserMessage.value = "Invitation envoyé"
                }
            } catch (error) {
                
            }
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

        const findUser = async () => {
            try {
                const res = await axios({
                    url: _const.axios + "/user/get/" + searchEmail.value,
                    
                    headers: {
                        'Content-Type': _const.content,
                        "Authorization": 'Bearer ' + token,
                    }
                });

                userResult.value = res.data;
            } catch (error) {
                console.log(error);
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
        const logout = () => {
            if(token){
                localStorage.setItem('token', '');
                router.push('/');
                console.log('deconnecter');
            }
        }

        onMounted(async () => {
            await getTeam();
        })

        

        return {
            activeContent,
            showMenu,
            team,
            searchEmail,
            findUser,
            userResult,
            sendInvite,
            findUserMessage,
            createTeam,
            name,
            logout
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
        color: var(--text-color);
        font-family: var(--font-family);
        border: none;
        outline: none;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: .9em;
        width: 150px;
        text-align: start;

    }
    .title {
        font-weight: bold;
        color: var(--secondary-color);
        font-size: 1.3em;
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

    .my-team__title {
        color: var(--text-color);
        font-weight: bold;
        font-size: 1.2em;
    }

    .result-item {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
        padding: 5px 10px;
        border-radius: 20px;
        background: var(--primary-color);
    }

    .result-item p {
        color: black;
    }

    .result-item button {
        transition: all .3s ease;
        cursor: pointer;
    }

    .result-item button:hover {
        opacity: .7;
    }
</style>