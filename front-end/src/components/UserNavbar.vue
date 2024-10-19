<template>
  <nav>
    <ul>
      <li><router-link style="text-decoration: none; color: #fff;" to="/">Dashboard</router-link></li>
      <li v-if="!isAuthenticated"><router-link style="text-decoration: none; color: #fff;" to="/login">Login</router-link></li>
      <li v-if="!isAuthenticated"><router-link style="text-decoration: none; color: #fff;" to="/register">Register</router-link></li>
      <li v-if="isAuthenticated">
        <button @click="logout" style="background: none; border: none; color: #fff; cursor: pointer;">Logout</button>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'UserNavbar',
  computed: {
    isAuthenticated() {
      return !!localStorage.getItem('token'); 
    },
  },
  methods: {
    logout() {
      localStorage.removeItem('token'); 
      this.$router.push('/login').then(() => {
          window.location.reload(); 
        });
    },
  },
}
</script>

<style scoped>
nav {
  background: #35424a;
  padding: 1rem;
}
ul {
  list-style: none;
  display: flex;
  gap: 1rem;
}
li {
  color: #ffffff;
  text-decoration: none;
  font-weight: 600;
}
</style>
