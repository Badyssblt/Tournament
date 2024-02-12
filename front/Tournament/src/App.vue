<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <RouterView />
</template>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
  @font-face {
    font-family: Zaio;
    src: url(./assets/fonts/Zaio.woff);
  }
  body {
    background-color: var(--background-color);
  }
  #app {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    font-family: var(--font-family);
    
  }

  :root {
    --font-family: Montserrat;
    --background-color: #0E0606;
    --primary-color: #DC969B;
    --secondary-color: #852229;
    --accent-color: #D72D38;
    --text-color: #F3E8E9;
    --form-color: #1A0B0B;
  }

    html {
    box-sizing: border-box;
    font-size: 16px;
  }

  *, *:before, *:after {
    box-sizing: inherit;
  }

  body, h1, h2, h3, h4, h5, h6, p, ol, ul {
    margin: 0;
    padding: 0;
    font-weight: normal;
  }

  ol, ul, li, a {
    list-style: none;
    text-decoration: none;
  }

  img {
    max-width: 100%;
    height: auto;
  }
</style>
