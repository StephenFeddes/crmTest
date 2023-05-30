// When the page is loaded, this Javascript file will execute
$(document).ready(function () {
    

    let modalCreate = document.getElementById("create-employee-modal");
    let modalUpdate = document.getElementById("update-employee-modal");
    let modalCreateBtn = document.getElementById("create-employee-btn");
    let modalAddBtn = document.getElementsByClassName("add-employee")[0];
    let modalCloseBtns= Array.from(document.getElementsByClassName("close-btn"));
    let modalExitBtns = Array.from(document.getElementsByClassName("uil-times"));
    let updateBtn = document.getElementsByClassName("update-employee")[0];

    function closeModal() {
        let errors = Array.from(modalCreate.getElementsByClassName('modal-body')[0].querySelectorAll('i'));
        errors.forEach(error=>{
            error.remove();
        });
        modalCreate.style.display = 'none';
        modalUpdate.style.display = 'none';
        document.getElementsByTagName("body")[0].style.overflow = 'auto';
    }


    modalCloseBtns.forEach(closeBtn => {
        closeBtn.addEventListener('click', closeModal);
    });

    modalExitBtns.forEach(exitBtn => {
        exitBtn.addEventListener('click', closeModal);
    });

    // Open employee creation modal
    modalCreateBtn.addEventListener('click', ()=>{
        let errors = Array.from(modalCreate.getElementsByClassName('modal-body')[0].querySelectorAll('i'));
        errors.forEach(error=>{
            error.remove();
        });
        let modalCreateInputs = Array.from(document.getElementById("create-employee-modal").getElementsByTagName("input"));
        modalCreateInputs.forEach(input => {
            input.value="";
        });
        modalCreate.style.display = 'block';
        document.getElementsByTagName("body")[0].style.overflow = 'hidden';
    });
  
    window.addEventListener('mousedown', (e)=>{
        if (e.target==modalCreate || e.target==modalUpdate) {
            modalCreate.style.display="none";
            modalUpdate.style.display="none";
            document.getElementsByTagName("body")[0].style.overflow = 'auto';
        }
    })

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
                        <td>'+item.first_name+' '+item.last_name+'</td>\
                        <td>'+item.department_name+'</td>\
                        <td>'+item.email_address+'</td>\
                        <td>'+item.phone_number+'</td>\
                        <td>\
                            <button type="button" value="'+item.id+'" class="edit-employee"><i class="uil uil-pen"></i></button>\
                            <button type="button" value="'+item.id+'" class="delete-employee"><i class="uil uil-trash-alt"></i></button>\
                        </td>\
                    </tr>');
                });
                let editBtns = Array.from(document.getElementsByClassName("edit-employee"));

                editBtns.forEach(editBtn => {
                editBtn.addEventListener('click', () =>{
                    let errors = Array.from(modalCreate.getElementsByClassName('modal-body')[0].querySelectorAll('i'));
                    errors.forEach(error=>{
                        error.remove();
                    });
                    document.getElementById("update-employee-modal").style.display = 'block';
                    document.getElementsByTagName("body")[0].style.overflow = 'hidden';
                    });
                });
            }
        });
    }

    // Employee deletion
   $(document).on('click', '.delete-employee', async function (e) {
        e.preventDefault(); // Removes any default button behavior. i.e. form submission, which would cause the page to refresh and ruin the purpose of ajax

        // Gets the selected element's (Delete button) id value. The value in the delete buttton is the id of the employee, which was generated in the fetchEmployees function
        let employeeId = $(this).val();

        let employee = await showEmployee(employeeId); // Asynchronously retrieves the employee so the user can see who they are deleting

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
    $(document).on('click', '.update-employee', function (e) {
        e.preventDefault();

        let errors = Array.from(modalUpdate.getElementsByClassName('modal-body')[0].querySelectorAll('i'));
        errors.forEach(error=>{
            error.remove();
        });
    
        let employeeId = $('#edit-employee-id').val(); //Retrieves the employee id value from the update button associated with that employee record

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
                    $('#updateFormErrorList').html("");
                    // $.each(response.errors, function (key, errorValues) {
                    //     $('#updateFormErrorList').append('<li>'+errorValues+'</li>');
                    // });

                    $.each(response.errors, function (key, errorValues) {
                        modalUpdate.getElementsByClassName(key)[0].insertAdjacentHTML('beforebegin', '<i>'+errorValues+'</i>');
                    });
                } 
                else if (response.status == 404) 
                {
                    /* If the employee no longer exists in the database by the time the update occured, 
                    there will be a 404 error. The user will be informed of this. */
                    $('#updateformErrorList').html("");
                    $('#success-message').text(response.message);
                } 
                else {
                    /* If the update happened successfully, redisplay the employees 
                    in the table and inform the user the update was successful*/
                    $("#success-message").fadeIn();
                    $('#updateformErrorList').html("");
                    $('#success-message').html("");
                    document.getElementById('success-message').style.backgroundColor="rgba(50,125,250,0.5)"
                    $('#success-message').text(response.message);
                    $("#success-message").fadeOut(2000, "swing");
                    fetchEmployees();
                    modalUpdate.style.display = 'none';
                    document.getElementsByTagName("body")[0].style.overflow = 'auto';
                }
            }
        });
    });

    // Retrives the information about the employee that is to be edited and displays it in the update form
    $(document).on('click', '.edit-employee', function (e) {
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
                    document.getElementById('success-message').style.backgroundColor="rgba(250,50,50,0.5)"
                    
                } else {
                    // Adds each of selected employee's attributes to the appropriate input box of the update form
                    $('#edit-employee-id').val(response.employee.id);
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


    $(document).on('click', '.add-employee', function (e) {
        e.preventDefault();

        let errors = Array.from(modalCreate.getElementsByClassName('modal-body')[0].querySelectorAll('i'));
        errors.forEach(error=>{
            error.remove();
        });

        // Contains the value for each employee attribute that was filled out on the employee creation form
        let employeeData = {
            'firstName':$('.first-name-input').val(),
            'lastName':$('.last-name-input').val(),
            'department':$('.department-input').val(),
            'email':$('.email-input').val(),
            'phone':$('.phone-input').val(),
            'username':$('.username-input').val(),
            'password':$('.password-input').val()
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

                    $.each(response.errors, function (key, errorValues) {
                        document.getElementsByClassName(key)[0].insertAdjacentHTML('beforebegin', '<i>'+errorValues+'</i>');
                    });
                }
                else
                {
                    // if the employee was succesfully added, refresh the employee list and display a success message.
                    $("#success-message").fadeIn();
                    $('#success-message').text(response.message);
                    document.getElementById('success-message').style.backgroundColor="rgba(0,165,115,0.5)";
                    $("#success-message").fadeOut(2000, "swing");
                    fetchEmployees();
                    modalCreate.style.display = 'none';
                    document.getElementsByTagName("body")[0].style.overflow = 'auto';
                }
            }
        });
    });
});