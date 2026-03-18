<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery + UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <style>
        body {
            background: #f5f7fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        img.preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">👤 User Management</h3>
    </div>

    <!-- FORM CARD -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Add User
        </div>
        <div class="card-body">

            <form id="userForm" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                        <input type="hidden" name="id" id="id">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>

                <!-- IMAGE PREVIEW -->
                <div class="mb-3">
                    <img id="preview" class="preview d-none"/>
                </div>

                <button type="submit" class="btn btn-success">Save User</button>
            </form>

            <p id="msg" class="mt-3"></p>

        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            Users List (Drag & Drop)
        </div>
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Image</th>
                        
                    </tr>
                </thead>
                <tbody id="data"></tbody>
            </table>

        </div>
    </div>

</div>

<script>
$(document).ready(function(){

    loadData();

    // IMAGE PREVIEW
    $("#image").change(function(){
        let reader = new FileReader();
        reader.onload = function(e){
            $("#preview").attr("src", e.target.result).removeClass("d-none");
        }
        reader.readAsDataURL(this.files[0]);
    });

    // FORM SUBMIT
    $("#userForm").submit(function(e){
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "insert.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $("#msg").html(res);
                $("#userForm")[0].reset();
                $("#preview").addClass("d-none");
                loadData();
            }
        });
    });
    $(document).on("click", ".editBtn", function(){
    let id = $(this).data("id");

    $.ajax({
        url: "edit.php",
        type: "POST",
        data: {id:id},
        success: function(res){
            let data = JSON.parse(res);

            $("#id").val(data.id);
            $("#name").val(data.name);
            $("#email").val(data.email);

            $("#modelButton").text("Update");
        }
    });
});
    // LOAD DATA
    function loadData(){
        $.ajax({
            url: "fetch.php",
            type: "GET",
            success: function(data){
                $("#data").html(data);

                $("#data").sortable({
                    placeholder: "ui-state-highlight"
                });
            }
        });
    }

});
</script>

</body>
</html>