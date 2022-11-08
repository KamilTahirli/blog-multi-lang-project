@extends('backend.layouts.master')
@section('title') {{__('translate.postlar')}} @endsection

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('backend.layouts.topbar')

        <div class="container-fluid">

            <!-- Add Post -->

            <form ref="form">
                <div v-if="addPostStatus" id="add-form" class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span v-if="post_title == null">{{__('translate.yeni_post')}} </span>
                            <span v-else>@{{ post_title }} | <img class="i-20"
                                    :src="'/frontend/icon/' + lang + '.svg'"></span>
                            <span @click="addPostStatus=!addPostStatus" class="float-right">
                                <i class="fa-solid fa-xmark"></i>
                            </span>
                        </div>
                        <div class="card-body">

                            <div v-if="catbox_status" class="form-group">
                                <label>{{ __('translate.kateqoriyalar') }}</label>
                                <select v-model="category_id" class="form-control">
                                    <option :key="index" v-for="(cat, index) in all_categories" :value="cat.id">
                                        @{{cat.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ __('translate.bashliq') }}</label>
                                <input type="text" v-model="title" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('translate.mezmun') }}</label>
                                <textarea rows="4" v-model="content" class="form-control"></textarea>
                            </div>


                            <div v-if="filebox_status" class="form-group">
                                <label>{{ __('translate.shekil') }}</label>
                                <input type="file" ref="file" multiple @change="onFileChange" class="form-control">
                                <div v-if="url!=null">
                                    <img class="preview-img mt-3" v-if="url" :src="url" />
                                    <button @click="removeImage" class="btn btn-sm btn-danger">x</button>
                                </div>
                            </div>



                            <div class="form-group mt-3">
                                <button @click="savePost(lang, post_id)" class="btn btn-success">
                                    {{ __('translate.yarat') }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <!-- End Add Post -->



            <!-- Edit Post -->

            <form>
                <div v-if="editPostStatus" class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                        <span> @{{ selectEditPost.title }} </span> / <img class="i-20"
                                :src="'/frontend/icon/' + selectEditPost.locale + '.svg'">
                            <span @click="editPostStatus=!editPostStatus" class="float-right">
                                <i class="fa-solid fa-xmark"></i>
                            </span>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ __('translate.kateqoriyalar') }}</label>
                                <select v-model="selectEditPost.category_id" class="form-control">
                                    <option :key="index" v-for="(cat, index) in all_categories" :value="cat.id">
                                        @{{cat.name}}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ __('translate.bashliq') }}</label>
                                <input type="text" v-model="selectEditPost.title" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>{{ __('translate.mezmun') }}</label>
                                <textarea rows="4" v-model="selectEditPost.content" class="form-control"></textarea>
                            </div>


                            <div class="form-group">
                                <label>{{ __('translate.shekil') }}</label>
                                <input type="file" ref="file" @change="onFileChange" class="form-control">
                                <div v-if="url!=null">
                                    <img class="preview-img mt-3" v-if="url" :src="url" />
                                    <button @click="removeImage" class="btn btn-sm btn-danger">x</button>
                                </div>

                                <img style="width: 100px; height: 100px;" class="mt-3"
                                    :src="'/posts/images/' + selectEditPost.images">
                            </div>

                            <button @click.prevent="updatePost(selectEditPost)" class="btn btn-success">
                                {{ __('translate.yenile') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- End Edit Post -->

            <!-- Show Post Modal -->
            <div class="modal fade" id="showPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">

                   <!-- <span><b>{{ __('translate.shekil') }}:</b></span> -->
                    <br/>
                    <div class="d-flex justify-content-center">
                      <img :src="'/posts/images/' + showPostData.images" style="width:100px; height: 100px;">
                    </div>
                    <br/>
                    <br/>

                    <span><b>{{ __('translate.bashliq') }}:</b></span>
                    <br/>
                       @{{ showPostData.title }}
                    <br/>
                    <br/>

                    <span><b>{{ __('translate.mezmun') }}:</b></span>

                    <br/>
                       @{{ showPostData.content }}
                    <br/>

                    <br/>
                    <span><b>{{ __('translate.muellif') }}:</b></span>
                     @{{ showPostData.author?.name }}
                    <br/>

                   <span><b>{{ __('translate.y_tarixi') }}:</b></span>
                    @{{ showPostData.created_at }}
                    <br/>
                </div>
              
                </div>
            </div>
            </div>
            <!-- End Show Post Modal -->
 


            <div class="card shadow mb-4">
                <div class="card-header">
                    {{ __('translate.postlar') }}
                    <button @click.prevent="createPost()" class="float-right btn btn-sm btn-success">
                        {{__('translate.yarat')}}
                    </button>
                </div>
                <div class="card-body col-lg-12">
                    <div class="table-responsive-sm">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        {{ __('translate.bashliq') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.shekil') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.muellif') }}
                                    </th>
                                    <th scope="col">
                                        <img src="/frontend/icon/az.svg" class="i-20" alt="az">
                                    </th>
                                    <th scope="col">
                                        <img src="/frontend/icon/en.svg" class="i-20" alt="en">
                                    </th>
                                    <th scope="col">
                                        <img src="/frontend/icon/ru.svg" class="i-20" alt="ru">
                                    </th>

                                    <th scope="col">
                                        {{ __('translate.y_tarixi') }}
                                    </th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr :v-key="index" v-for="(post, index) in posts">
                                    <th scope="row">@{{post.id}}</th>
                                    <td>@{{ post.title }}</td>
                                    <td><img :src="'/posts/images/' + post.images" style="width:45px; height: 45px;">
                                    </td>
                                    <td>@{{ post.author.name }}</td>

                                    <td>
                                        <div v-if="getTranslate('az', post.translations)">
                                           <div class="div d-flex flex-row">
                                           <i @click.prevent="editPost('az', post.id)"
                                                class="fa-regular fa-pen-to-square">
                                            </i>
                                            <i class="fa-solid fa-trash ml-1" @click.prevent="deletePost('az', post.id)"></i>
                                            <i class="fa-solid fa-eye ml-1" @click.prevent="showPost('az', post.id)" data-toggle="modal" data-target="#showPost"></i>
                                           </div>
                                        </div>
                                        <div @click.prevent="createPost('az', post.id, post.title)" v-else>
                                        <i
                                                class="fa-solid fa-plus"></i></div>
                                    </td>

                                    <td>
                                        <div v-if="getTranslate('en', post.translations)">
                                           <div class="d-flex flex-row">
                                           <i @click.prevent="editPost('en', post.id)"
                                                class="fa-regular fa-pen-to-square"></i>
                                            <i class="fa-solid fa-trash ml-1" @click.prevent="deletePost('en', post.id)"></i>
                                            <i class="fa-solid fa-eye ml-1" @click.prevent="showPost('en', post.id)"  data-toggle="modal" data-target="#showPost"></i>
                                        </div>

                                        </div>
                                        <div @click.prevent="createPost('en', post.id, post.title)" v-else>
                                            <i class="fa-solid fa-plus"></i></div>
                
                                         </td>

                                     <td>
                                        <div v-if="getTranslate('ru', post.translations)">
                                          <div class="d-flex flex-row">
                                          <i @click.prevent="editPost('ru', post.id)"
                                                class="fa-regular fa-pen-to-square"></i>
                                            <i class="fa-solid fa-trash ml-1" @click.prevent="deletePost('ru', post.id)"></i>
                                            <i class="fa-solid fa-eye ml-1" @click.prevent="showPost('ru', post.id)" data-toggle="modal" data-target="#showPost"></i>
                                        </div>

                                        </div>
                                        <div @click.prevent="createPost('ru', post.id, post.title)" v-else>
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                    </td>

                                    <td>@{{ post.created_at }}</td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="posts.length == 0" class="alert alert-warning">{{ __('translate.siyahi_boshdur') }}
                        </div>
                        <nav>
                            <paginate v-if="pageCount > 1" :v-model="current_page" :page-count="pageCount"
                                :click-handler="postList" :prev-text="'<'" :next-text="'>'" :page-class="'page-item'"
                                :page-link-class="'page-link'" :prev-link-class="'page-link'"
                                :next-link-class="'page-link'" :container-class="'pagination'">
                            </paginate>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    @section('posts')
    <script>
        Vue.component('paginate', VuejsPaginate)
        new Vue({
            el: "#content-wrapper",
            data: {
                current_page: 1,
                addPostStatus: false,
                editPostStatus: false,
                selectEditPost: [],
                showPostData: [],
                category_id: '',
                title: '',
                content: '',
                images: '',
                url: null,
                errors: [],
                categories: [],
                posts: [],
                all_categories: [],
                category: [],
                pageCount: 1,
                lang: '',
                post_id: '',
                post_title: '',
                catbox_status: true,
                filebox_status: true,
            },
            methods: {
                onFileChange: function (e) {
                    const file = e.target.files[0];
                    this.url = URL.createObjectURL(file);
                    this.images = file
                },
                removeImage: function () {
                    this.$refs.file.value = null,
                    this.url = null
                    this.images = ''
                },
                createPost: function (lang = null, post_id = null, post_title = null) {
                    this.addPostStatus = true
                    this.editPostStatus = false
                    this.lang = lang
                    this.post_id = post_id
                    this.post_title = post_title
                    if (lang != null && post_id != null) {
                    this.catbox_status = false
                    this.filebox_status = false
                    } else {
                    this.catbox_status = true
                    this.filebox_status = true
                    }


                },
                getTranslate:  function (lang, translations) {
                    const index = translations.findIndex(translate  =>  translate.locale == lang)
                    return index > -1 ? true : false
                },
                savePost: function (lang = null, post_id = null) {
                    var vm = this;
                    vm.errors = [];
                    var route = '{{ route("posts.store", "lang") }}';
                    route = route.replace('lang', lang) + '/' + post_id;
                    const formData = new FormData();
                    formData.append('images', this.images);
                    formData.append('category_id', this.category_id);
                    formData.append('title', this.title);
                    formData.append('content', this.content);
                    axios.post(route, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                        .then((response) => {
                            this.postList()
                            alertify.success(response.data.success);
                            this.images = null
                        })
                        .catch((error) => {
                            const errors = getErrors(error);
                            vm.errors = errors;
                        });
                },

                editPost: function (lang, post_id) {
                    this.addPostStatus = false
                    this.editPostStatus = true
                    var route_edit = '{{ route("posts.edit", "lang") }}';
                    route_edit = route_edit.replace('lang', lang) + '/' + post_id;
                    var vm = this;
                    axios.get(route_edit)
                        .then(function (response) {
                            vm.selectEditPost = response.data.post;

                        });

                },

                updatePost: function (updateData) {
                    var vm = this;
                    vm.errors = [];

                    var route_update = '{{ route("posts.update", "id") }}';
                    route_update = route_update.replace('id', updateData.id);

                    const formData = new FormData();
                    formData.append('images', this.images);
                    formData.append('category_id', updateData.category_id);
                    formData.append('title', updateData.title);
                    formData.append('content', updateData.content);
                    formData.append('locale', updateData.locale);
                    axios.post(route_update, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                        .then((response) => {
                            this.postList()
                            alertify.success(response.data.success);
                            this.images = ''
                        })
                        .catch((error) => {
                            const errors = getErrors(error);
                            vm.errors = errors;
                        });

                },

                deletePost: function(lang, post_id)
                {
                    swal({
                    title: "{{__('translate.post_silinsin')}}",
                    text: "",
                    icon: "warning",
                    buttons: ["{{__('translate.xeyir')}}", "{{__('translate.beli')}}"],
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                         var route_delete = '{{ route("posts.destroy", "lang") }}';
                          route_delete = route_delete.replace('lang', lang) + '/' + post_id;
                         var vm = this;
                         axios.delete(route_delete)
                          .then(function (response) {
                            vm.postList()
                            swal("{{__('translate.post_silindi')}}", {
                            icon: "success",
                          });

                        })
                        .catch((error) => {
                          
                        });
                       
                    } 
                    });
                },

                showPost: async function(lang, post_id)
                {
                    var vm = this
                    var route_show = '{{ route("posts.show", "lang") }}';
                    route_show = route_show.replace('lang', lang) + '/' + post_id;
                  
                        await axios.get(route_show)
                        .then(function (response) {
                         vm.showPostData = response.data.postData
                    });
                },
                allCategories: function () {
                    var vm = this;
                    var route_all_cat = '{{ route("all.categories") }}'
                    axios.get(route_all_cat)
                        .then(function (response) {
                            vm.all_categories = response.data.all_categories;
                        });
                },
                postList: function (page = 1) {
                    var vm = this;
                    var route_posts_list = '{{ url("/panel/posts/list") }}'
                    route_posts_list += '?page=' + page;

                    axios.get(route_posts_list)
                        .then(function (response) {
                            vm.posts = response.data.posts.data
                            vm.current_page = response.data.posts.current_page
                            vm.pageCount = response.data.posts.last_page
                        });
                },

                deleteCat: function (cat_id) {
                    var vm = this;
                    var route_destroy = '{{ route("categories.destroy", "id") }}';
                    route_destroy = route_destroy.replace('id', cat_id);
                    axios.delete(route_destroy)
                        .then(function (response) {
                            vm.postList()
                            alertify.success(response.data.success);
                        });
                },


            },

            created() {
                this.postList(),
                    this.allCategories()
            }
        });
    </script>
    @endsection
    @endsection
</div>