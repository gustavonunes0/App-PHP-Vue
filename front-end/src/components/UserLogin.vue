<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="loginUser">
      <div class="container">
        <label>Email:</label>
        <input v-model="email" type="email" required />
      </div>
      <div class="container">
        <label>Senha:</label>
        <input v-model="password" type="password" required />
      </div>
      <button type="submit">Login</button>
      <!-- <div v-if="error">{{ error }}</div> -->
    </form>
  </div>
</template>

<script>
export default {
  name: 'UserLogin',
  data() {
    return {
      email: '',
      password: '',
      error: null,
    };
  },
  methods: {
    async loginUser() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        });

        if (!response.ok) {
          throw new Error('Login failed!');
        }

        const data = await response.json();
        localStorage.setItem('token', data.token);
        this.$router.push('/dashboard').then(() => {
          window.location.reload(); 
        });
      } catch (err) {
        this.error = err.message;
        alert(err.message);
      }
    },
  },
};
</script>

<style scoped>
form {
  display: flex;
  flex-direction: column;
  max-width: 300px;
  margin: auto;
  align-items: flex-start;
}
div {
  margin-bottom: 1rem;
  align-items: center;
}
.container {
  display: flex;
  justify-content: space-between;
  width: 100%;
}
button {
  align-self: flex-end;
  border: none;
  padding: .5rem;
  border-radius: 5px;
  background-color: #2c3e50;
  color: #fff;
}
input {
  border-radius: 5px;
  background-color: #fbfbfb;
  border: 1px solid #d4d4d4;
  color: #000;
  height: 1.5rem;
}
</style>
