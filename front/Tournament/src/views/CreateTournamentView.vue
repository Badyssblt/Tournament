<template>
  <form @submit.prevent="createTournament">
    <h2 class="text-xl font-bold">Créer un tournoi</h2>
    <div class="flex flex-col gap-4">
      <div class="">
        <label for="name">Nom du tournoi</label>
        <input type="text" name="name" id="name" autocomplete="off" v-model="name" class="px-4 py-2 border rounded w-full">
      </div>
      <div class="form-input">
        <label for="image">Image</label>
        <input type="text" name="image" id="image" v-model="image" class="px-4 py-2 border rounded w-full">
      </div>
      <div class="form-input">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10" v-model="description" class="px-4 py-2 border rounded w-full"></textarea>
      </div>
      <label for="game">Catégorie du tournoi
        <select name="game" id="game" v-model="game" class="px-4 py-2 border rounded w-full">
          <option v-for="item in games" :value="item['@id']" >{{ item.name }}</option>
        </select>
      </label>

      <div class="form-input">
        <label for="maxTeams">Nombre d'équipes maximum</label>
        <input type="number" name="maxTeams" id="maxTeams" v-model="maxTeams" class="px-4 py-2 border rounded w-full">
      </div>
      <Button class="mt-4 w-full">Créer un tournoi</Button>
      <p v-if="isSuccess">{{ message }}</p>
    </div>
  </form>
</template>

<script>
import axios from 'axios';
import _const from '@/const.js'
import HeaderComponent from '../components/HeaderComponent.vue';
import { onMounted, ref } from 'vue';
import router from '@/router';
import { jwtDecode } from 'jwt-decode';
import Button from "@/components/Button.vue";
export default {
  name: 'CreateTournamentView',
  components: {Button, HeaderComponent },
  setup(){
    const games = ref([]);
    const token = localStorage.getItem('token');
    const name = ref('');
    const image = ref('');
    const description = ref('');
    const game = ref('');
    const maxTeams = ref(0);
    const isSuccess = ref(false);
    const message = ref('');
    const decoded = jwtDecode(token);

    const getGames = async () => {
      try {
        const res = await axios.get(_const.axios + '/games', {
          headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': _const.content
          }
        });
        games.value = res.data['hydra:member'];
      } catch (error) {
        console.error(error);
      }
    }

    const createTournament = async () => {
      try {
        const res = await axios.post(_const.axios + '/tournaments', {
          name: name.value,
          image: image.value,
          description: description.value,
          game: [game.value],
          launched: false,
          visibility: false,
          maxTeams: maxTeams.value,
          CreatorTournament: '/api/users/' + decoded.id,
        }, {
          headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': _const.content
          }
        });
        if(res.data.name){
          isSuccess.value = true;
          message.value = 'Le tournoi a été créer';
          router.push('/dashboard');
        }
      } catch (error) {
        if(error.response.status === 403){
          router.push('/');
        }
      }
    }

    onMounted(async () => {
      await getGames();
    });

    return {
      games,
      game,
      name,
      description,
      image,
      createTournament,
      maxTeams,
      isSuccess,
      message
    }

  }
}
</script>

