<template>
  <header-component/>
  <form @submit.prevent="handleSubmit">
    <h2>Rechercher un tournoi</h2>
    <div class="form-container">
        <div class="form-input">
        <label for="name">Nom du tournoi</label>
        <input type="search" name="name" id="name" v-model="name">
    </div>
    <div class="form-input">
        <label for="game">Jeux</label>
        <select name="game" id="game">
            <option :value="item['@id']" v-for="item in games">{{ item.name }}</option>
        </select>
    </div>

    <button type="submit">Rechercher</button>
    
    </div>

  </form>
  <div class="result-container">
    <p v-if="noResult">{{ message }}</p>
    <div class="result-wrapper">
        <div class="result-item" v-for="item in result">
            <p>{{ item.name }}</p>
        </div>
    </div>
  </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
import axios from "axios";
import _const from '@/const.js';
import { onMounted, ref } from 'vue';

export default {
  components: { HeaderComponent },
    setup(){
        const token = localStorage.getItem('token');
        const games = ref([]);
        const name = ref('');
        const message = ref('');
        const noResult = ref(false);
        const result = ref([]);

        onMounted(async ( ) => {
            await getGames();
        })
        const getGames = async () => {
            try {
                const res = await axios.get(_const.axios + '/games', {
                    headers: {
                        'Authorization': 'Bearer '+ token,
                        'Content-Type': _const.content
                    }
                });
                if(res.data){
                    games.value = res.data['hydra:member'];
                }
            } catch (error) {
                console.error(error);
            }
        }
        
        const handleSubmit =  async () => {
            try {
                const res = await axios.get(_const.axios + '/tournaments?name=' + name.value, {
                    headers: {
                        'Content-Type': _const.content
                    }
                });
                
                if(res.data['hydra:member'].length == 0){
                    noResult.value = true;
                    message.value = 'Aucun résultat.'
                }else {
                    result.value = res.data['hydra:member'];
                }
            } catch (error) {
                
            }
        }

        return {
            games,
            name,
            handleSubmit,
            noResult,
            message,
            result
        }
    }
}
</script>

<style scoped>
    form {
        grid-column: 2 / 12;
        width: 600px;
        background: var(--form-color);
        padding: 10px;
        border-radius: 20px;
        box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px; 
    }

    h2 {
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-container {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        gap: 30px;
    }

    input {
        border: none;
        outline: none;
        padding: 5px 10px;
        border-radius: 20px;
        font-family: var(--font-family);
        background: var(--accent-color);
        color: var(--primary-color);
    }

    .form-input {
        display: flex;
        flex-direction: column;
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
        width: 150px;
        height: 30px;
    }

    button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }

    .result-container {
        grid-column: 2 / 12;
    }
</style>