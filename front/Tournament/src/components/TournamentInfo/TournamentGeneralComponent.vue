<template>
  <div class="general-wrapper">
    <div class="general-content">
        <h2>Description</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora perspiciatis accusantium quis suscipit magni incidunt voluptatem alias sapiente dolores temporibus magnam consectetur repudiandae, doloribus, omnis quo deleniti totam. Minima, laboriosam!</p>
    </div>
    <div class="general-content">
        <h2>Récompenses</h2>
        <p>Carte-Cadeaux</p>
    </div>
    <div class="general-content">
        <h2>Créateur</h2>
        <div>
            <p>{{ data.CreatorTournament['name'] }}</p>
        </div>
    </div>
    <button @click="handleSubmit">S'inscrire</button>
    <p><b>{{ message }}</b></p>
  </div>
</template>

<script>
import axios from "axios";
import _const from '@/const.js';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
export default {
    name: 'TournamentGeneralComponent',
    props: {
        data: {
            type: Object,
            required: true
        }
    },
    setup(props){
        const data = ref(props.data);
        const teams = ref(data.value.Team);
        const id = ref(0);
        const route = useRoute();
        const token = localStorage.getItem('token');
        const message = ref('');
        const isSuccess = ref(false);
        onMounted(() => {
            id.value = route.params.id;
        })
        const handleSubmit = async () => {
            try {
                const teamRes = await axios.get(_const.axios + '/team/myteam', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.content
                    }
                });
                const res = await axios.patch(_const.axios + '/tournaments/' + id.value + '/addTeam', {
                    Team: [
                        '/api/teams/' + teamRes.data[0].id
                    ]
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.patchContent
                    }
                });
                if(res.data['@id']){
                    isSuccess.value = true;
                    message.value = "Vous vous êtes inscrit au tournoi";
                }
            } catch (error) {
                if(error.response.status === 403){
                    isSuccess.value = true;
                    message.value = error.response.data.message;
                }
            }
        }
        return {
            data,
            handleSubmit,
            message,
            isSuccess
        }
    }
}
</script>

<style scoped>
    .general-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    h2 {
        font-weight: bold;
        font-size: 18px;
    }

    button{
        width: 300px;
        background: var(--primary-color);
        color: var(--background-color);
        font-family: var(--font-family);
        font-weight: bold;
        border: 2px solid transparent;
        outline: none;
        padding: 5px 10px;
        border-radius: 20px;
        transition: all .3s ease;
        cursor: pointer;
    }

    button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }
</style>