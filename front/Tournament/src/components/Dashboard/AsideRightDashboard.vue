<template>
  <aside>
    <div class="team-info__container">
        <div class="team-info__wrapper" v-if="team[0]">
            <div class="team-info__item">
                <p>Nom de l'équipe</p>
                <p><b>{{ team[0].name }}</b></p>
            </div>
            <div class="team-info__item">
                <p>Créateur de l'équipe</p>
                <p><b>{{ team[0].Creator.name }}</b></p>
            </div>
            <div class="team-info__item">
                <p>Membres de l'équipe</p>
                <div class="team-info__members" v-for="item in team[0].User">
                    <p><b>{{ item.name }}</b></p>
                </div>
            </div>
            <div class="team-info__item">
                <p>Score de l'équipe</p>
                <p v-if="team[0].Score === null"><b>0</b></p>
                <p v-else><b>{{ team[0].Score }}</b></p>
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