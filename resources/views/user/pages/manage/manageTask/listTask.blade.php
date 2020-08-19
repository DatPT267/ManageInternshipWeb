<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="exampleModalLongTitle" style="text-align: center">Danh sách task</h2>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover" id="listTask">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên task</th>
                            <th>Thành viên thực hiện</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="odd gradeX" align="center">
                            <td>1</td>
                            <td>task 1</td>
                            <td>Thanh tân</td>
                        </tr>
                        <tr class="odd gradeX" align="center">
                            <td>1</td>
                            <td>task 1</td>
                            <td>Thanh tân</td>
                        </tr>
                        <tr class="odd gradeX" align="center">
                            <td>1</td>
                            <td>task 1</td>
                            <td>Thanh tân</td>
                        </tr>
                        <tr class="odd gradeX" align="center">
                            <td>1</td>
                            <td>task 1</td>
                            <td>Thanh tân</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.btn-show-task').click(function (){
        var url = $(this).attr('data-url');
        // console.log(url);
        $.ajax({
            type: 'GET',
            url: url,
            success: function (response){
                console.log(response.data);
            }

        })
    });
</script>
