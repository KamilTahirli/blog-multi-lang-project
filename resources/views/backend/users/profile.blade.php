@extends('backend.layouts.master') @section('content')
@section('title') {{__('translate.profilim')}} @endsection


<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('backend.layouts.topbar')

        <div class="container-fluid">


            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header">
                        @{{user.name}} / {{ __('translate.profilim')}}
                      </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ __('translate.ad') }}</label>
                                <input v-model="user.name" type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>{{ __('translate.email') }}</label>
                                <input v-model="user.email" type="email" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>{{ __('translate.shekil') }}</label>
                                <input type="file" ref="file" @change="onFileChange" class="form-control">
                                  <div v-if="photo_url!=null">
                                     <img class="preview-img mt-3" v-if="photo_url" :src="photo_url" />
                                      <button @click="removePreviewImage" class="btn btn-sm btn-danger">x</button>
                                 </div>

                                 <div class="mt-3" v-if="user.photo != null">
                                     <img :src="'/users/photos/' + user.photo" style="width: 100px; height: 100px;">
                                     <button @click="deletePhoto(user.id)" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                     </button>
                                  </div>
                                 <div class="mt-3" v-else>
                                    <img src="/backend/img/no-avatar.png" style="width: 100px; height: 100px;">
                                 </div>
                            </div>

                            <div class="form-group">
                                <button @click.prevent="updateProfile(user)" class="btn btn-success">{{__('translate.yenile')}}</button>
                            </div>
                        </div>
                </div>
            </div>


        </div>
    </div>


    @section('users')
    <script>
        new Vue({
            el: "#wrapper",
            data: {
             user: [],
             errors: [],
             photo: '',
             photo_url: null,
            },
            methods: {
              onFileChange: function (e) {
                const file = e.target.files[0];
                this.photo_url = URL.createObjectURL(file);
                this.photo = file
              },
              removePreviewImage: function () {
                    this.$refs.file.value = null,
                    this.photo_url = null
                    this.photo = ''

              },
              deletePhoto: function(user_id)
              {
                var route = '{{ route("users.photo.delete", "id") }}';
                route = route.replace('id', user_id);
                axios.put(route)
                .then(function(res){
                  vm.userData()
                  alertify.success(res.data.success);
                });
              },
              userData: function()
              {
                vm = this
                vm.errors = [];
                let id = {{Auth::user()->id}}

                var route = '{{ route("users.profile.data", "id") }}';
                route = route.replace('id', id);

                axios.get(route)
                .then(function(res){
                  vm.user = res.data.user
                })
                

              },

              updateProfile: function (user) {
                var vm = this;
                vm.errors = [];
                var route_update = '{{ route("users.profile.update", "id") }}';
                route_update = route_update.replace('id', user.id);

                const formData = new FormData();
                formData.append('photo', this.photo);
                formData.append('name', user.name);
                formData.append('email', user.email);
                axios.post(route_update, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                  
                    .then((res) => {
                        vm.userData()
                        vm.removePreviewImage()
                        alertify.success(res.data.success);
                        this.photo = ''
                    })
                    .catch((error) => {
                        const errors = getErrors(error);
                        vm.errors = errors;
                    })
                  
                },
            },

            created() {
             this.userData()

            }
        });
    </script>
    @endsection @endsection
</div>