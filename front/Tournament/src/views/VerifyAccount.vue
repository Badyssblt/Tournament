<template>
  <form @submit.prevent="handleSubmit">
    <h2 class="text-xl font-bold text-center">Vérifier votre email</h2>
    <div class="flex flex-col items-center mt-6 gap-2">
        <label for="code" class="font-medium text-lg">Code de vérification</label>
        <input type="number" name="code" id="code" autocomplete="off" v-model="code" class="text-center">
    </div>
    <Button type="submit" class="w-full mt-4">Vérifier</Button>
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
import Button from "@/components/Button.vue";
export default {
  components: {Button, HeaderComponent },
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


