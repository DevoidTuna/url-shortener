<template>
  <v-footer class="text-center justify-space-around d-flex flex-column" color="primary">
    <div>
      <a v-for="item in itens" :href="item.link" class="mx-4" target="_blank" rel="noopener noreferrer">
        <v-btn color="surface" :key="item.icon" :icon="item.icon" variant="text"></v-btn>
      </a>
    </div>

      <div>
        {{ new Date().getFullYear() }} — <strong>Dev.ly</strong>
      </div>
      <small class="text-secondary mt-2">
        Developed by <b>DevoidTuna</b>
      </small>
  </v-footer>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'TFooter',
  data() {
    return {
      itens: [
        {
          link: 'https://github.com/DevoidTuna',
          icon: 'mdi-github',
        },
        {
          link: 'https://www.linkedin.com/in/patrick-brining-87b04a241/',
          icon: 'mdi-linkedin',
        },
        {
          link: 'https://www.instagram.com/patrickbrining/',
          icon: 'mdi-instagram',
        },
      ],
    }
  },
})
</script>
