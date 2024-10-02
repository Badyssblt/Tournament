<template>
  <div class="absolute w-24 h-24 bg-primary blur-3xl">

  </div>
  <div class="min-h-screen">
    <div class="flex flex-col items-center gap-6 w-7/12 m-auto">
      <p class="text-5xl text-center font-bold">Rejoignez ou créer des tournois et gagnez des récompenses.</p>
      <p class="text-sm text-center text-black/60">Découvrez notre plateforme de tournois de jeux vidéo, où vous pouvez créer ou rejoindre des compétitions en ligne. Affrontez d'autres joueurs, montrez vos compétences et vivez l'adrénaline du gaming compétitif avec nous.</p>
      <div class="main-button">
        <router-link class="primary-button" to="/search">Découvrir</router-link>
        <Button>S'inscrire</Button>
      </div>
    </div>
    <TournamentRow
        v-if="!emptyCategories.includes('Fortnite')"
        category="Fortnite"
        @empty="handleEmpty"
    />
    <TournamentRow
        v-if="!emptyCategories.includes('Rocket League')"
        category="Rocket League"
        @empty="handleEmpty"
    />
    <TournamentRow
        v-if="!emptyCategories.includes('Valorant')"
        category="Valorant"
        @empty="handleEmpty"
    />
  </div>

    
    <footer-component/>
</template>

<script>
import HeaderComponent from '@/components/HeaderComponent.vue';
import TournamentRow from '@/components/TournamentRow.vue';
import FooterComponent from '../components/FooterComponent.vue';
import Button from "@/components/Button.vue";
import { ref } from "vue"
export default {
  name: 'Home',
  components: {
    HeaderComponent,
    TournamentRow,
    FooterComponent,
    Button
  },
  setup(){
    const emptyCategories = ref([]);

    const handleEmpty = (category) => {
      // Ajouter la catégorie aux catégories vides si elle n'a pas de tournois
      if (!emptyCategories.value.includes(category)) {
        emptyCategories.value.push(category);
      }
    };

    return {
      emptyCategories,
      handleEmpty
    }
  }
}
</script>

<style scoped>
  .main-container {
    grid-row: 2;
    grid-column: 4 / 10;
    margin-top: 90px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
  }

  
  #main-title {
    font-family: Zaio;
    color: var(--primary-color);
    font-size: 4em;
    text-align: center;
  }

  .main-description {
    color: var(--text-color);
    font-size: .9em;
    width: 80%;
  }

  .main-button {
    display: flex;
    flex-direction: row;
    gap: 30px;
  }

  .primary-button {
    padding: 5px 15px;
    background: none;
    border: 2px solid var(--secondary-color);
    color: var(--text-color);
    font-family: var(--font-family);
    outline: none;
    font-size: 1em;
    border-radius: 20px;
  }

  .secondary-button {
    padding: 5px 20px;
    background: var(--secondary-color);
    border: 2px solid transparent;
    color: var(--background-color);
    font-family: var(--font-family);
    outline: none;
    font-size: 1em;
    border-radius: 20px;
    transition: all .2s ease;
  }

  .secondary-button:hover {
    background: none;
    border: 2px solid var(--secondary-color);
    color: var(--secondary-color);
  }
</style>