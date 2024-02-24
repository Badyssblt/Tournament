<template>
  <form @submit.prevent="setWinner">
    <p>Gagnant du match</p>
    <select name="winner" id="winner" v-model="winner">
        <option value="">Sélectionner une équipe</option>
        <option :value="{ id: item['@id'], name: item.name }" v-for="item in teams.Team">{{ item.name }}</option>
    </select>
    <button type="submit">Définir comme gagnant</button>
    <p class="success-text" v-if="isSuccess">{{ message }}</p>
  </form>
</template>

<script>
import { ref } from 'vue';
import _const from '@/const.js';
import axios from "axios";
export default {
    name: 'SetWinnerComponent',
    props: {
        teams: {
            required: true,
            type: Object
        },
    },
    setup(props, context){
        const teams = ref(props.teams);
        const winner = ref('');
        const token = localStorage.getItem('token');
        const isSuccess = ref(false);
        const message = ref('');
        const match = ref();
        const setWinner = async () => {
            console.log(winner.value);
            try {
                const res = await axios.patch(_const.host + teams.value['@id'], {
                    WinnerMatche: winner.value.id
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.patchContent
                    }
                } );
                if(res.data){
                    isSuccess.value = true;
                    match.value = res.data;
                    message.value = winner.value.name + ' a bien été définie en tant que gagnant.'
                    context.emit('reloadTeams');
                }
            } catch (error) {
                console.error(error);
            }
        }




        return {
            teams,
            winner,
            setWinner,
            isSuccess,
            message
        }
    }
}
</script>

<style scoped>

    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    select {
        border: 2px solid var(--primary-color);
        font-family: var(--font-family);
        background: var(--accent-color);
        cursor: pointer;
    }

    select:focus {
        border: 2px solid var(--primary-color);
    }

    option {
        background: var(--accent-color);
        color: var(--primary-color);
        font-family: var(--font-family);
    }

    button {
        background: var(--primary-color);
        border: 2px solid transparent;
        border-radius: 20px;
        font-family: var(--font-family);
        color: var(--background-color);
        padding: 5px 10px;
        font-weight: bold;
        transition: all .3s ease;
        cursor: pointer;
        width: 200px;
    }

    button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }
</style>