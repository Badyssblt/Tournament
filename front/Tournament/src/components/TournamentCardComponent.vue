<template>
  <div class="card-container">
    <div class="card-image">
        <img :src="data.image" alt="">
    </div>
    <div class="card-info">
        <p class="card-title">{{ data.name }}</p>
        <p class="card-secondary">Equipe maximum : <b>{{ data.maxTeams }}</b></p>
        <router-link class="primary-button" :to="'/tournament/' + data.id">Voir plus</router-link>
    </div>
  </div>
</template>

<script>
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

<style scoped>
    .card-container {
        width: 300px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 30px;
        padding: 30px 20px;
        border-radius: 10px;
        background: var(--form-color);    
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

    .primary-button {
        width: 100%;
        text-align: center;
        background: var(--primary-color);
        color: var(--background-color);
        font-family: var(--font-family);
        font-weight: bold;
        border: 2px solid transparent;
        outline: none;
        padding: 5px 15px;
        font-size: 14px;
        border-radius: 20px;
        transition: all .3s ease;
        cursor: pointer;
    }

    .primary-button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }

</style>