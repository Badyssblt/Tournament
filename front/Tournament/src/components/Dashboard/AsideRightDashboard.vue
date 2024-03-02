<template>
  <aside>
    <div class="team-info__container">
        <div class="team-info__wrapper">
            <div class="team-info__item">
                <p>Nom de l'équipe</p>
                <p>{{ team.name }}</p>
            </div>
            <div class="team-info__item">
                <p>Membres de l'équipes</p>
                <div class="team-info__members" v-for="item in team.User">
                    <p>{{ item.email }}</p>
                </div>
            </div>
            <div class="team-info__item">
                <p>Score de l'équipe</p>
                <p></p>
            </div>
            <div class="team-info__item">
                <p>Matchs à venir</p>
                <p>Testmath</p>
            </div>
        </div>
    </div>
  </aside>
</template>

<script>
import _const from "@/const.js";
import axios from "axios";
import { onMounted, ref } from 'vue';
export default {
    name: "AsideRightDashboard",
    props: {
        data: {
            required: true,
            type: Object
        }
    },
    setup(props){
        const team = props.data;
        const token = localStorage.getItem('token');

        return {
            team,
        }
    }
}
</script>

<style scoped>
    .team-info__container {
        padding: 20px;
        border-radius: 20px;
        background: var(--form-color);
        box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
    }
    .team-info__wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .team-info__members p {
        font-weight: normal;
    }

    p {
        color: var(--text-color);
    }
</style>