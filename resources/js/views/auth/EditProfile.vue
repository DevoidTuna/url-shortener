<template>
  <head>
    <title>Edit Account Settings - Dev.ly</title>
  </head>
  <div>
    <v-col class="d-flex justify-center">
      <CardFormEditProfile />
    </v-col>
    <v-col class="d-flex justify-center">
      <EditPasswordPanel class="edit-password-container" />
    </v-col>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

// import CardFormEditProfile from '../../components/cards/CardFormEditProfile.vue';
// import EditPasswordPanel from '../../components/expansionPanels/EditPassword.vue';

export default defineComponent({
  name: 'EditProfile',
  components: {
    // CardFormEditProfile,
    // EditPasswordPanel,
  },
})
</script>

<style scoped>
.edit-password-container {
  width: 530px;
}
</style>
