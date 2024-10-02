<template>
    <div class="flex justify-between">
      <aside class="flex flex-col gap-4 border-r pr-4">
        <div>
          <Button @click="showMenu('teams')">Ajouter une équipe</Button>
        </div>
        <div>
          <Button @click="showMenu('launch')">Gérer les rounds</Button>
        </div>
        <div>
          <Button @click="showMenu('conf')">Confidentialité</Button>
        </div>
      </aside>
      <div class="w-full ml-4">
        <div class="flex gap-6" v-if="activeContent == 'teams'">
          <div >
            <form @submit.prevent="searchTeam">
              <div class="form-input">
                <label for="team" class="title-bold">Rechercher une équipe</label>
                <input type="text" name="team" id="team" v-model="name" autocomplete="off" class="px-4 py-2 border rounded w-full">
              </div>
              <Button type="submit" class="mt-4 w-full">Rechercher</Button>
            </form>
            <div class="result-container">
              <div class="mt-4" v-show="result.length > 0" v-if="result.length !== 0">
                <p v-if="isAdd" class="success-text">{{ message }}</p>
                <p class="font-medium" v-if="result.length == 1">Résultat</p>
                <p class="result-title" v-else>Résultats</p>
                <div class="border rounded flex py-2 px-4 justify-between" v-for="item in result" :key="item.id">
                  <p class="result-name">{{ item.name }}</p>
                  <button @click="addTeams(item.id, item)" v-if="!item.isCheck">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                  </button>
                  <button v-else><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                  </svg>
                  </button>
                </div>

              </div>
              <div v-else class="mt-4 text-center">
                <p>Aucun résultat</p>
              </div>
            </div>
          </div>
          <div class="admin-container__teams" v-if="teamsInTournament && Object.keys(teamsInTournament)">
            <p class="font-bold text-lg">Équipes inscrites</p>
            <div class="admin-wrappers__teams">
              <div class="relative w-fit" v-for="item in teamsInTournament">
                <button class="absolute -right-6 hover:text-gray-400 transition-all">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                  </svg>

                  </button>
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
import Button from "@/components/Button.vue";
export default {
  components: {Button, AdminRoundComponent, ConfidentialFormComponent },
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

