<template>
  <div class="tournament-menu__container">
    <div class="tournament-menu__top">
        <div class="tournament-menu__top-item">
            <button @click="showMenu('general')" :class="{ active : activeContent === 'general'}">Général</button>
        </div>
        <div class="tournament-menu__top-item">
            <button @click="showMenu('lead')" :class="{ active : activeContent === 'lead'}">Leaderboard</button>
        </div>
        <div class="tournament-menu__top-item">
            <button @click="showMenu('teams')" :class="{ active : activeContent === 'teams'}">Équipes</button>
        </div>
    </div>
    <div class="tournament-menu__content">
        <div class="tournament-menu__content-item" v-show="activeContent === 'general'">
            <p>Contenu de la catégorie général</p>
        </div>
        <div class="tournament-menu__content-item" v-show="activeContent === 'lead'">
            <p>Contenu de la catégorie Leaderboard</p>
        </div>
        <div class="tournament-menu__content-item" v-show="activeContent === 'teams'">
            <p class="tournament-menu__title">Équipes</p>
            <div class="tournament-teams__container">
                <div class="tournament-teams__container-items">
                    <div class="tournament-teams__number">
                        <p>{{teamLength }}</p>
                    </div>
                    <p>Inscrite</p>
                </div>
                <div class="tournament-teams__container-items">
                    <div class="tournament-teams__number">
                        <p>{{ data.maxTeams }}</p>
                    </div>
                    <p>Maximum</p>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
export default {
    name: "TournamentMenuComponent",
    props: {
        data: {
            required: true,
            type: Object
        }
    },
    setup(props){
        const data = props.data;
        const teamLength = data.Team.length;
        const activeContent = ref('general');

        const showMenu = (content) => {
            activeContent.value = content;
        }

        return {
            activeContent,
            showMenu,
            data,
            teamLength
        }
    }
}
</script>

<style scoped>

    .tournament-menu__top-item button.active::after {
        content: ""; 
        position: absolute;
        width: calc(100% - 20px); 
        height: 2px; 
        background-color: var(--secondary-color); 
        bottom: 0px; 
        left: 50%; 
        transform: translateX(-50%); 
        z-index: 9;
        border-radius: 20px;
    }

    .tournament-menu__top{
        display: flex;
        flex-direction: row;
        gap: 10px;
        margin-bottom: 40px;
    }

    .tournament-menu__top-item button {
        position: relative;
        background: none;
        border: none;
        outline: none;
        font-family: var(--font-family);
        color: var(--text-color);
    }

    .tournament-menu__content {
        width: 100%;
        background: #1A0B0B;
        padding: 30px;
        border-radius: 20px;
    }

    .tournament-menu__title{
        font-weight: bold;
        font-size: 1.1em;
    }

    .tournament-teams__container {
        display: flex;
        flex-direction: row;
        gap: 50px;
        margin-top: 20px;
        margin-left: 5px;
    }

    .tournament-teams__container-items {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tournament-teams__number {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        background: var(--text-color);
        border-radius: 50%;
        color: black;
    }
</style>