<template>
    <div class="admin-wrapper">
        <aside>
            <div class="dashboard-menu__item">
                <button @click="showMenu('teams')">Ajouter une équipe</button>
            </div>
            <div class="dashboard-menu__item">
                <button @click="showMenu('launch')">Gérer les rounds</button>
            </div>
            <div class="dashboard-menu__item">
                <button @click="showMenu('conf')">Confidentialité</button>
            </div>
        </aside>
<div>
    <div class="admin-container" v-if="activeContent == 'teams'">
        <div class="admin-form__containers">
        <form @submit.prevent="searchTeam">
            <div class="form-input">
                <label for="team" class="title-bold">Rechercher une équipe</label>
                <input type="text" name="team" id="team" v-model="name" autocomplete="off">
            </div>
            <input type="submit" value="Rechercher">
        </form>
        <div class="result-container">
            <div class="result-wrapper" v-show="result.length > 0">
                <p v-if="isAdd" class="success-text">{{ message }}</p>
                <p class="result-title" v-if="result.length == 1">Résultat</p>
                <p class="result-title" v-else>Résultats</p>
                <div class="result-item" v-for="item in result" :key="item.id">
                    <p class="result-name">{{ item.name }}</p>
                    <button @click="addTeams(item.id, item)" v-if="!item.isCheck"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#ffffff" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg></button>
                    <button v-else><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
<g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M41.9375,8.625c-0.66406,0.02344 -1.27344,0.375 -1.625,0.9375l-18.8125,28.78125l-12.1875,-10.53125c-0.52344,-0.54297 -1.30859,-0.74609 -2.03125,-0.51953c-0.71875,0.22266 -1.25391,0.83203 -1.37891,1.57422c-0.125,0.74609 0.17578,1.49609 0.78516,1.94531l13.9375,12.0625c0.4375,0.37109 1.01563,0.53516 1.58203,0.45313c0.57031,-0.08594 1.07422,-0.41016 1.38672,-0.89062l20.09375,-30.6875c0.42969,-0.62891 0.46484,-1.44141 0.09375,-2.10547c-0.37109,-0.66016 -1.08594,-1.05469 -1.84375,-1.01953z"></path></g></g>
</svg></button>
                </div>

            </div>
        </div>
        </div>
        <div class="admin-container__teams" v-if="teamsInTournament && Object.keys(teamsInTournament)">
            <p class="title-bold">Équipes inscrites</p>
            <div class="admin-wrappers__teams">
                <div class="admin-containers__teams-item" v-for="item in teamsInTournament">
                    <button class="close"><svg class="svg-hover" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="#757de8" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg></button>
                    <p>{{ item.name }}</p>
                </div>
            </div>

        </div>
    </div>
    <div class="admin-container" v-show="activeContent == 'launch'">
        <admin-round-component @reloadTeams="reloadTeams"/>
    </div>
    <div class="admin-container" v-show="activeContent == 'conf' ">
        <confidential-form-component/>
    </div>
</div>
  
    </div>
    
</template>

<script>
import axios from 'axios'
import _const from '@/const.js';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import AdminRoundComponent from './AdminRoundComponent.vue';
import ConfidentialFormComponent from './ConfidentialFormComponent.vue';
export default {
  components: { AdminRoundComponent, ConfidentialFormComponent },
    name: "AddTeamFormComponent",
    props: {
        teams: {
            required: true,
            type: Array
        }
    },
    setup(props, context){
        const token = localStorage.getItem('token');
        const name = ref("");
        const result = ref([]);
        const activeContent = ref('');
        const id = ref(0);
        const route = useRoute(); 
        const teams = ref(props.teams);
        const data = ref([]);
        const teamsInTournament = ref([]);
        const message = ref('');
        const isAdd = ref(false);

        onMounted(async () => {
            id.value = route.params.id;
            teamsInTournament.value = props.teams;
        });

        const reloadTeams = () => {
            context.emit('reloadTeams');
        }
        const getTeams = async ()=> {
            try {
                const res = await axios({
                    url: _const.axios + '/tournaments/' + id.value,
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.content
                    }
                });
                if(res.data){
                    teamsInTournament.value = res.data.Team;
                }
            } catch (error) {
                console.error(error);
            }
        }

        const searchTeam = async () => {
            try {
                const res = await axios({
                    url: _const.axios + '/teams?name=' + name.value,
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.content
                    }
                });
                if(res.data){
                    result.value = res.data['hydra:member'];
                }
            } catch (error) {
                console.error(error);
            }
        }

        const showMenu = (content) => {
            activeContent.value = content;
        }
        const addTeams = async (teamId, item) => {
            if(teams.value[0] && teams.value[0]["@id"]){
                console.log(teams.value);
                const teamIds = teams.value.map(team => team['@id']);
                const formattedTeamData = ref([]);
                teams.value.forEach(team => {
                    formattedTeamData.value.push(team['@id']);
                });
                formattedTeamData.value.push('/api/teams/' + teamId);
                console.log(formattedTeamData.value);
                try {
                const res = await axios({
                    url: _const.axios + '/tournaments/' + id.value,
                    method: 'patch',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.patchContent
                    },
                    data: {
                        Team: formattedTeamData.value
                    }
                });
                teams.value = res.data.Team;
                formattedTeamData.value = [];
                item.isCheck = true;
                getTeams();
            } catch (error) {
                if(error.response.status == 422){
                    isAdd.value = true;
                    message.value = error.response.data.violations[0].message;
                }
            }
            }else {
                const formattedTeamData = ref([]);
                formattedTeamData.value = teams.value;
                formattedTeamData.value.push('/api/teams/' + teamId);
                console.log(formattedTeamData.value);
                try {
                const res = await axios({
                    url: _const.axios + '/tournaments/' + id.value,
                    method: 'patch',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.patchContent
                    },
                    data: {
                        Team: formattedTeamData.value
                    }
                });
                teams.value = res.data.Team;
                item.isCheck = true;
                getTeams();
            } catch (error) {
            }
            }
            
        }

        return {
            name,
            searchTeam,
            result,
            activeContent,
            showMenu,
            addTeams,
            teamsInTournament,
            isAdd,
            message,
            reloadTeams
        }
    }
}
</script>

<style scoped>
    .admin-wrapper {
        display: flex;
        flex-direction: row;
        margin-top: 30px;
        gap: 40px;
    }


    aside {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    form {
        grid-row: 2;
        grid-column: 5/ 12;
        z-index: 3;
        color: var(--text-color);
    }

    .form-input {
        display: flex;
        flex-direction: column;
    }

    .dashboard-menu__item {
        display: flex;
        font-family: var(--font-family);
        height: 30px;
    }

    .dashboard-menu__item button {
        background: none;
        width: 170px;
        border-radius: 20px;
        font-family: var(--font-family);
        background: var(--secondary-color);
        padding: 5px 15px;
        color: var(--background-color);
        border: 2px solid transparent;
        outline: none;
        transition: all .1s ease;
        cursor: pointer;
    }

    .dashboard-menu__item button:hover {
        background: none;
        color: var(--primary-color);
        border: 2px solid var(--secondary-color);
    }

    .admin-container {
        padding: 20px 30px;
        box-shadow: rgba(0, 0, 0, 0.06) 0px 2px 4px 0px inset;
        border-radius: 10px;
        display: flex;
        flex-direction: row;
        gap: 10px;
    }

    #team {
        width: 300px;
        background-color: var(--accent-color);
        outline: none;
        border-radius: 40px;
        border: none;
        padding: 5px 10px;
        padding-left: 30px;
        font-family: var(--font-family);
        color: var(--background-color);
        background-image: url('@/assets/images/search.png');
        background-repeat: no-repeat;
        background-position: 10px;
    }

    .admin-container__teams {
        display: flex;
        flex-direction: column;
        width: 400px;
        gap: 5px;
    }

    .title-bold {
        font-weight: bold;
    }

    .admin-wrappers__teams {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        width: 90%;
    }

    .admin-form__containers {
        display: flex;
        flex-direction: column;
    }

    .admin-containers__teams-item {
        position: relative;
        background: var(--accent-color);
        color: var(--primary-color);
        padding: 6px 20px;
        border-radius: 20px;
        width: fit-content;
        height: fit-content;
    }

    
    .close {
        position: absolute;
        right: 0;
        top: 2px;
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        transition: all .2s ease;
    }

    .close:hover {
        opacity: .7;
        transform: scale(1.1);
    }


    .result-item button {
        display: flex;
        align-items: center;
        justify-content: center;
       padding: 0;
       width: 20px;
       height: 20px;
    }

    svg {
        width: 15px;
        height: 15px;
    }

    input[type=submit]{
        padding: 5px 15px;
        background: var(--secondary-color);
        font-family: var(--font-family);
        color: var(--background-color);
        border: 2px solid transparent;
        border-radius: 20px;
        outline: none;
        margin-top: 20px;
        cursor: pointer;
        transition: all .3s ease;
        font-weight: bold;
    }

    input[type=submit]:hover {
        background: none;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .result-wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .result-title {
        color: var(--text-color);
        font-weight: bold;
        font-size: 1.2em;
    }

    .result-item {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 200px;
        padding: 5px 10px;
        background: var(--accent-color);
        color: var(--text-color);
        border-radius: 5px;
    }

    .result-name {
        color: var(--primary-color);
    }

    .result-item button {
        background: var(--secondary-color);
        color: var(--text-color);
        border: 2ch solid white;
        border-radius: 50%;
        outline: none;
    }


</style>