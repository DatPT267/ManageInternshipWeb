@extends('user.layout.index')
@section('content')
    <div style="margin: 20px 20%;">
        <h1 style="text-align: center; margin-bottom: 20px">Thông tin nhóm của sinh viên</h1>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <h4 class="mb-0">Tên nhóm</h4>
                        </div>
                        <div class="col-sm-10 text-secondary">
                            {{$group->name}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-2">
                            <h4 class="mb-0">Đợt thực tập</h4>
                        </div>
                        <div class="col-sm-10 text-secondary">
                            {{$group->internshipClass->name}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-2">
                            <h4 class="mb-0">Tên đề tài</h4>
                        </div>
                        <div class="col-sm-10 text-secondary">
                            {{$group->topic}}
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-2">
                            <h4 class="mb-0">Trạng thái</h4>
                        </div>
                        <div class="col-sm-10 text-secondary">
                            @if ($group->status == 1)
                                <button class="btn btn-success" disabled>Hoạt động</button>
                            @else
                                <button class="btn btn-danger" disabled>Không hoạt động</button>
                            @endif
                        </div>
                    </div>
                    <hr>
                    {{-- ===============================================DANH SÁCH TASK================================================== --}}
                    <div class="row">
                        <div class="col-sm-2">
                            <h4 class="mb-0">Danh sách task</h4>
                        </div>
                        <div class="col-sm-10 text-secondary">
                            <button data-url="{{route('view-list-task', [$user, $group->id])}}" class="btn btn-primary btn-show-task" data-toggle="modal" data-target=".bd-example-modal-xl">Danh sách task</button>
                        </div>
                        <!-- Extra large modal -->
                        @include('user.pages.manage.manageTask.listTask')
                    </div>
                    {{-- ===============================================DANH SÁCH TASK================================================== --}}
                    <hr>
                    {{-- ===============================================DANH SÁCH SINH VIÊN TRONG NHOMS================================================== --}}
                    <div class="row">
                        <div class="col-sm-2">
                            <h4 class="mb-0">Danh sách sinh viên</h4>
                        </div>
                        @include('user.pages.group.member.listMember')
                    </div>
                    {{-- ===============================================DANH SÁCH SINH VIÊN TRONG NHOMS================================================== --}}
                    <hr>
                </div>
            </div>


    </div>
@endsection
