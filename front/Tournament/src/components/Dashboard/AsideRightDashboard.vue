<template>
  <aside class="w-1/5">
    <div class="border p-4 rounded " v-if="team[0]">
        <div class="flex flex-col gap-6 items-center" v-if="team[0]">
            <div class="team-info__item">
                <p>Nom de l'équipe</p>
                <p class="text-center"><b>{{ team[0].name }}</b></p>
            </div>
            <div class="team-info__item">
                <p>Créateur de l'équipe</p>
                <p class="text-center"><b>{{ team[0].Creator.name }}</b></p>
            </div>
            <div class="team-info__item">
                <p>Membres de l'équipe</p>
                <div class="team-info__members" v-for="item in team[0].User" v-if="team[0].User.length !== 0">
                    <p><b>{{ item.name }}</b></p>
                </div>
              <div v-else>
                <p class="text-black/60 text-center">Aucun membre...</p>
              </div>
            </div>
            <div class="team-info__item">
                <p>Score de l'équipe</p>
                <p v-if="team[0].Score === null" class="text-center"><b>0</b></p>
                <p v-else class="text-center"><b>{{ team[0].Score }}</b></p>
            </div>
          <Button class="bg-red-600">Supprimer l'équipe</Button>
        </div>
    </div>
  </aside>
</template>

<script>
import _const from "@/const.js";
import axios from "axios";
import { onMounted, ref } from 'vue';
import Button from "@/components/Button.vue";
export default {
    name: "AsideRightDashboard",
  components: {Button},
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

