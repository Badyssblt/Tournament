<template>
  <header-component/>
  <form @submit.prevent="createTournament">
    <h2>Créer un tournoi</h2>
    <div class="form-container">
      <div class="form-input">
        <label for="name">Nom du tournoi</label>
        <input type="text" name="name" id="name" autocomplete="off" v-model="name">
      </div>
      <div class="form-input">
        <label for="image">Image</label>
        <input type="text" name="image" id="image" v-model="image">
      </div>
      <div class="form-input">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10" v-model="description"></textarea>
      </div>
      <select name="game" id="game" v-model="game">
        <option v-for="item in games" :value="item['@id']">{{ item.name }}</option>
      </select>
      <div class="form-input">
        <label for="maxTeams">Nombre d'équipes maximum</label>
        <input type="number" name="maxTeams" id="maxTeams" v-model="maxTeams">
      </div>
      <button>Créer un tournoi</button>
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
export default {
  name: 'CreateTournamentView',
  components: { HeaderComponent },
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
          description: description.value
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

<style scoped>
  form {
    grid-column: 2 / 12;
    background: var(--form-color);
    padding: 15px;
    border-radius: 20px;
    width: 500px;
    margin: 0 auto;
  }

  h2 {
    font-weight: bold;
    color: var(--secondary-color);
    margin-bottom: 10px;
  }

  .form-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .form-input {
    display: flex;
    flex-direction: column;
  }

  input {
        width: 100%;
        border: none;
        outline: none;
        padding: 5px 10px;
        border-radius: 20px;
        font-family: var(--font-family);
        background: var(--accent-color);
        color: var(--primary-color);
    }
  
  textarea {
    width: 100%;
    background: var(--accent-color);
    border: none;
    resize: none;
    padding: 10px;
    font-family: var(--font-family);
    border-radius: 20px;
    padding-left: 20px;
  }

  textarea:focus {
    border: none;
    outline: none;
  }

  select {
        border: 2px solid transparent;
        font-family: var(--font-family);
        background: var(--accent-color);
        cursor: pointer;
    }

    select:focus {
        border: 2px solid var(--primary-color);
        outline: none;
    }

    option {
        background: var(--accent-color);
        color: var(--primary-color);
        font-family: var(--font-family);
    }

    button {
        background: var(--primary-color);
        border: 2px solid transparent;
        border-radius: 20px;
        font-family: var(--font-family);
        color: var(--background-color);
        padding: 5px 10px;
        font-weight: bold;
        transition: all .3s ease;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }
</style>