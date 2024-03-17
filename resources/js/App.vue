<template>
  <div id="app">
    <div class="card__header">
      <div>
          <h2 class="card__title">Network Services</h2>
      </div>
      <div class="header-links">
        <div v-if="!isAuthenticated">
          <router-link to="/login" class="header-button">Login</router-link>
          <router-link to="/register" class="header-button">Register</router-link>
        </div>
        <router-link to="/services" class="header-button">Network Services</router-link>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>

export default {
  computed: {
    isAuthenticated() {
      return localStorage.getItem('access_token') !== null;
    }
  }
};
</script>
