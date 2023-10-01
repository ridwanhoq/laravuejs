<template>
    <div>
        <h3 class="text-center">Edit Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProduct">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label for="">Detail</label>
                        <textarea name="detail" cols="30" rows="10" v-model="product.detail"></textarea>
                    </div>
                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
        
    </div>
</template>

<script>
export default{
    data() {
        return {
            product: []    
        }
    },
    created() {
        this.axios.get('api/products/${this.$route.params.id}').then((result) => {
                this.product = result.data
        }).catch((err) => {
            
        });
    },
    methods: {
        updateProduct(){
            this.axios.patch('api/products/${this.$route.params.id}', this.product).then(
                (res) => 
                {
                    this.$router.push({
                        name: 'home'
                    });
                }
            )
        }  
    },
}
</script>