<template>
  <div class="create-team" v-if="!team" :key="team">
                <form @submit.prevent="createTeam" class="form">
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
                    <form @submit.prevent="findUser" class="form">
                        <h2>Inviter un joueur</h2>
                        <div class="form-input">
                            <label for="email">Entrer l'email du joueur</label>
                            <input type="email" name="email" id="email" v-model="searchEmail" autocomplete="off">
                        </div>
                        <button class="primary-button">Rechercher</button>
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
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import _const from '@/const.js'
export default {
    name: 'MyTeamsComponents',
    props: {
        team: {
            type: Object,
            required: true
        }
    },
    setup(props){
        const team = ref(props.team);
        const userResult = ref('');
        const searchEmail = ref('');
        const token = localStorage.getItem('token');
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

        return {
            team,
            findUser,
            searchEmail,
            userResult,
            sendInvite
        }
    }
}
</script>

<style scoped>

    h2 {
        font-weight: bold;
        margin-bottom: 20px;
    }
    .my-team__title {
        color: var(--secondary-color);
        font-weight: bold;
        font-size: 1.6em;
        margin-bottom: 10px;
    }

    .form {
        background: var(--form-color);
        padding: 10px;
        border-radius: 20px;
        box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
    }

    .result-item {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
        padding: 5px 10px;
        border-radius: 20px;
        background: var(--primary-color);
        margin-top: 20px;
        width: fit-content;
    }

    .result-item p {
        color: var(--background-color);
    }

    .result-item button {
        transition: all .3s ease;
        cursor: pointer;
        color: var(--background-color);
    }

    .result-item button:hover {
        opacity: .7;
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
        font-weight: bold;
        font-size: 14px;
    }

    input {
        width: fit-content;
        background: var(--primary-color);
        border: none;
        outline: none;
        padding: 5px;
        border-radius: 20px;
        color: var(--background-color);
        padding-left: 10px;
        font-family: var(--font-family);
    }

    .form-input {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
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