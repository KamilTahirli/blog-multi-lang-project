@extends('backend.layouts.master') @section('content')
@section('title') {{__('translate.istifadechiler')}} @endsection


<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('backend.layouts.topbar')

        <div class="container-fluid">

            <div v-if="rankFormStatus" class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        @{{ rankUserData.name }} / {{ __('translate.rutbe') }}
                        <span @click="rankFormStatus = !rankFormStatus" class="float-right"><i
                                class="fa-solid fa-xmark"></i></span>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <select v-model="select_rank = rankUserData.rank" class="form-control">
                                <option value="0">{{__('translate.istifadechi')}}</option>
                                <option value="1">{{__('translate.admin')}}</option>
                                <option value="2">{{__('translate.moder')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button @click="updateRank(rankUserData.id, select_rank)"
                                class="btn btn-success">{{__('translate.yenile')}}</button>
                        </div>
                    </div>
                </div>
            </div>

        <div class="col-lg-12">
        <div class="card shadow mb-4">
                <div class="card-header">
                    {{ __('translate.istifadechiler') }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        {{ __('translate.ad') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.shekil') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.email') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.q_tarixi') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.rutbe') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('translate.aletler') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr :v-key="index" v-for="(user, index) in users">
                                    <th scope="row">@{{user.id}}</th>
                                    <td>@{{ user.name }}</td>
                                    <td>
                                        <div style="margin-top: -5px !important;" v-if="user.photo != null">
                                            <img :src="'/users/photos/' + user.photo"
                                                style="width: 50px; height: 50px; border-radius: 100px;">
                                        </div>
                                        <div style="margin-top: -5px !important;" v-else>
                                            <img src="/backend/img/no-avatar.png"
                                                style="width: 50px; height: 50px; border-radius: 100px;">
                                        </div>
                                    </td>
                                    <td>@{{ user.email }}</td>
                                    <td>@{{user.created_at}}</td>
                                    <td>
                                        <div v-if="user.rank == 0">{{__('translate.istifadechi')}}</div>
                                        <div v-if="user.rank == 1">{{__('translate.admin')}}</div>
                                        <div v-if="user.rank == 2">{{__('translate.moder')}}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row">

                                            <button @click="userRank(user)"
                                                class="btn btn-sm btn-circle btn-success ml-2">
                                                <i class="fa-solid fa-crown"></i>
                                            </button>

                                            <button @click="deleteUser(user.id)" class="btn btn-sm btn-circle btn-danger ml-2">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="users.length == 0" class="alert alert-warning">{{ __('translate.siyahi_boshdur') }}
                        </div>
                        <nav>
                            <paginate v-if="pageCount > 1" :v-model="current_page" :page-count="pageCount"
                                :click-handler="userList" :prev-text="'<'" :next-text="'>'" :page-class="'page-item'"
                                :page-link-class="'page-link'" :prev-link-class="'page-link'"
                                :next-link-class="'page-link'" :container-class="'pagination'">
                            </paginate>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        </div>
    </div>


    @section('users')
    <script>
        Vue.component('paginate', VuejsPaginate)

        new Vue({
            el: "#wrapper",
            data: {
                rankFormStatus: false,
                rankUserData: [],
                select_rank: '',
                current_page: 1,
                errors: [],
                pageCount: 1,
                users: []
            },
            methods: {

                userList: function (page = 1) {
                    var vm = this;
                    var route_userList = '{{ url("/panel/users/list") }}'
                    route_userList += '?page=' + page;

                    axios.get(route_userList)
                        .then(function (response) {
                            vm.users = response.data.users.data;
                            vm.current_page = response.data.users.current_page
                            vm.pageCount = response.data.users.last_page
                        });
                },

                userRank: function (user) {
                    this.rankFormStatus = true
                    this.rankUserData = user
                },

                updateRank: function (user_id, select_rank) {
                    this.rankFormStatus = false
                    var vm = this;
                    var route = '{{ route("users.rank.update", "id",) }}';
                    route = route.replace('id', user_id);
                    axios.put(route,
                        {
                            select_rank: vm.select_rank
                        })
                        .then(function (res) {
                            alertify.success(res.data.success);
                        });
                },

                deleteUser: function(user_id)
                {
                    swal({
                    title: "{{__('translate.istifadechi_silinsin')}}",
                    text: "{{__('translate.istifadechi_silinerse')}}",
                    icon: "warning",
                    buttons: ["{{__('translate.xeyir')}}", "{{__('translate.beli')}}"],
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        var vm = this;
                        var route = '{{ route("users.delete", "id",) }}';
                        route = route.replace('id', user_id);
                         axios.delete(route)
                          .then(function (res) {
                            vm.userList()
                            swal("{{__('translate.istifadechi_silindi')}}", {
                            icon: "success",
                          });

                        });
                       
                    } 
                    });
                 
                }


            },

            created() {
                this.userList()
            }
        });
    </script>
    @endsection @endsection
</div>