<template>
        <header-component/>
        <div class="tournament-container" :v-if="loaded">
            <div class="tournament-top">
                <div class="tournament-img__container">
                    <img :src="data.image" alt="">
                </div>
                <div class="tournament-info">
                    <p id="tournament-title">{{ data.name }}</p>
                    <router-link :to="'/tournament/' + id + '/view'">Voir le tournoi</router-link>
                </div>
                
            </div>
            <div class="tournament-bottom" v-if="data && Object.keys(data).length">
                <tournament-menu-component :data="data" />
            </div>
        </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import HeaderComponent from '../components/HeaderComponent.vue';
import axios from "axios";
import _const from '@/const';
import { useRoute } from 'vue-router';
import TournamentMenuComponent from '../components/TournamentMenuComponent.vue';


export default {
    name: "TournamentView",
    components: { HeaderComponent, TournamentMenuComponent },
    title: 'Tournoi',
    setup(){
        const route = useRoute();
        const data = ref({});
        const id = ref();
        const loaded = ref(false);
        onMounted(async () => {
            id.value = route.params.id;
            await getData();
        })
        const getData = async () => {
            try {
                const res = await axios({
                    url: _const.axios + "/tournaments/" + id.value,
                    headers: {
                        'Content-Type': _const.content,
                    }
                });

                data.value = res.data;
                loaded.value = true;
            } catch (error) {
                console.error(error);
            }
        }

        return {
            loaded,
            data,
            id
        }

    }
   
}
</script>

<style>
    .tournament-container {
        grid-row: 2;
        grid-column: 2 / 12;
        color: var(--text-color);
    }

    .tournament-top {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        gap: 50px;
    }

    .tournament-img__container {
        width: 300px;
        height: 300px;
        overflow: hidden;
        border-radius: 50%;
    }

    .tournament-img__container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .tournament-info {
        display: flex;
        flex-direction: column;
    }

    #tournament-title {
        font-weight: bold;
        font-size: 2.8em;
        color: var(--text-color);
        text-transform: uppercase;
    }
</style>