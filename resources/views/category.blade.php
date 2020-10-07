<!DOCTYPE html>
<html>
<head>
    <title>Cloths Ecomarce</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>

<div class="container">
    <h1> Categories Crud</h1>
    <div align="right">
        <a class="btn btn-success " href="javascript:void(0)" id="createNewProduct"> Create New Category</a>
    </div>


<br>
    <table class="table table-bordered data-table">
        <thead>
        <tr>
            <th>No</th>
            <th>Category Name</th>
            <th>Category Details</th>
            <th>Publication Status</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="categoryForm" name="categoryForm" class="form-horizontal">
                    <input type="hidden" name="category_id" id="category_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Category Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category  Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Category Description</label>
                        <div class="col-sm-12">
                            <textarea id="category_description" name="category_description" required="" placeholder="Enter Category Description" class="form-control" rows="4" cols="4"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="publication_status" class="col-sm-2 control-label">Publication Status</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="publication_status" name="publication_status" placeholder="Enter Publication Status" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('category.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category_name', name: 'category_name'},
                {data: 'category_description', name: 'category_description'},
                {data: 'publication_status', name: 'publication_status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewProduct').click(function () {
            $('#saveBtn').val("create-category");
            $('#category_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Category");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editCategory', function () {
            var category_id = $(this).data('id');
            $.get("{{ route('category.index') }}" +'/' + category_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Category");
                $('#saveBtn').val("edit-category");
                $('#ajaxModel').modal('show');
                $('#category_id').val(data.id);
                $('#category_name').val(data.category_name);
                $('#category_description').val(data.category_description);
                $('#publication_status').val(data.publication_status);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#categoryForm').serialize(),
                url: "{{ route('category.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#categoryForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();

                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $('body').on('click', '.deleteCategory', function () {

            var category_id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('category.store') }}"+'/'+category_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

    });
</script>
</html>

