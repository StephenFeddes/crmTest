// When the page is loaded, this Javascript file will execute
$(document).ready(function () {

    fetchEmployees(); // Fetches all the employees to be initially displayed in the employee table

    function showEmployee(id) {
        return new Promise((resolve, reject)=> {
            $.ajax({
                type: "GET",
                url: "./employees/"+id,
                dataType: "json",
                success: function (response) {
                    resolve(response.employee);
                },
                error: function(error) {
                    reject(error);
                }
            });
        });
    }

    // Makes a get request to the fetch-employees route, which calls the employee controller's fetchemployee function. This returns a json file of the employees
    function fetchEmployees()
    {
        $.ajax({
            type: "GET",
            url: "./fetch-employees",
            dataType: "json",
            success: function (response) {
                $('tbody').html(""); // Clears all the previous html inside of the employee table body before the new list of employees is added to the employee table body

                // appends all the employee rows together inside  the employee table body
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

    // When the delete button, which has the class 'deleteEmployee' is clicked, 
   $(document).on('click', '.deleteEmployee', async function (e) {
        e.preventDefault(); // Removes any default button behavior. i.e. form submission, which would cause the page to refresh and ruin the purpose of ajax

        // Gets the selected element's (Delete button) id value. The value in the delete buttton is the id of the employee, which was generated in the fetchEmployees function
        let employeeId = $(this).val();

        let employee = await showEmployee(employeeId); // Asynchronously retrives the employee so the user can see who they are deleting

        confirmation = confirm(`Are you sure you want to remove ${employee.first_name} ${employee.last_name}?`); // Prompts the user to confirm that they want to delete the selected employee
        
        if (confirmation) {
            // To make a delete request, the request must have the proper CSRF token in its header to protect against cross-site request forgery
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            // Removes the employee from the database
            $.ajax({
                type: "DELETE",
                url: "./employees/"+employeeId,
                success: function (response) {
                    $('#success-message').text(response.message);
                    fetchEmployees(); // Updates the list of the employees in the table after the employee is deleted
                }
            });
        }
    });

    // Updates the changed employee's fields
    $(document).on('click', '.updateEmployee', function (e) {
        e.preventDefault();
    
        let employeeId = $('#editEmployeeId').val(); //Retrieves the employee id value from the update button associated with that employee record
        
        // Contains the information about this employee that was selected for updating
        let employeeData = {
            'firstName': $('#editFirstName').val(),
            'lastName': $('#editLastName').val(),
            'department': $('#editDepartment').val(),
            'email': $('#editEmail').val(),
            'phone': $('#editPhone').val(),
            'username': $('#editUsername').val(),
            'password': $('#editPassword').val()
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Makes a PUT request to update the employee in the database
        $.ajax({
            type: "PUT",
            url: "./employees/"+employeeId,
            data: employeeData,
            dataType: "json",
            success: function (response) {
                if (response.status == 400) 
                {
                    // If the updated employee has invalid fields, return error message
                    $('#updateformErrorList').html("");
                    $.each(response.errors, function (key, errorValues) {
                        $('#updateformErrorList').append('<li>'+errorValues+'</li>');
                    });
                    $('.updateEmployee').text("Update");
                } 
                else if (response.status == 404) 
                {
                    /* If the employee no longer exists in the database by the time the update occured, there will be a 404 error.
                        The user will be informed of this. */
                    $('#updateformErrorList').html("");
                    $('#success-message').text(response.message);
                    $('.updateEmployee').text("Update");
                } 
                else {
                    // If the update happened successfully, redisplay the employees in the table and inform the user the update was successful
                    $('#updateformErrorList').html("");
                    $('#success-message').html("");
                    $('#success-message').text(response.message);
                    $('.updateEmployee').text("Update");
                    fetchEmployees();
                }
            }
        });
    });

    // Retrives the information about the employee that is to be edited and displays it in the update form
    $(document).on('click', '.editEmployee', function (e) {
        e.preventDefault();

        let employeeId = $(this).val();

        $.ajax({
            type: "GET",
            url: "./employees/"+employeeId+"/edit",
            success: function (response) {
                if (response.status == 404) {
                    // If the employee no longer exists, inform the user
                    $('#success-message').html("");
                    $('#success-message').text(response.message);
                } else {
                    // Adds each of selected employee's attributes to the appropriate input box of the update form
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

        // Contains the value for each employee attribute that was filled out on the employee creation form
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
        
        // Sends a POST request with the inputted employee data to /employees URL, which will active the EmployeeController's store method, storing the new employee in the database.
        $.ajax({
            type: "POST",
            url: "./employees",
            data: employeeData,
            dataType: "json",
            success: function (response) 
            {
                if (response.status==400) 
                {
                    // If the user entered invalid input, the server will respond with the errors, i.e. invalid email address 
                    $('#addformErrorList').html("");
                    $.each(response.errors, function (key, errorValues) {
                        $('#addformErrorList').append('<li>'+errorValues+'</li>');
                    });
                }
                else
                {
                    // if the employee was succesfully added, refresh the employee list and display a success message.
                    $('#addformErrorList').html("");
                    $('#success-message').text(response.message);
                    fetchEmployees();
                }
            }
        });
    });
});