<template>
<div class="wrapper">
    <div class="tournament-launch">
        <form @submit.prevent="launchTournament">
            <h2>Démarrer le tournoi</h2>
            <p class="warning">Attention ! Une fois le tournoi démarrer, vous ne pourrez plus ajouter d'équipe, uniquement modifier des matchs !</p>
            <button type="submit">Lancer le tournoi</button>
            <p class="success-text" v-if="isSuccess">{{ message }}</p>
        </form>
    </div>
    <div class="tournament-nextRound">
        <form @submit.prevent="nextRound">
            <h2>Round suiviant</h2>
            <p class="warning">Attention ! Pour lancer le prochain round, vous devez avoir définie toutes les équipes du round précédent.</p>
            <label for="round">Entrer le round actuelle</label>
            <input type="number" name="round" id="round" v-model="round" >
            <p class="success-text" v-if="isSuccessRound"><b>{{ message }}</b></p>
            <button type="submit">Round suivant</button>
        </form>
    </div>
</div>

</template>

<script>
import { onMounted, ref } from 'vue';
import _const from '@/const.js';
import axios from 'axios';
import { useRoute } from 'vue-router';
export default {
    name: "AdminRoundComponent",
    setup(props, context){
        const route = useRoute();
        const id = ref(0);
        const round = ref(0);
        const token = localStorage.getItem('token');
        const isSuccess = ref(false);
        const isSuccessRound = ref(false);
        const message = ref('');
        const launchTournament = async () => {
            try {
                const res = await axios.patch(_const.axios + '/tournaments/' + id.value + '/launch', {}, {
                    headers: {
                        'Content-Type': 'application/merge-patch+json',
                        'Authorization': 'Bearer ' + token
                    }
                });
                isSuccess.value = true;
                message.value = 'Le tournoi a été lancée, les matchs sont crées !';
                context.emit('reloadTeams');
            } catch (error) {
                isSuccess.value = true;
                message.value = 'Le tournoi est déjà lancée !';
            }
        }
        
        const nextRound = async () => {
            try {
                const res = await axios.patch(_const.axios + '/tournaments/' + id.value + '/nextRound/' + round.value, {}, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.patchContent
                    }                
                });
                if(res.data){
                    isSuccessRound.value = true;
                    console.log(round.value + 1);
                    message.value = 'Les matchs du round ' + (round.value + 1) + ' ont été générés';
                };
                context.emit('reloadTeams');
            } catch (error) {
                console.error(error);
            }
        }

        onMounted(() => {
            id.value = route.params.id;
        });

        return {
            launchTournament,
            round,
            isSuccess,
            nextRound,
            isSuccessRound,
            message
        }
    }
}
</script>

<style scoped>
    .wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    button {
        background: var(--primary-color);
        border: 2px solid transparent;
        border-radius: 20px;
        font-family: var(--font-family);
        color: var(--background-color);
        padding: 5px 15px;
        font-weight: bold;
        transition: all .3s ease;
        cursor: pointer;
    }

    button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }

    .warning {
        background: #FFF568;
        padding: 10px;
        border-radius: 10px;
    }

    .tournament-nextRound form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .tournament-nextRound form input {
        background: var(--accent-color);
        font-family: var(--font-family);
        border: none;
        color: var(--primary-color);
    }

    .tournament-nextRound form input:focus {
        outline: 2px solid var(--primary-color);
    }
</style>