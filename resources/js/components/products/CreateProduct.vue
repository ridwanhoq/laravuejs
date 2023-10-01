<template>
    <div>
        <h3 class="text-center">Create Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addProduct">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label for="">Detail</label>
                        <textarea name="detail" cols="30" rows="5" v-model="product.detail"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    data() {
        return {
            product: {

            }
        }
    },
    methods: {
        addProduct(){
            this.axios.post('api/products', this.product).then((result) => {
                this.$router.push({
                    name: 'home'
                })
            }).catch((err) => {
                console.log(
                    err
                );
            }).finally(() => {
                this.loading = false
            })
        }
    },
}
</script>