<template>
  <div class="menu-dashboard">
    <menu-dashboard/>
  </div>

</template>

<script>
import { ref } from 'vue'
import HeaderComponent from '../components/HeaderComponent.vue'
import axios from 'axios';
import _const from '@/const'
import MenuDashboard from '../components/Dashboard/MenuDashboard.vue';
export default {
  components: { HeaderComponent, MenuDashboard },
  name: "dashboard",
  setup(){
    const name = ref('');
    const token = localStorage.getItem('token');
    const message = ref('');

    return {
        name, 
        message
    }
  }

}
</script>

<style scoped>

    .menu-dashboard {
        grid-row: 2;
        grid-column: 2 /12;
    }
</style>