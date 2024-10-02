<template>
  <div  v-if="team[0] == null" :key="team">
            <form @submit.prevent="createTeam" class="w-96">
                <p class="text-xl text-center font-bold">Créer une équipe</p>
                <div class="flex flex-col mt-2">
                    <label for="name">Entrer le nom de l'équipe</label>
                    <input type="text" name="name" id="name" v-model="name" autocomplete="off" class="border px-4 py-2 rounded">
                </div>
                <Button type="submit" class="mt-2 w-full" >Créer une équipe</Button>
                <p class="message">{{ message }}</p>
            </form>
    </div>
            <div class="flex flex-col" v-else v-if="isAdmin" :key="team">
                <p class="text-xl text-center font-bold">Mon équipe</p>
                <div class="my-team__add-player">
                    <form @submit.prevent="findUser" class="form">
                        <h2 class="text-lg font-medium mt-4">Inviter un joueur</h2>
                        <div class="flex flex-col mt-2">
                            <label for="email">Entrer l'email du joueur</label>
                            <input type="email" name="email" id="email" v-model="searchEmail" autocomplete="off" class="border px-4 py-2 rounded">
                        </div>
                        <Button class="w-full mt-4">Rechercher</Button>
                        <div class="results">
                            <div class="border p-2 rounded mt-4 flex gap-6" v-if="userResult && userResult !== 'Error'">
                                <p class="font-medium">{{ userResult.email }}</p>
                                <button @click="sendInvite">Inviter</button>
                            </div>
                          <div v-else-if="userResult === 'Error'">
                            <p class="text-center mt-4 text-black/60">Aucun résultat...</p>
                          </div>
                            <div>
                                <p class="message">{{ findUserMessage }}</p>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
</template>

<script>
import { onMounted, ref } from "vue";
import axios from "axios";
import _const from '@/const.js'
import { jwtDecode } from 'jwt-decode';
import Button from "@/components/Button.vue";
export default {
    name: 'MyTeamsComponents',
  components: {Button},
    props: {
        team: {
            type: Object,
            required: true
        }
    },
    setup(props, context){
        const team = ref(props.team);
        const userResult = ref('');
        const searchEmail = ref('');
        const token = localStorage.getItem('token');
        const isAdmin = ref(false);
        const name = ref('');
        const isSuccess = ref(false);
        const message = ref('');
        const decoded = token ? jwtDecode(token): '';
        const findUserMessage = ref('');


        onMounted(() => {
            if(team.value[0] && decoded.email === team.value[0].Creator.email){
                isAdmin.value = true;
            }else {
                isAdmin.value = false;
            }
        })
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
                    findUserMessage.value = "Invitation envoyé";
                    
                }
            } catch (error) {
                
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
                userResult.value = "Error";
              console.log(userResult.value)
            }
        }

        const createTeam = async () => {
            try {
                const res = await axios.post(_const.axios + '/teams', {
                    name: name.value
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.content
                    }
                });
                if(res.data.name){
                    isSuccess.value = true;
                    message.value = "L'équipe a été crée";
                    team.value = res.data;
                    context.emit('reloadTeam');
                }
            } catch (error) {
                console.log(error);
            }
        }

        return {
            team,
            findUser,
            searchEmail,
            userResult,
            sendInvite,
            isAdmin,
            name,
            createTeam,
            isSuccess,
            message,
          findUserMessage
        }
    }
}
</script>

