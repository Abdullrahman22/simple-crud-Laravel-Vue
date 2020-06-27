<template>
    <div class="container">
    



        <!-------- Modal --------->
        <div class="modal-container">

            <!-- Create Button Modal -->
            <button type="button" class="btn btn-success float-right" @click="setEditFalse" data-toggle="modal" data-target="#exampleModal">
                Create Post
            </button>

            <!-- Create Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" v-if="edit" >Edit Post</h5>
                            <h5 class="modal-title" id="exampleModalLabel" v-else >Create Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" :class="['form-control' , errors.title ? 'is-invalid' : '' ]" name="title" id="title" placeholder="Type title..." v-model="post.title">
                                <small class="text-danger" v-if="errors.title"> {{errors.title[0] }} </small> 
                            </div>
                            <div class="form-group">
                                <label for="body"> Post</label>
                                <textarea :class="['form-control' , errors.body ? 'is-invalid' : '' ]" name="body" id="body" rows="5" placeholder="What do you think ?!" v-model="post.body"></textarea>
                                <small class="text-danger" v-if="errors.body"> {{errors.body[0] }} </small> 
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> Close </button>
                            <button type="submit" v-if="edit" @click="updatePost()" class="btn btn-primary"> Edit </button>
                            <button type="submit" v-else @click="createPost" class="btn btn-primary"> Create </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-------- Table --------->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">title</th>
                    <th scope="col">body</th>
                    <th scope="col">Updata</th>
                    <th scope="col">delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="( post , index ) in posts" :key="post.id" >
                    <th scope="row"> {{ index + 1 }} </th>
                    <td>{{ post.title }}</td>
                    <td>{{ post.body }}</td>
                    <td> 
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal" @click="editPost(post)">
                            Edit
                        </button>
                    </td>
                    <td> 
                        <button type="button" class="btn btn-danger" @click="deletePost(post)" >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>



    </div>
</template>

<script>
export default {
    data(){
        return{
            posts: {},  // create empty object to insert posts in it to loooop 
            post:{  // create empty object and link it with v-model for create new post 
                title : '',
                body : '',
            },
            errors: {}, // create empty object to insert errors in it to show 
            edit : false // set this var to know if modal for create or edit
        }
    },
    mounted() {
        this.getPosts();
    },
    methods :{


        /*============== getPosts ==============*/
        getPosts(){
            axios.get("api/posts") // request method must be like method in Route in api.php
            .then( 
                resquest => {  // if there success request 
                    this.posts = resquest.data   // equale it with var posts in data 
                }
            )
            .then( error => console.log(error) );
        },



        /*============== createPost ==============*/
        setEditFalse(){
            this.edit  = false // set var edit equale 'false' to know that this modal for create
        },
        createPost(){
            axios.post("api/posts" , this.post)
            // .then( response => console.log(response) ) // to show response in console ( you can name it => req , requests )
            .then( 
                resquest => {  // if there success request 
                    // this.errors = resquest.data.errors  // equale it with var errors in data
                    if( resquest.data.status == "error" ){
                        this.errors = resquest.data.errors  // equale it with var errors in data
                    }else if( resquest.data.status == "saved" ){
                        this.posts.push(  // add post in posts array to show 
                            {
                                title : this.post.title,
                                body : this.post.body,   
                            }
                        ),
                        this.errors = {},  // empty error var
                        this.post = {   // empty post var
                            title : '',
                            body : '',
                        }
                    }
                }
            )
            .then( error => console.log(error) ); // to show error in console
        },



        /*============== UpdatePost ==============*/
        editPost(post){
            this.post = post // equale param with var post in data to bind it
            this.edit = true // set var edit equale 'ture' to know that this modal for edit
        },
        updatePost(){
            axios.put("api/posts/" + this.post.id , this.post)
            // .then( response => console.log(response) ) // to show response in console ( you can name it => req , requests )
            .then( 
                resquest => {  // if there success request 
                    if( resquest.data.status == "error" ){
                        this.errors = resquest.data.errors  // equale it with var errors in data
                    }else if( resquest.data.status == "saved" ){
                        this.errors = {},  // empty error var
                        this.post = {   // empty post var
                            title : '',
                            body : '',
                        }
                    }
                }
            )
            .then( error => console.log(error) ); // to show error in console
        },



        /*============== DeletePost ==============*/
        deletePost(post){
            if( confirm("Are You Sure ?") ){
                axios.delete("api/posts/" + post.id  )
                .then( 
                    resquest => {  // if there success request 
                        if( resquest.data.status == "deleted" ){
                            this.posts.splice( this.posts.indexOf(post), 1 );
                            this.errors = {},  // empty error var
                            this.post = {
                                title : '',
                                body : '',
                            }
                        }
                    }
                )
                .then( error => console.log(error) ); // to show error in console
            }
        }


    }
}
</script>

<style scoped >
    .container{
        margin-top: 50px;
    }
</style>