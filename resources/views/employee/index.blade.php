<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="success-message"></div>

    <div class="add-employee-modal">
        <ul id="addformErrorList"></ul>
        <div class="modal-body">
            <div class="form-group">
                <label for="">First Name</label>
                <input type="text" class="first-name form-control">
            </div>
            <div class="form-group">
                <label for="">Last Name</label>
                <input type="text" class="last-name form-control">
            </div>
            <div class="form-group">
                <label for="">Department Name</label>
                <input type="text" class="department form-control">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="email form-control">
            </div>
            <div class="form-group">
                <label for="">Phone</label>
                <input type="text" class="phone form-control">
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="username form-control">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="password form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button">Close</button>
            <button type="button" class="addEmployee">Add</button>
        </div>
    </div>

    <div class="edit-employee-modal">
        <ul id="addformErrorList"></ul>
        <input type="hidden" id="editEmployeeId">
        <div class="modal-body">
            <div class="form-group">
                <label for="">First Name</label>
                <input type="text" id="editFirstName" class="first-name form-control">
            </div>
            <div class="form-group">
                <label for="">Last Name</label>
                <input type="text" id="editLastName" class="last-name form-control">
            </div>
            <div class="form-group">
                <label for="">Department Name</label>
                <input type="text" id="editDepartment" class="department form-control">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" id="editEmail" class="email form-control">
            </div>
            <div class="form-group">
                <label for="">Phone</label>
                <input type="text" id="editPhone" class="phone form-control">
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" id="editUsername" class="username form-control">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" id="editPassword" class="password form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button">Close</button>
            <button type="button" class="updateEmployee">Update</button>
        </div>
    </div>

    <div class="table-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            <thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td><button type="button" value="" class="editEmployee">Edit</button></td>
                    <td><button type="button" value="" class="deleteEmployee">Delete</button></td>
                </tr>
            </tbody>
            </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {

            fetchEmployee();

            function fetchEmployee()
            {
                $.ajax({
                    type: "GET",
                    url: "./fetch-employees",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        $.each(response.employees, function (key, item) {
                            $('tbody').append(
                            '<tr>\
                            <td>'+item.id+'</td>\
                            <td>'+item.first_name+'</td>\
                            <td>'+item.last_name+'</td>\
                            <td>'+item.department_name+'</td>\
                            <td>'+item.email_address+'</td>\
                            <td>'+item.phone_number+'</td>\
                            <td><button type="button" value="'+item.id+'" class="editEmployee">Edit</button></td>\
                            <td><button type="button" value="'+item.id+'" class="deleteEmployee">Delete</button></td>\
                            </tr>');
                        });
                    }
                });
            }

            $(document).on('click', '.deleteEmployee', function (e) {
                e.preventDefault();
                let employeeId = $(this).val();
                confirmation = confirm("Are you sure want to remove this employee?");
                
                if (confirmation) {

                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                
                    $.ajax({
                        type: "DELETE",
                        url: "./delete-employee/"+employeeId,
                        success: function (response) {
                            $('#success-message').text(response.message);
                            fetchEmployee();
                        }
                    });
                }
            });

            $(document).on('click', '.updateEmployee', function (e) {
                e.preventDefault();

                $(this).text("Updating");
                let employeeId = $('#editEmployeeId').val();
                let employeeData = {
                    'firstName': $('#editFirstName').val(),
                    'lastName': $('#editLastName').val(),
                    'department': $('#editDepartment').val(),
                    'email': $('#editEmail').val(),
                    'phone': $('#editPhone').val(),
                    'username': $('#editUsername').val(),
                    'password': $('#editPassword').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "./update-employee/"+employeeId,
                    data: employeeData,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 400) 
                        {
                            $('#updateformErrorList').html("");
                            $.each(response.errors, function (key, errorValues) {
                                $('#updateformErrorList').append('<li>'+errorValues+'</li>');
                            });
                            $('.updateEmployee').text("Update");
                        } 
                        else if (response.status == 404) 
                        {
                            $('#updateformErrorList').html("");
                            $('#success-message').text(response.message);
                            $('.updateEmployee').text("Update");
                        } 
                        else {
                            $('#updateformErrorList').html("");
                            $('#success-message').html("");
                            $('#success-message').text(response.message);
                            $('.updateEmployee').text("Update");
                            fetchEmployee();
                        }
                    }
                });
            });

            $(document).on('click', '.editEmployee', function (e) {
                e.preventDefault();
                let employeeId = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "./edit-employee/"+employeeId,
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success-message').html("");
                            $('#success-message').text(response.message);
                        } else {
                            $('#editEmployeeId').val(response.employee.id);
                            $('#editFirstName').val(response.employee.first_name);
                            $('#editLastName').val(response.employee.last_name);
                            $('#editDepartment').val(response.employee.department_name);
                            $('#editEmail').val(response.employee.email_address);
                            $('#editPhone').val(response.employee.phone_number);
                            $('#editUsername').val(response.employee.username);
                            $('#editPassword').val(response.employee.password);
                        }
                    }
                });
            });

            $(document).on('click', '.addEmployee', function (e) {
                e.preventDefault();

                var employeeData = {
                    'firstName':$('.first-name').val(),
                    'lastName':$('.last-name').val(),
                    'department':$('.department').val(),
                    'email':$('.email').val(),
                    'phone':$('.phone').val(),
                    'username':$('.username').val(),
                    'password':$('.password').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                
                $.ajax({
                    type: "POST",
                    url: "./employees",
                    data: employeeData,
                    dataType: "json",
                    success: function (response) 
                    {
                        //console.log(response);
                        if (response.status==400) 
                        {
                            $('#addformErrorList').html("");
                            $.each(response.errors, function (key, errorValues) {
                                $('#addformErrorList').append('<li>'+errorValues+'</li>');
                            });
                        }
                        else
                        {
                            $('#addformErrorList').html("");
                            $('#success-message').text(response.message);
                            //$('#add-employee-modal').modal('hide');
                            //$('#add-employee-modal').find('input').val("");
                            fetchEmployee();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>