<template>
    <HeaderComponent/>
    <div class="main-container">
      <p id="main-title">Rejoignez ou créer des tournois et gagnez des récompenses.</p>
      <p class="main-description">Découvrez notre plateforme de tournois de jeux vidéo, où vous pouvez créer ou rejoindre des compétitions en ligne. Affrontez d'autres joueurs, montrez vos compétences et vivez l'adrénaline du gaming compétitif avec nous.</p>
      <div class="main-button">
        <button class="primary-button">Découvrir</button>
        <button class="secondary-button">S'inscrire</button>
      </div>
    </div>
    <TournamentRow category="Fortnite"/>
    <TournamentRow category="Rocket League"/>
    <TournamentRow category="Valorant"/>
    
    <footer-component/>
</template>

<script>
import HeaderComponent from '@/components/HeaderComponent.vue';
import TournamentRow from '@/components/TournamentRow.vue';
export default {
  name: 'Home',
  components: {
    HeaderComponent,
    TournamentRow,
    FooterComponent
  },
  setup(){

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