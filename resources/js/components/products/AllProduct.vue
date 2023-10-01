<template>
    <div>
        <h2 class="text-center">Product List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Detail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.detail }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link to="{
                                name: 'edit', 
                                params:{
                                    id: product.id
                                }
                            }"></router-link>
                            <button class="btn btn-danger" @click="deleteProduct(product.id)">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default{
    data(){
        return {
            products: []
        }
    },
    created() {
        this.axios.get('api/products/').then((result) => {
            this.products = result.data
        }).catch((err) => {
            
        });
    },
    methods: {
        deleteProduct(id){
            this.axios.delete('api/products/${id}').then(response => {
                let i= this.products.map(data => data.id).indexOf(id);
                this.products.splice(i, 1)
            });
        }
    },
}
</script>