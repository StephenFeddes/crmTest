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
    <script src="js/employeeCrud.js"></script>
</body>
</html>