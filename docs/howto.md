Laravel 8 Vue JS CRUD Operation example
here some step for create laravel vue js web crud applications comply with the below steps:
Step 1: Install Laravel
Step 2: Configuration of Database
Step 3: Create a model and run migration
Step 4: Create and configure the controller
Step 5: Add routes
Step 6: Install Laravel Vue UI
Step 7: Install NPM dependencies
Step 8: Build Vue Js CRUD Components
Step 9: Test Laravel Vue JS CRUD operations
let’s start creating Laravel Vue Js SPA CRUD application progressively.

Step 1: Install fresh Laravel
first of all we want to get clean and new Laravel application the use of bellow command, now open your terminal OR command prompt and then fire bellow command and run it(ignore this step if project is already installed):

composer create-project laravel/laravel laravel-vue-crud --prefer-dist
Step 2: Configuration of Database
second step, we configure database like database name, username, password etc for CRUD application of laravel. let's open .env file and fill complete details equal as bellow:
.env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=here your database name(blog)
DB_USERNAME=here database username(root)
DB_PASSWORD=here database password(root)
Step 3: Set Up Model and Run Migration
Run the below process to respectively create the model (database table) and migration file:
upload following code in database/migrations/create_products_table.php file:
database/migrations/create_products_table.php

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateProductsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('detail');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }
}
define Product table values in app/Models/Product.php file:
app/Models/Product.php

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
    use HasFactory;
    protected $fillable = ['name', 'detail'];
}
Now you have to run this migration by firing command:

php artisan migrate
Step 4: Create Product Controller
You need to create the product controller and define the CRUD operations methods:

php artisan make:controller ProductController
Open and update the below code in app\Http\Controllers\ProductController.php file:
app\Http\Controllers\ProductController.php

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller {
    public function index() {
        $products = Product::all()->toArray();
        return array_reverse($products);
    }
    public function store(Request $request) {
        $product = new Product(['name' => $request->input('name'), 'detail' => $request->input('detail') ]);
        $product->save();
        return response()->json('Product created!');
    }
    public function show($id) {
        $product = Product::find($id);
        return response()->json($product);
    }
    public function update($id, Request $request) {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json('Product updated!');
    }
    public function destroy($id) {
        $product = Product::find($id);
        $product->delete();
        return response()->json('Product deleted!');
    }
}
Step 5: Create CRUD Routes
Open routes/web.php file, in here; you have to define the following route:
routes/web.php

<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
next, you need to open the routes/api.php file. First, import the product controller on top, then outline the CRUD API routes inside the route group method as given below:
routes/api.php

<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('api')->group(function () {
    Route::resource('products', ProductController::class);
});
Step 6: Install Laravel Vue UI
Run composer command to install Vue UI in laravel, it's going to appear vue laravel scaffold:

composer require laravel/ui

php artisan ui vue --auth
After that, use the command to install the vue router and vue axios packages. these packages are used to consume Laravel CRUD APIs.

# npm install 

# npm install vue-router vue-axios --force
subsequently, execute the command to install npm packages:

npm install
The npm run watch command compiles the assets, no longer simply that with run watch command you don’t agonize about re-run the compiler over and over once more.

npm run watch
Step 7: Initiate Vue in Laravel
To set up a vue application in Laravel, you need to create a layout folder in the resources/views directory and create an app.blade.php file in the layout folder.
put below code in resources/views/layout/app.blade.php file:
app.blade.php

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>VueJS CRUD Operations in Laravel</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>

<body>
    <div id="app">
    </div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>
Step 8: Create Vue CRUD Components
subsequent, you have to add the router-view directive in App.vue file; this template will assist invoke all the vue routes associated with the components.
So, create App.js file in resources/js folder, positioned the below code in resources/js/App.js file:
App.js

<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav" >
                    <router-link to="/" class="nav-item nav-link" >Products List< /router-link><router-link to= "/create" class="nav-item nav-link" >Create Product< /router-link>
                </div>
            </div>
        </nav>
        <router-view> </router-view>
    </div>
</template>
<script>export default{}</script>
Now, you need to create the following vue js Component files in the resources/js/components folder:

AllProduct.vue
CreateProduct.vue
EditProduct.vue

add code in resources/js/components/AllProduct.vue file; in here we have become all data from database and deleting single product object from database thru vue component.
AllProduct.vue

<template>
    <div>
        <h2 class="text-center">Products List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Detail</th>
                    <!--<th>Actions</th>-->
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products": key="product.id">
                    <td>{{product.id}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.detail}}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link: to="{name: 'edit', params: {id: product.id}}" class="btn btn-success">Edit</router-link>
                            <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
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
          return{products:[]}
        },
       created(){
            this.axios.get('http://localhost:8000/api/products/').then(response => {
                this.products = response.data;
             });
        },
       methods:{
           deleteProduct(id){
                this.axios.delete('http://localhost:8000/api/products/${id}').then(response =>{
                    let i=this.products.map(data=>data.id).indexOf(id);
                    this.products.splice(i, 1)
                });
            }
        }
    } 
</script>
Place code in resources/js/components/CreateProduct.vue file:
CreateProduct.vue

<template>
    <div>
        <h3 class="text-center">Create Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addProduct">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <input type="text" class="form-control" v-model="product.detail">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{product:{}}
               },
        methods:{
            addProduct(){
                this.axios.post('http://localhost:8000/api/products', this.product).then(response =>(this.$router.push({name: 'home'})))
                .catch(err=> console.log(err))
                .finally(()=> this.loading=false)
                         }
            }
        } 
</script>
Head over to resources/js/components/EditProduct.vue template and add the below code:
EditProduct.vue

<template>
    <div>
        <h3 class="text-center">Edit Product</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProduct">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <input type="text" class="form-control" v-model="product.detail">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{product:{}}
              },
        created(){
            this.axios.get(`http://localhost:8000/api/products/${this.$route.params.id}`).then((res)=> 
                    {this.product = res.data;});
                 },
        methods:{
            updateProduct(){
                this.axios.patch(`http://localhost:8000/api/products/${this.$route.params.id}`, this.product).then((res)=> 
                {this.$router.push({name: 'home'});});
                           }
                 }
                } 
</script>
Step 9: Create Vue CRUD Routes
in this step, you need to create vue routes, create routes.js inside resources/js directory, add the code inside the resources/js/routes.js file:
routes.js

import AllProduct from './components/AllProduct.vue';
import CreateProduct from './components/CreateProduct.vue';
import EditProduct from './components/EditProduct.vue';

export const routes = [{
        name: 'home',
        path: '/',
        component: AllProduct
    },
    {
        name: 'create',
        path: '/create',
        component: CreateProduct
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditProduct
    }
];
Step 10: Define Vue App.js
This very last step brings you to the point where you should include the required packages in the app.js file. without in addition ado, please add the following code inside the resources/js/app.js file:
app.js

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import App from './App.vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import {
    routes
} from './routes';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});
https://github.com/ridwanhoq/laravuejs.git
const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
Step 11: Start Laravel Vue CRUD App
to begin the CRUD app, you want to run the two following commands respectively in two different terminals concurrently:

npm run watch
php artisan serve

-- end --

-----------------------------------------------------------



why <template> is used in vue js
ChatGPT
In Vue.js, the <template> element is used as a container for your Vue.js templates. Vue.js is a JavaScript framework that allows you to build dynamic web applications with a declarative syntax. Templates in Vue.js define the structure of your component's view, and the <template> element is a convenient way to define these templates without rendering any content to the DOM.

Here are a few reasons why the <template> element is commonly used in Vue.js:

Conditional Rendering: The <template> element can be used to conditionally render content based on certain conditions without actually rendering anything to the DOM until necessary. You can use directives like v-if or v-for inside a <template> to control when and how content is displayed.

html
Copy code
<template v-if="showContent">
  <p>This content will only be rendered if showContent is true.</p>
</template>
Grouping Elements: You can use the <template> element to group multiple elements together, such as when you have multiple elements that need to be rendered as siblings. This allows you to maintain clean and organized templates.

html
Copy code
<template>
  <h1>Title</h1>
  <p>Paragraph 1</p>
  <p>Paragraph 2</p>
</template>
Reusable Components: When defining components in Vue.js, you often have a single root element inside the component template. Using a <template> element as the root allows you to wrap multiple elements without needing to introduce an extra container div or element to satisfy the single-root requirement.

html
Copy code
<template>
  <div>
    <h1>{{ title }}</h1>
    <p>{{ content }}</p>
  </div>
</template>
Content Distribution: In some cases, you might use the <template> element with slots to distribute content from a parent component to its child components. This is often used in more complex component structures.

html
Copy code
<template>
  <div>
    <slot></slot>
  </div>
</template>
In summary, the <template> element in Vue.js is a versatile tool for defining templates, grouping elements, and controlling conditional rendering without affecting the DOM directly. It helps you write cleaner and more organized code when building Vue.js components and applications.





-----------------------------------------------------------

why <router-link> is used in vue js

ChatGPT
In Vue.js, <router-link> is a component provided by the Vue Router library, which is used for creating links and navigation between different views or pages in a Vue.js application. It's a key component for building single-page applications (SPAs) and enabling client-side routing. Here are some reasons why <router-link> is used in Vue.js:

Declarative Routing: <router-link> provides a declarative way to define navigation links in your Vue.js application. Instead of manually creating anchor (<a>) tags and managing their href attributes, you can use <router-link> components with a to prop to specify where the link should navigate to.

html
Copy code
<router-link to="/about">About Us</router-link>
Preventing Full Page Reloads: When you use regular anchor tags (<a>) to navigate between pages in a traditional multi-page application, clicking a link often results in a full page reload. <router-link> uses Vue Router to handle navigation on the client side, preventing full page reloads and providing a smoother user experience.

Active Link Styling: <router-link> automatically adds an active class to the active link when the route matches the link's to prop. This allows you to easily style the active link to provide visual feedback to users.

html
Copy code
<router-link to="/about" active-class="active-link">About Us</router-link>
Programmatic Navigation: You can also use <router-link> to perform programmatic navigation within your Vue components. By accessing the Vue Router's $router object, you can call methods like push and replace to navigate to different routes programmatically.

javascript
Copy code
this.$router.push('/about'); // Programmatically navigate to the /about route
Nested Routes: In complex Vue.js applications with nested routes, <router-link> is particularly useful for generating links to child routes while maintaining the correct parent-child relationship in the URL.

Navigation Guards: Vue Router provides navigation guards that allow you to control and protect navigation between routes. <router-link> integrates seamlessly with these guards, making it easy to implement authentication checks, route redirection, and other advanced navigation features.

javascript
Copy code
router.beforeEach((to, from, next) => {
  // Implement navigation guard logic here
});
In summary, <router-link> is a core component of Vue Router that simplifies client-side navigation and routing in Vue.js applications. It offers a declarative way to create navigation links, handles route changes, and provides features for styling and controlling navigation behavior. It's essential for building dynamic, SPA-style Vue.js applications with multiple views or pages.






-------------------------------------------------------------

why <router-view> is used in vue js

ChatGPT
In Vue.js, <router-view> is another key component provided by the Vue Router library. It is used for rendering the component associated with the current route. <router-view> is an essential part of building single-page applications (SPAs) and enabling client-side routing. Here are the main reasons why <router-view> is used in Vue.js:

Dynamic Content: <router-view> allows you to render dynamic content based on the current route. When a user navigates to a specific route, Vue Router replaces the content within <router-view> with the component associated with that route. This provides a seamless and dynamic user experience.

html
Copy code
<router-view></router-view>
Nested Routes: Vue Router supports nested routes, where one route's component can contain another <router-view> element. This is particularly useful for creating complex page layouts with nested views, such as master-detail layouts or tabbed interfaces.

html
Copy code
<router-view></router-view>
<!-- Inside a component -->
<router-view></router-view>
Multiple Named Views: In addition to the default <router-view>, Vue Router allows you to define multiple named views within your layout. This is useful when you want to display multiple components in different parts of your layout based on the current route. You can specify which named view should render each route.

html
Copy code
<router-view name="header"></router-view>
<router-view></router-view>
<router-view name="footer"></router-view>
Layouts: You can use <router-view> to create layouts that remain constant across multiple views. For example, you can have a layout with a header, navigation menu, and footer that stays the same while only the main content changes as the user navigates between different routes.

Transitions and Animations: Vue Router seamlessly integrates with Vue's transition system, allowing you to apply transitions and animations when the content inside <router-view> changes. This enhances the user experience by providing smooth transitions between views.

Route Props: <router-view> can receive route-related props from the associated route's component. This allows you to pass data from the route to the component rendered inside <router-view>, making it easier to work with dynamic route parameters and query parameters.

html
Copy code
<router-view :some-prop="propValue"></router-view>
In summary, <router-view> is a fundamental component in Vue Router that enables dynamic content rendering based on routes. It plays a central role in building SPAs and complex Vue.js applications with multiple views, nested routes, and dynamic layouts. It provides a powerful mechanism for creating rich, client-side navigation experiences.




--------------------------------------------------------------


why export default{} is used in vue js
ChatGPT
In Vue.js, the export default {} syntax is commonly used when defining Vue components. This syntax is used to export a Vue component definition as an object, making it accessible for use in other parts of your application.

Here's why export default {} is used in Vue.js:

Component Definition: In Vue.js, components are the building blocks of your application's user interface. Each component is essentially a Vue instance with its own template, data, methods, and lifecycle hooks. When defining a component, you encapsulate its behavior and structure within an object. This object represents the component's definition.

Exporting for Reusability: To use a Vue component in different parts of your application, you need to export it so that other parts of your code (such as other components or your application's entry point) can import and use it. The export default {} syntax allows you to export the component definition as an object that can be easily imported elsewhere in your codebase.

javascript
Copy code
// Example component definition
export default {
  name: 'MyComponent',
  data() {
    return {
      message: 'Hello, Vue!'
    };
  },
  methods: {
    greet() {
      alert(this.message);
    }
  }
};
Consistent Syntax: The export default {} syntax is a consistent and idiomatic way to export Vue components in Vue.js applications. It is a part of the recommended Vue.js project structure and coding conventions.

Single-File Components: Vue.js promotes the use of single-file components, where the template, script, and style for a component are defined in a single .vue file. In such files, the component definition is typically exported using export default {}.

vue
Copy code
<!-- Example.vue -->
<template>
  <div>
    <p>{{ message }}</p>
    <button @click="greet">Greet</button>
  </div>
</template>

<script>
export default {
  name: 'Example',
  data() {
    return {
      message: 'Hello, Vue!'
    };
  },
  methods: {
    greet() {
      alert(this.message);
    }
  }
};
</script>

<style scoped>
/* CSS styles for the component */
</style>
In summary, export default {} is used in Vue.js to define and export Vue component definitions as objects. It allows you to encapsulate the behavior and structure of a component and make it reusable throughout your application by exporting it for use in other parts of your codebase. This syntax is a fundamental part of building Vue.js applications and adheres to Vue's recommended coding conventions.



---------------------------------------------------------











