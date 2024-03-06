<template>
  <header-component/>
  <form @submit.prevent="handleSubmit">
    <h2>Vérifier votre email</h2>
    <div class="form-input">
        <label for="code">Code de vérification</label>
        <input type="number" name="code" id="code" autocomplete="off" v-model="code">
    </div>
    <button type="submit">Vérifier</button>
    <p v-if="isSuccess">{{ message }}</p>
  </form>
</template>

<script>
import axios from "axios";
import _const from "@/const.js";
import HeaderComponent from '../components/HeaderComponent.vue'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router';
import router from '@/router';
export default {
  components: { HeaderComponent },
  name: "VerifyAccount",
  setup(context) {
    const route = useRoute();
    const id = ref();
    const code = ref(0);
    const message = ref('');
    const isSuccess = ref(false);
    
    const handleSubmit = async () => {
        try {
            const res = await axios.patch(_const.axios + '/users/' + id.value + '/verify/' + code.value, {}, {
                headers: {
                    'Content-Type': _const.patchContent
                }
            });
            isSuccess.value = true;
            message.value = "Votre compte a été validé.";
            router.push('/');
        } catch (error) {
            console.log(error);
            if(error.response.status === 401){
                isSuccess.value = true;
                message.value = error.response.data.message;
            }
        }
    }
    onMounted(() => {
        id.value = route.params.id;
    })

    return {
        code,
        message,
        isSuccess,
        handleSubmit
    }
  }
}
</script>

<style scoped>
  h2 {
    font-weight: bold;
  }

  form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    width: 50%  ;
    background: var(--form-color);
    padding: 20px;
    border-radius: 20px;
    grid-column: 5 / 12;
    box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
  }


  .form-input {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  input {
    text-align: center;
    width: 60%;
    font-size: 30px;
    font-family: var(--font-family);
    outline: none;
  }

  button{
        background: var(--primary-color);
        color: var(--background-color);
        font-family: var(--font-family);
        font-weight: bold;
        border: 2px solid transparent;
        outline: none;
        padding: 5px 10px;
        border-radius: 20px;
        transition: all .3s ease;
        cursor: pointer;
        width: 50%;
    }
    label {
        margin-right: 60px;
    }

    button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }
</style>
