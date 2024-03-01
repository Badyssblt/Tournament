<script setup>;
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
    --background-color: #FFFFFF;
    --primary-color: #757de8;
    --secondary-color: #3F51B5;
    --accent-color: #dedeff;
    --text-color: #333333;
    --form-color: #f5f5f5;
/* 
    --primary-100:#3F51B5;
    --primary-200:#757de8;
    --primary-300:#dedeff;
    --accent-100:#2196F3;
    --accent-200:#003f8f;
    --text-100:#333333;
    --text-200:#5c5c5c;
    --bg-100:#FFFFFF;
    --bg-200:#f5f5f5;
    --bg-300:#cccccc; */
      
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
