<template>
<div>
    <form @submit.prevent="launchTournament">
        <h2>Démarrer le tournoi</h2>
        <p class="warning">Attention ! Une fois le tournoi démarrer, vous ne pourrez plus ajouter d'équipe, uniquement modifier des matchs !</p>
        <button type="submit">Lancer le tournoi</button>
    </form>
</div>

</template>

<script>
import { onMounted, ref } from 'vue';
import _const from '@/const.js';
import axios from 'axios';
import { useRoute } from 'vue-router';
export default {
    name: "AdminRoundComponent",
    setup(){
        const route = useRoute();
        const id = ref(0);
        const round = ref(0);
        const token = localStorage.getItem('token');
        const launchTournament = async () => {
    try {
        const res = await axios.patch(_const.axios + '/tournaments/' + id.value + '/launch', {}, {
            headers: {
                'Content-Type': 'application/merge-patch+json',
                'Authorization': 'Bearer ' + token
            }
        });
        console.log(res);
    } catch (error) {
        console.error(error);
    }
}
        
        const nextRound = async () => {
            try {
                const res = await axios({
                    url: _const.axios + '/tournaments/' + id.value + '/nextRound/' + round.value,
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.patchContent
                    },
                    method: 'patch'
                })
            } catch (error) {
                
            }
        }

        onMounted(() => {
            id.value = route.params.id;
        });

        return {
            launchTournament
        }
    }
}
</script>

<style scoped>
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
</style>