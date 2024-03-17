<template>
  <div class="auth-modal">
    <div class="modal-content">
      <h2 class="modal-header">Login</h2>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        <span class="error-message" v-if="isError">{{message}}</span>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      isError: false,
      message:'loading'
    };
  },
  methods: {
    login() {
      axios.post('/api/login', { email: this.email, password: this.password })
        .then(response => {
          localStorage.setItem('access_token', response.data.access_token);
          this.$router.push('/services');
        })
        .catch(error => {
          this.isError = true;
          this.message = error.response.data.error;
          console.error('Login failed:', error);
        });
    },
  },
};
</script>
