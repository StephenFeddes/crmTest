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
                url: "./employees/"+employeeId,
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
            url: "./employees/"+employeeId,
            data: employeeData,
            dataType: "json",
            success: function (response) {
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
            url: "./employees/"+employeeId+"/edit",
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