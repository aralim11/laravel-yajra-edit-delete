<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yajra DataTable</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container">
        <div class="text-center" style="margin: 30px 0 10px 0;">
            <h3>Yajra Server Side DataTable</h3>
        </div>

        <div>
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Verified</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="EditUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">User Edit</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Article was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditArticleModalBody">

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditUserForm">Update</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    // Get All user form database yajra table
    $(function () {
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('getData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });

    // Get single article in EditModel
    function getEditUserData (id) {
        $.ajax({
            url: "edit/"+id,
            method: 'GET',
            success: function(result) {
                console.log(result);
                $('#EditArticleModalBody').html(result.html);
                $('#EditUserModal').show();
            }
        });
    }

    // Close Modal
    $('.modelClose').on('click', function(){
        $('#EditUserModal').hide();
    });

    // Update data form modal
    $('#SubmitEditUserForm').click(function(e) {
        e.preventDefault();
        var id = $('#editId').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "update/"+id,
            method: 'PUT',
            data: {
                name: $('#editName').val(),
            },
            success: function(result) {
                console.log(result);
                if(result.errors) {
                    $('.alert-danger').html('');
                    $.each(result.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                    });
                } else {
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    $('.datatable').DataTable().ajax.reload();
                    setInterval(function(){
                        $('.alert-success').hide();
                        $('#EditArticleModal').hide();
                    }, 2000);
                }
            }
        });
    });


    //Delete USer
    function deleteUserData(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "delete-user/"+id,
            method: 'DELETE',
            success: function(result) {
                console.log(result);
                $('#myTable').DataTable().ajax.reload();
            }
        });
    }
</script>
</body>
</html>
