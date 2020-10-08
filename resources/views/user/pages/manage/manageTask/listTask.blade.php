<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="exampleModalLongTitle" style="text-align: center">Danh sách task</h2>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover" id="listTask" style="text-align: center">
                    <thead style="text-align: center">
                        <tr>
                            <th>ID</th>
                            <th>Tên task</th>
                            <th>Trạng thái</th>
                            <th>Thành viên tham gia</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody id="show-task">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<script>
    $(document).ready(function() {
        $('.btn-show-task').click(function (){
            var url = $(this).attr('data-url');
            $("#listTask").dataTable({
                'destroy': true,
                "scrollY": "50vh",
                'info': false,
                "scrollCollapse": true,
                "paging": false,
                "ajax":{
                    "url": url,
                    "type": "GET",
                    "processing": true,
                    "serverSide": true,
                    "datetype": "json"
                },
                "columns": [
                    {"data": "index"},
                    {"data": "name"},
                    {"data": "status",
                    render: function (data, type, row) {
                        if(data == 0) return "<button class='btn btn-secondary'>To-do</button>";
                        else if(data == 1) return "<button class='btn btn-primary'>Doing</button>";
                        else if(data == 2) return "<button class='btn btn-warning'>Review</button>";
                        else if(data == 3) return "<button class='btn btn-success'>Done</button>";
                        else return "<button class='btn btn-danger'>Pending</button>";
                    }},
                    {"data": "name_member",
                    render: function (data, type, row) {
                        var name_member = '';
                        if(data.length > 0){
                            for (let i = 0; i < data.length; i++) {
                                name_member += data[i] + ", ";
                            }
                            return name_member;
                        } else{
                            return '<strong>Chưa ai nhận task</strong>';
                        }
                    }},
                    {"data": "note", "width": "40%"},
                ]

            });
        });
    });
</script>
