<template>
  <div class="auth-modal">
    <div class="modal-content">
      <h2 class="modal-header">Register</h2>
      <form @submit.prevent="register">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="name" id="name" v-model="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        <span class="error-message" v-if="isError">{{message}}</span>
        <button type="submit">Register</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      isError: false,
      message:'loading'
    };
  },
  methods: {
    register() {
      axios.post('/api/register', {
        name: this.name,
        email: this.email,
        password: this.password,
      })
      .then(response => {
        localStorage.setItem('access_token', response.data.access_token);
        this.$router.push('/services');
      })
      .catch(error => {
        this.isError = true;
        this.message = error.response.data.message;
        console.error('Registration failed:', error);
      });
    },
  },
};
</script>
