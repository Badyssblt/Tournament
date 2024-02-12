<template>
  <div class="card-container">
    <div class="card-image">
        <img :src="data.image" alt="">
    </div>
    <div class="card-info">
        <p class="card-title">{{ data.name }}</p>
        <p class="card-secondary">Equipe maximum : <b>{{ data.maxTeams }}</b></p>
        <router-link class="secondary-button" :to="'/tournament/' + data.id">Voir plus</router-link>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
    name: "TournamentCard",
    props: {
        datas: {
            type: Array,
            required: true
        }
    },  
    setup(props){
        const data = props.datas;
        return {
            data
        }
    }
}
</script>

<style>
    .card-container {
        width: 300px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 30px;
        padding: 30px 20px;
        border-radius: 10px;
        background: rgb(26, 11, 11);    
    }
    .card-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
        color: var(--text-color);
        width: 100%;
    }

    .card-title {
        font-weight: bold;
        font-size: 1.1em;
    }

    .card-secondary {
        font-size: .9em;
    }


    img {
        border-radius: 10px;
    }

    .secondary-button {
        padding: 5px 15px;
        background: var(--secondary-color);
        border: 2px solid transparent;
        color: var(--text-color);
        font-family: var(--font-family);
        outline: none;
        font-size: 1em;
        border-radius: 20px;
        justify-self: center;
    }

</style>