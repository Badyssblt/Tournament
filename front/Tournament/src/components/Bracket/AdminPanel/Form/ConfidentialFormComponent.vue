<template>
    <div class="confidential-container">
        <h2>Modifier les informations du tournoi.</h2>
        <form @submit.prevent="handleSubmit">
            <div class="form-input">
                <label for="name">Nom du tournoi</label>
                <input type="text" name="name" id="name" autocomplete="off" v-model="name">
            </div>
            <div class="form-input">
                <label for="visibility">Visibilité du tounoi</label>
                <div class="form-radio">
                    <input type="radio" name="visibility" id="public" v-model="visibility" value="public">
                    <label for="public">Public</label>
                </div>
                <div class="form-radio">
                    <input type="radio" name="visibility" id="private" v-model="visibility" value="private">
                    <label for="private">Privée</label>
                </div>
            </div>
            <div class="form-input">
                <label for="name">Image</label>
                <input type="text" name="image" id="image" placeholder="Entrer un lien" autocomplete="off" v-model="imageLink">
            </div>
            <div class="form-input">
                <label for="number">Nombre d'équipe maximum</label>
                <input type="number" name="max" id="max" v-model="maxTeams">
            </div>
            <button type="submit">Modifier le tournoi</button>
            <p class="success-text" v-if="SuccessEdited">{{ message }}</p>
        </form>

    </div>
</template>

<script>
import { onMounted, ref } from 'vue'
import axios from 'axios';
import _const from '@/const.js';
import { useRoute } from 'vue-router';
export default {
    name: 'ConfidentialFormComponent',
    setup(){
        const name = ref('');
        const visibility = ref('');
        const imageLink = ref('');
        const maxTeams = ref(0);
        const route = useRoute();
        const id = ref(0);
        const token = localStorage.getItem('token');
        const SuccessEdited = ref(false);
        const message = ref('');


        onMounted(() => {
            id.value = route.params.id;
        })

        const handleSubmit = async () => {
            try {
                const res = await axios.patch(_const.axios + '/tournaments/' + id.value, {
                    name: name.value,
                    image: imageLink.value,
                    maxTeams: maxTeams.value,
                    visibility: visibility.value
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': _const.patchContent
                    }
                });
                if(res.data){
                    SuccessEdited.value = true;
                    message.value = 'Les informations ont bien été modifié';
                }
            } catch (error) {
                
            }
        }

        return {
            name,
            visibility,
            imageLink,
            maxTeams,
            handleSubmit,
            SuccessEdited,
            message 
        }
    }
}
</script>

<style scoped>

    h2 {
        font-weight: bold;
        margin-bottom: 20px;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
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

        button {
        background: var(--primary-color);
        border: 2px solid transparent;
        border-radius: 20px;
        font-family: var(--font-family);
        color: var(--background-color);
        padding: 5px 15px;
        font-weight: bold;
        transition: all .3s ease;
        cursor: pointer;
    }

    button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }
</style>