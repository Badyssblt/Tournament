<template>
  <form @submit.prevent="handleSubmit">
    <h2 class="font-bold text-xl">Rechercher un tournoi</h2>
    <div class="form-container">
        <div class="form-input">
        <label for="name">Nom du tournoi</label>
        <input type="search" name="name" id="name" v-model="name" class="px-4 py-2 border rounded w-full focus:outline-none">
    </div>
    <div class="mt-4">
        <label for="game">Jeux</label>
        <select name="game" id="game" v-model="category" class="px-4 py-2 border w-full">
            <option value="">Sélectionner un jeu</option>
            <option :value="{id: item['@id'], name: item['name']}" v-for="item in games" >{{ item.name }}</option>
        </select>
    </div>

    <Button type="submit" class="mt-4 w-full">Rechercher</Button>
    
    </div>

  </form>
  <div class="result-container">
    <p v-if="noResult" class="text-black/60 mt-4 font-bold text-center">{{ message }}</p>
    <div class="result-wrapper">
         <div class="card-container" v-for="item in result">
            <div class="card-image">
                <img :src="item.image" alt="">
            </div>
            <div class="card-info">
                <p class="card-title">{{ item.name }}</p>
                <p class="card-secondary">Equipe maximum : <b>{{ item.maxTeams }}</b></p>
                <router-link class="primary-button" :to="'/tournament/' + item.id">Voir plus</router-link>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
import axios from "axios";
import _const from '@/const.js';
import { onMounted, ref } from 'vue';
import Button from "@/components/Button.vue";

export default {
  components: {Button, HeaderComponent },
    setup(){
        const token = localStorage.getItem('token');
        const games = ref([]);
        const name = ref('');
        const message = ref('');
        const noResult = ref(false);
        const result = ref([]);
        const category = ref('');

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
                let query = "";
                if(name.value && category.value.name){
                    query = "?name=" + name.value + "&category=" + category.value.name;
                }else if (!name.value && category.value.name){
                    query = "?category=" + category.value.name;
                }else if (name.value && !category.value.name){
                    query = "?name=" + name.value;
                }
                const res = await axios.get(_const.axios + '/tournaments' + query, {
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
            result,
            category
        }
    }
}
</script>

