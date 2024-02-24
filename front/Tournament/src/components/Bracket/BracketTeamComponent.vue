<template>
    <div class="bracket-team__container" v-if="Object.keys(match)">
        <div class="team-container" v-for="item in teams" :class="{ 'winner-team': item['@id'] === match.WinnerMatche['@id'] }">
            <p >{{ item.name }}</p>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
export default {
    name: "BracketTeamComponent",
    props: {
        data: {
            type: Object,
            required: false
        }
    },
    setup(props){
        const match = props.data;
        const teams = match.Team;
        return {
            match,
            teams
        }
    }
}
</script>

<style scoped>
    .bracket-team__container {
        width: 160px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        background: var(--form-color);
    }

    .team-container {
        width: 100%;
        height: 30px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: var(--accent-color);
    }

    .team-container p {
        color: var(--primary-color);
    }

    .winner-team {
        background: var(--primary-color);
    }

    .winner-team p {
        color: var(--background-color);
    }

</style>