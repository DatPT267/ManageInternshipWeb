@extends('admin.layout.index')
@section('content')
    <h1>Đăng ký lịch thực tập</h1>
    <form action="{{route('reg.schedule', $user->id)}}" method="post">
        @csrf
        <table class="table table-striped table-bordered table-hover" id="example">
            <thead>
                <tr align="center">
                    <th>Ngày</th>
                    <th>Ca Làm</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd gradeX" align="center">
                    <td>Thứ 2</td>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                            </div>
                            <select class="custom-select" name="thu2">
                                <option selected value="null">Không làm</option>
                                <option value="1">Ca sáng</option>
                                <option value="2">Ca chiều</option>
                                <option value="0">Cả ngày</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr class="odd gradeX" align="center">
                    <td>Thứ 3</td>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                            </div>
                            <select class="custom-select" name="thu3">
                                <option selected value="null">Không làm</option>
                                <option value="1">Ca sáng</option>
                                <option value="2">Ca chiều</option>
                                <option value="0">Cả ngày</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr class="odd gradeX" align="center">
                    <td>Thứ 4</td>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                            </div>
                            <select class="custom-select" name="thu4">
                                <option selected value="null">Không làm</option>
                                <option value="1">Ca sáng</option>
                                <option value="2">Ca chiều</option>
                                <option value="0">Cả ngày</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr class="odd gradeX" align="center">
                    <td>Thứ 5</td>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                            </div>
                            <select class="custom-select" name="thu5">
                                <option selected value="null">Không làm</option>
                                <option value="1">Ca sáng</option>
                                <option value="2">Ca chiều</option>
                                <option value="0">Cả ngày</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr class="odd gradeX" align="center">
                    <td>Thứ 6</td>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                            </div>
                            <select class="custom-select" name="thu6">
                                <option selected value="null">Không làm</option>
                                <option value="1">Ca sáng</option>
                                <option value="2">Ca chiều</option>
                                <option value="0">Cả ngày</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr class="odd gradeX" align="center" >
                    <td colspan="3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </form>
@endsection
