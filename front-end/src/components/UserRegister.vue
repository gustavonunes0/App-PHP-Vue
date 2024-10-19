<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="registerUser">
      <div class="container">
        <label>Nome:</label>
        <input v-model="name" type="text" required />
      </div>
      <div class="container">
        <label>Email:</label>
        <input v-model="email" type="email" required />
      </div>
      <div class="container">
        <label>Senha:</label>
        <input v-model="password" type="password" required />
      </div>
      <div class="container">
        <label>Confirmar senha:</label>
        <input v-model="password_confirmation" type="password" required />
      </div>
      <button type="submit">Register</button>
      <div v-if="error">{{ error }}</div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'UserRegister',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      error: null,
    };
  },
  methods: {
    async registerUser() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          }),
        });

        if (!response.ok) {
          throw new Error('Registration failed!');
        }

        const data = await response.json();
        console.log(data);
        this.$router.push('/login');
      } catch (err) {
        this.error = err.message;
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
