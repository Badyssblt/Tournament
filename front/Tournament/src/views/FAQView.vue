<template>
  <header-component/>
  <how-begin-creator v-if="answer === 'creator'"/>
  <footer-component/>
</template>

<script>
import { useRoute } from 'vue-router';
import { ref } from "vue";
import HowBeginCreator from '../components/FAQ/HowBeginCreator.vue'
import FooterComponent from '../components/FooterComponent.vue'
import HeaderComponent from '../components/HeaderComponent.vue'
export default {
  components: { HeaderComponent, HowBeginCreator, FooterComponent },
    setup(){
        const route = useRoute();
        const answer = ref(route.params.answer);
        return {
          answer
        }
    }
}
</script>

<style>

</style>