@extends('layouts.crmMain')

@section('styling')
<link rel="stylesheet" href="css/employ.css">
@endsection

@section('title')
<title>Employees</title>
@endsection

@section('content')
<body>
    <div id="create-employee-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create Employee</h2>
                <i class="uil uil-times"></i>
            </div>
            <form autocomplete="off" class="modal-body">
                <div class="form-group firstName">
                    <label for="create-first-name">First Name</label>
                    <input type="text" id="create-first-name" class="first-name-input form-control">
                </div>
                <div class="form-group lastName">
                    <label for="create-last-name">Last Name</label>
                    <input type="text" id="create-last-name" class="last-name-input form-control">
                </div>
                <div class="form-group department">
                    <label for="create-department">Department</label>
                    <select name="create-department" id="create-department" class="department-input form-control">
                        <option selected disabled>Choose a department</option>
                        <option value="Support">Support</option>
                        <option value="Help Desk">Help Desk</option>
                        <option value="Sales">Sales</option>
                    </select>
                </div>
                <div class="form-group email">
                    <label for="create-email">Email</label>
                    <input type="text" id="create-email" class="email-input form-control">
                </div>
                <div class="form-group phone">
                    <label for="create-phone">Phone</label>
                    <input type="text" id="create-phone" class="phone-input form-control">
                </div>
                <div class="form-group username">
                    <label for="create-username">Username</label>
                    <input type="text" id="create-username" class="username-input form-control">
                </div>
                <div class="form-group password">
                    <label for="create-password">Password</label>
                    <input type="password" id="create-password" class="password-input form-control">
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="add-employee">Add</button>
                <button type="button" class="close-btn">Close</button>
            </div>
        </div>
    </div>

    <div id="update-employee-modal" class="modal">
        <ul id="updateFormErrorList"></ul>
        <input type="hidden" id="edit-employee-id">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Employee</h2>
                <i class="uil uil-times"></i>
            </div>
            <form autocomplete="off" class="modal-body">
                <div class="form-group firstName">
                    <label for="editFirstName">First Name</label>
                    <input type="text" id="editFirstName" class="first-name form-control">
                </div>
                <div class="form-group lastName">
                    <label for="editLastName">Last Name</label>
                    <input type="text" id="editLastName" class="last-name form-control">
                </div>
                <div class="form-group department">
                    <label for="editDepartment">Department</label>
                    <select name="editDepartment" id="editDepartment" class="department form-control">
                        <option selected disabled>Choose a department</option>
                        <option value="Support">Support</option>
                        <option value="Help Desk">Help Desk</option>
                        <option value="Sales">Sales</option>
                    </select>
                </div>
                <div class="form-group email">
                    <label for="editEmail">Email</label>
                    <input type="text" id="editEmail" class="email form-control">
                </div>
                <div class="form-group phone">
                    <label for="editPhone">Phone</label>
                    <input type="text" id="editPhone" class="phone form-control">
                </div>
                <div class="form-group username">
                    <label for="editUsername">Username</label>
                    <input type="text" id="editUsername" class="username form-control">
                </div>
                <div class="form-group">
                    <label for="editPassword">Password</label>
                    <input type="password" id="editPassword" class="password form-control">
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="update-employee">Update</button>
                <button type="button" class="close-btn">Close</button>
            </div>
        </div>
    </div>
    <div class="module">
        <div class="module-header">
            <i class="uil uil-users-alt"></i>
            <h2>Employees<h2>
            <button type="button" id="create-employee-btn"><i class="uil uil-plus"></i></button>
            <h2 style="margin-left:100px" id="success-message"></h2>
            <div class="paginate">
                <button id="first-page-num">First</button>
                <button id="decrease-page"><i class="uil uil-angle-left"></i></button>
                <div id="page-counter">1</div>
                <button id="increase-page"><i class="uil uil-angle-right"></i></button>
                <button id="last-page-num">Last</button>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="js/employeeCruD.js"></script>
</body>
@endsection