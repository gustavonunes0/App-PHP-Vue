<template>
  <div class="dashboard">
    <h2>Dashboard</h2>
    <button @click="openCreateCategoryModal" class="btn create-btn">Criar Categoria</button>
  
    <h3>Categorias</h3>
    <ul class="category-list">
      <li v-for="category in categories" :key="category.id" class="category-item">
        <div class="item-category">
          <img :src="category.images && category.images.length ? `http://127.0.0.1:8000/storage/${category.images[0].url}` : 'http://127.0.0.1:8000/storage/Standard.png'" alt="Imagem da Categoria" style="width: 50px; height: auto;" />
          {{ category.name }}
          <button @click="openEditCategoryModal(category)" class="btn edit-btn">Editar</button>
        </div>
        <button @click="deleteCategory(category.id)" class="btn delete-btn">Deletar</button>
      </li>
    </ul>
    
    <button @click="openCreateProductModal" class="btn create-btn">Criar Produto</button>
    <h3>Produtos</h3>
    <ul class="product-list">
      <li v-for="product in products" :key="product.id" class="product-item">
        <div class="item-category">
          <img :src="product.images && product.images.length ? `http://127.0.0.1:8000/storage/${product.images[0].url}` : 'http://127.0.0.1:8000/storage/images/standard.png'" alt="Imagem do Produto" style="width: 50px; height: auto;" />
          {{ product.name }}
          <button @click="openEditProductModal(product)" class="btn edit-btn">Editar</button>
        </div>
        <button @click="deleteProduct(product.id)" class="btn delete-btn">Deletar</button>
      </li>
    </ul>

    <div v-if="isCategoryModalOpen" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeCategoryModal">&times;</span>
        <h2>Editar Categoria</h2>
        <div class="modal-items">
          <input v-model="currentCategory.name" placeholder="Nome da Categoria" />
          <button @click="updateCategory" class="btn save-btn">Salvar</button>
        </div>
      </div>
    </div>

    <div v-if="isProductModalOpen" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeProductModal">&times;</span>
        <h2>Editar Produto</h2>
        <div class="modal-items">
          <input v-model="currentProduct.name" placeholder="Nome do Produto" />
          <input v-model="currentProduct.description" placeholder="Descrição do Produto" />
        </div>
        <div style="display: flex; width: 100%; justify-content: start; margin-top: 1rem;">
          <select v-model="currentProduct.category_id">
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
        <button @click="updateProduct" class="btn save-btn">Salvar</button>
      </div>
    </div>
    
    <div v-if="isCreateCategoryModalOpen" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeCreateCategoryModal">&times;</span>
        <h2>Criar Categoria</h2>
        <div class="modal-items">
          <input v-model="currentCategory.name" placeholder="Nome da Categoria" />
          <input type="file" @change="handleCategoryImage" accept="image/*" />
          <button @click="createCategory" class="btn save-btn">Salvar</button>
        </div>
      </div>
    </div>

    <div v-if="isCreateProductModalOpen" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeCreateProductModal">&times;</span>
        <h2>Criar Produto</h2>
        <div class="modal-items">
          <input v-model="currentProduct.name" placeholder="Nome do Produto" />
          <input v-model="currentProduct.description" placeholder="Descrição do Produto" />
          <input type="file" @change="handleProductImage" accept="image/*" />
          <select v-model="currentProduct.category_id">
            <option disabled value="">Selecione uma Categoria</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
          <button @click="createProduct" class="btn save-btn">Salvar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'UserDashboard',
  data() {
    return {
      categories: [],
      products: [],
      isCategoryModalOpen: false,
      isProductModalOpen: false,
      isCreateCategoryModalOpen: false,
      isCreateProductModalOpen: false,
      currentCategory: {},
      currentProduct: {},
      categoryImage: null,
      productImage: null,
    };
  },
  async created() {
    const token = localStorage.getItem('token');
    if (!token) {
      this.$router.push('/login');
    } else {
      await this.fetchCategories();
      await this.fetchProducts();
    }
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/categories', {
          method: 'GET',
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        if (response.ok) {
          this.categories = await response.json();
        } else {
          console.error('Erro ao buscar categorias');
        }
      } catch (error) {
        console.error('Erro ao buscar categorias:', error);
      }
    },

    async fetchProducts() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/products', {
          method: 'GET',
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        if (response.ok) {
          this.products = await response.json();
          console.log(this.products);
        } else {
          console.error('Erro ao buscar produtos');
        }
      } catch (error) {
        console.error('Erro ao buscar produtos:', error);
      }
    },

    openCreateCategoryModal() {
      this.currentCategory = {};
      this.categoryImage = null;
      this.isCreateCategoryModalOpen = true;
    },

    openEditCategoryModal(category) {
      this.currentCategory = { ...category };
      this.categoryImage = null;
      this.isCategoryModalOpen = true;
    },

    closeCategoryModal() {
      this.isCategoryModalOpen = false;
      this.currentCategory = {};
    },

    closeCreateCategoryModal() {
      this.isCreateCategoryModalOpen = false;
      this.currentCategory = {};
    },

    async createCategory() {
      const formData = new FormData();
      formData.append('name', this.currentCategory.name);
      if (this.categoryImage) {
        formData.append('image', this.categoryImage);
      }

      try {
        const response = await fetch('http://127.0.0.1:8000/api/categories', {
          method: 'POST',
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
          body: formData,
        });
        if (response.ok) {
          const newCategory = await response.json();
          this.categories.push(newCategory);
          this.closeCreateCategoryModal();
        } else {
          const error = await response.json();
          alert(`Erro ao criar categoria: ${error.message}`);
        }
      } catch (error) {
        console.error('Erro ao criar categoria:', error);
      }
    },

    async updateCategory() {
      const data = {
        name: this.currentCategory.name, 
      };

      try {
        const response = await fetch(`http://127.0.0.1:8000/api/categories/${this.currentCategory.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json', 
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
          body: JSON.stringify(data), 
        });

        if (response.ok) {
          const updatedCategory = await response.json();
          const index = this.categories.findIndex(c => c.id === updatedCategory.id);
          this.categories.splice(index, 1, updatedCategory);
          await this.fetchCategories(); 
          this.closeCategoryModal(); 
        } else {
          const error = await response.json();
          alert(`Erro ao atualizar categoria: ${error.message}`);
          console.log('Erro de validação:', error);
        }
      } catch (error) {
        console.error('Erro ao atualizar categoria:', error);
      }
    },

    async deleteCategory(id) {
      if (confirm('Você tem certeza que deseja deletar essa categoria?')) {
        try {
          const response = await fetch(`http://127.0.0.1:8000/api/categories/${id}`, {
            method: 'DELETE',
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          });
          if (response.ok) {
            this.categories = this.categories.filter(c => c.id !== id);
          } else {
            const error = await response.json();
            alert(`Erro ao deletar categoria: ${error.message}`);
          }
        } catch (error) {
          console.error('Erro ao deletar categoria:', error);
        }
      }
    },

    openCreateProductModal() {
      this.currentProduct = {};
      this.productImage = null;
      this.isCreateProductModalOpen = true;
    },

    openEditProductModal(product) {
      this.currentProduct = { ...product };
      this.productImage = null;
      this.isProductModalOpen = true;
    },

    closeProductModal() {
      this.isProductModalOpen = false;
      this.currentProduct = {};
    },

    closeCreateProductModal() {
      this.isCreateProductModalOpen = false;
      this.currentProduct = {};
    },

    async createProduct() {
      const formData = new FormData();
      formData.append('name', this.currentProduct.name);
      formData.append('description', this.currentProduct.description);
      formData.append('category_id', this.currentProduct.category_id);
      if (this.productImage) {
        formData.append('image', this.productImage);
      }

      try {
        const response = await fetch('http://127.0.0.1:8000/api/products', {
          method: 'POST',
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
          body: formData,
        });
        if (response.ok) {
          const newProduct = await response.json();
          this.products.push(newProduct);
          this.closeCreateProductModal();
        } else {
          const error = await response.json();
          alert(`Erro ao criar produto: ${error.message}`);
        }
      } catch (error) {
        console.error('Erro ao criar produto:', error);
      }
    },
    async updateProduct() {
      const data = {
        name: this.currentProduct.name,
        description: this.currentProduct.description,
        category_id: this.currentProduct.category_id,
      };

      try {
        const response = await fetch(`http://127.0.0.1:8000/api/products/${this.currentProduct.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
          body: JSON.stringify(data), 
        });

        if (response.ok) {
          const updatedProduct = await response.json();
          const index = this.products.findIndex(p => p.id === updatedProduct.id);
          this.products.splice(index, 1, updatedProduct);
          await this.fetchProducts(); 
          this.closeProductModal();
        } else {
          const error = await response.json();
          alert(`Erro ao atualizar produto: ${error.message}`);
        }
      } catch (error) {
        console.error('Erro ao atualizar produto:', error);
      }
    },

    async deleteProduct(id) {
      if (confirm('Você tem certeza que deseja deletar esse produto?')) {
        try {
          const response = await fetch(`http://127.0.0.1:8000/api/products/${id}`, {
            method: 'DELETE',
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          });
          if (response.ok) {
            this.products = this.products.filter(p => p.id !== id);
          } else {
            const error = await response.json();
            alert(`Erro ao deletar produto: ${error.message}`);
          }
        } catch (error) {
          console.error('Erro ao deletar produto:', error);
        }
      }
    },

    handleCategoryImage(event) {
      this.categoryImage = event.target.files[0];
    },
    
    handleProductImage(event) {
      this.productImage = event.target.files[0];
    },
  },
};
</script>


<style scoped>
.dashboard {
  max-width: 800px;
  margin: 2rem auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}

h2 {
  text-align: center;
  color: #333;
}

.category-list, .product-list {
  list-style-type: none;
  padding: 0;
}

.category-item, .product-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  margin: 5px 0;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.item-category {
  display: flex; 
  width: 80%; 
  justify-content: space-between; 
  align-items: center;
}

.category-item:hover, .product-item:hover {
  background-color: #f1f1f1;
}

input, select {
  border-radius: 5px;
  background-color: #fbfbfb;
  border: 1px solid #d4d4d4;
  color: #000;
  height: 1.5rem;
}

.btn {
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.edit-btn {
  background-color: #4caf50;
  color: white;
}

.edit-btn:hover {
  background-color: #45a049;
}

.delete-btn {
  background-color: #f44336;
  color: white;
}

.delete-btn:hover {
  background-color: #d32f2f;
}

/* Modal Styles */
.modal {
  display: flex;
  flex-direction: column;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.modal-items {
  display: flex; 
  flex-direction: column;
  gap: 1rem;
  width: 100%; 
  justify-content: space-around;
}

@media only screen and (max-width: 700px) {
  .category-item, .product-item {
    display: grid;
    grid-template-columns: 100%;
    align-items: center;
    padding: 10px;
    margin: 5px 0;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s;
  }

  .delete-btn {
    background-color: #f44336;
    color: white;
    max-width: 21%;
    place-self: flex-end;
  }

  .item-category {
    width: 100%;
  }
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.close {
  cursor: pointer;
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.save-btn {
  background-color: #007bff;
  color: white;
}

.save-btn:hover {
  background-color: #0069d9;
}
</style>