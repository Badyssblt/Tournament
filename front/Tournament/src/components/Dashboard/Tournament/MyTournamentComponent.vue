<template>
  <div class="myTournament-container">
                <div class="myTournament-wrapper">
                    <router-link class="primary-button" to="/tournament/create">Créer un tournoi</router-link>
                    <div class="myTournament-item" v-for="item in tournaments">
                        <img :src="item.image " alt="">
                        <div class="myTournament-item__content">
                            <div>
                                <p>{{ item.name }}</p>
                                <p>Visibilité : <b>{{ item.visibility ? 'Public' : 'Privé' }}</b></p>
                            </div>
                            <router-link :to="'/tournament/' + item.id" class="primary-button">Voir le tournoi</router-link>
                        </div>
                    </div>
                </div>
            </div>
</template>

<script>
export default {
    name: 'MyTournamentComponent',
    props: {
        data: {
            type: Object,
            required: true
        }
    },
    setup(props){
        const tournaments = props.data;
        return {
            tournaments
        }
    }
}
</script>

<style scoped>
        .myTournament-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .myTournament-item {
        width: 100%;
        display: flex;
        flex-direction: row;
        gap: 10px;
        background: var(--form-color);
        border-radius: 20px;
        padding: 10px;
    }

    .myTournament-item p:nth-child(1){
        font-weight: bold;
        font-weight: 20px;
    }

    .myTournament-item img {
        width: 200px;
    }

    .myTournament-item__content {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>