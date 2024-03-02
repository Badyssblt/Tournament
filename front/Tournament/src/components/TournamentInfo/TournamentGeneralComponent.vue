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
    <button>S'inscrire</button>
  </div>
</template>

<script>
export default {
    name: 'TournamentGeneralComponent',
    props: {
        data: Object,
        required: true
    },
    setup(props){
        const data = props.data;

        return {
            data
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