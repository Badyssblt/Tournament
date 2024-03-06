<template>
    <div class="tournaments-container">
        <h2>Mes inscriptions</h2>
        <div class="tournaments-wrapper">
            <div class="tournaments-item" v-for="item in tournaments">
                        <img :src="item.image " alt="">
                        <div class="tournaments-item__content">
                            <div>
                                <p>{{ item.name }}</p>
                            </div>
                            <router-link :to="'/tournament/' + item.id" class="primary-button">Voir le tournoi</router-link>
                        </div>
                    </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import _const from '@/const.js';
import { jwtDecode } from 'jwt-decode';
import { onMounted, ref } from 'vue';
export default {
    name: 'RegistrationComponent',
    props: {
        team: {
            type: Array,
            required: true
        }
    },
    setup(props){
        const token = localStorage.getItem('token');
        const decoded = jwtDecode(token);
        const tournaments = ref([]);
        const team = ref(props.team);
        const getTournaments = async () => {
            try {
                const res = await axios.get(_const.axios + '/teams/' + team.value[0].id +  '/match', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.content
                    }
                });
            
                tournaments.value = res.data['hydra:member'][0].tournaments;
            } catch (error) {
                
            }
        }
        onMounted(async () => {
            await getTournaments();
        });

        return {
            tournaments
        }
    }
}
</script>

<style scoped>

    h2 {
        font-weight: bold;
        margin-bottom: 20px;
        color: var(--secondary-color);
        font-weight: bold;
        font-size: 1.6em;
        margin-bottom: 10px;
    }
    .tournaments-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .tournaments-item {
        width: 100%;
        display: flex;
        flex-direction: row;
        gap: 10px;
        background: var(--form-color);
        border-radius: 20px;
        padding: 10px;
    }

    .tournaments-item p:nth-child(1){
        font-weight: bold;
        font-weight: 20px;
        margin-bottom: 20px;
    }

    .tournaments-item img {
        width: 200px;
    }

    .myTournament-item__content {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>