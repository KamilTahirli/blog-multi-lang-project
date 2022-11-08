@extends('backend.layouts.master') @section('content')
@section('title') {{__('translate.kateqoriyalar')}} @endsection
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        @include('backend.layouts.topbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Add Category -->

            <div v-if="addCategoryStatus" id="add-form" class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        {{__('translate.yeni_kateqoriya')}}
                        <span
                            @click="addCategoryStatus=!addCategoryStatus"
                            class="float-right"
                            ><i class="fa-solid fa-xmark"></i
                        ></span>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('translate.ad') }}</label>
                            <input
                                type="text"
                                v-model="name"
                                class="form-control"
                            />
                            <div class="form-group mt-3">
                                <button
                                    @click="saveCategory()"
                                    class="btn btn-success"
                                >
                                    {{ __('translate.yarat') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Add ategory -->

             <!-- Edit Category -->

            <div v-if="editCategoryStatus" class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header">
                       <span v-once> @{{ selectEditCategory.name }}</span> / {{__('translate.duzelish_et')}}
                        <span
                            @click="editCategoryStatus=!editCategoryStatus"
                            class="float-right"
                            ><i class="fa-solid fa-xmark"></i
                        ></span>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('translate.ad') }}</label>
                            <input
                                type="text"
                                v-model="selectEditCategory.name"
                                class="form-control"
                            />
                            <div class="form-group mt-3">
                                <button
                                    @click="updateCategory"
                                    class="btn btn-success"
                                >
                                    {{ __('translate.yenile') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Edit Category -->

            <div class="card shadow mb-4">
                <div class="card-header">
                    {{ __('translate.kateqoriyalar') }}
                    <button
                        @click="statusCategory()"
                        class="float-right btn btn-sm btn-success"
                    >
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
                                        {{ __('translate.ad') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.y_tarixi') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.aletler') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :v-key="index"
                                    v-for="(category, index) in categories"
                                >
                                    <th scope="row">@{{category.id}}</th>
                                    <td>@{{ category.name }}</td>
                                    <td>@{{category.created_at}}</td>
                                    <td>
                                    <div class="d-flex flex-row">
                                      <button  @click="editCategory({...category})" class="btn btn-circle btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                                      <button @click="deleteCat(category.id)" class="btn btn-circle btn-sm btn-danger ml-1"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="categories.length == 0" class="alert alert-warning">{{ __('translate.siyahi_boshdur') }}</div>
                        <nav>
                        <paginate
                         v-if="pageCount > 1"
                         :v-model="current_page"
                         :page-count="pageCount"
                         :click-handler="catList"
                         :prev-text="'<'"
                         :next-text="'>'"
                         :page-class="'page-item'"
                         :page-link-class="'page-link'"
                         :prev-link-class="'page-link'"
                         :next-link-class="'page-link'"
                         :container-class="'pagination'">
                        </paginate>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    @section('categories')
    <script>
        Vue.component('paginate', VuejsPaginate)
        var route = "{{ route('categories.store') }}";
        new Vue({
            el: "#wrapper",
            data: {
                current_page: 1,
                addCategoryStatus: false,
                editCategoryStatus: false,
                selectEditCategory: [],
                name: '',
                errors: [],
                categories: [],
                category: [],
                pageCount: 1
            },
            methods: {
                statusCategory: function()
                {
                    if(this.addCategoryStatus = true)
                    {
                        this.editCategoryStatus = false
                    }else{
                        this.addCategoryStatus = !this.addCategoryStatus
                    }

                },
                saveCategory: function () {
                    var vm = this;
                    vm.errors = [];
                    axios
                        .post(route, {
                            name: this.name,
                        })
                        .then(function (response) {
                            vm.catList()
                            alertify.success(response.data.success);
                        })
                        .catch(function (error) {
                            const errors = getErrors(error);
                            vm.errors = errors;
                        });
                },

                editCategory: function(category)
                {
                  this.addCategoryStatus = false
                  this.editCategoryStatus = true
                  this.selectEditCategory = category
                  
                },
                updateCategory: function() {
                    var vm = this;
                    var route_update = '{{ route("categories.update", "id") }}';
                    route_update = route_update.replace('id', vm.selectEditCategory.id);
                    vm.errors = [];
                    axios
                        .put(route_update, vm.selectEditCategory)
                        .then(function (response) {
                            vm.catList()
                            alertify.success(response.data.success);
                        })
                        .catch(function (error) {
                            const errors = getErrors(error);
                            vm.errors = errors;
                        });
                },

                catList: function(page = 1) {
                    var vm = this;
                    var route_catlist = '{{ url("/panel/categories/list") }}'
                    route_catlist += '?page='+page;

                    axios.get(route_catlist)
                    .then(function (response) {
                        vm.categories = response.data.categories.data;
                        vm.current_page = response.data.categories.current_page
                        vm.pageCount = response.data.categories.last_page
                    });
                },

                deleteCat: function(cat_id) {
                    var vm = this;
                    var route_destroy = '{{ route("categories.destroy", "id") }}';
                    route_destroy = route_destroy.replace('id', cat_id);
                    axios.delete(route_destroy)
                    .then(function (response) {
                        vm.catList()
                        alertify.success(response.data.success);
                    });
                },

             
            },

            created(){
                this.catList()
            }
        });
    </script>
    @endsection @endsection
</div>
