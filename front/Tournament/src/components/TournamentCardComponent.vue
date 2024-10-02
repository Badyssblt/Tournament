<template>
  <div class="w-96 flex flex-col gap-4 border p-4 rounded">
    <div>
        <img :src="data.image" alt="" class="rounded">
    </div>
    <div class="flex flex-col gap-2">
        <p class="card-title">{{ data.name }}</p>
        <p class="card-secondary">Equipe maximum : <b>{{ data.maxTeams }}</b></p>
        <NavLink :to="'/tournament/' + data.id">Voir plus</NavLink>
    </div>
  </div>
</template>

<script>
import NavLink from "@/components/NavLink.vue";

export default {
    name: "TournamentCard",
    components: {NavLink},
    props: {
        datas: {
            type: Object,
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


    .card-title {
        font-weight: bold;
        font-size: 1.1em;
    }

    .card-secondary {
        font-size: .9em;
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