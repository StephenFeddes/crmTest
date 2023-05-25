<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/dropDownList.css">
    <title>Document</title>
</head>
<body>
    <div class="employee-dropdown-list">
        <div class="select-btn">
            <span>Assign Employee</span>
            <i class="uil uil-angle-down"></i>
        </div>
        <div class="content">
            <div class="search">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search">
            </div>
            <ul class="options">
                <li onclick="updateName(this)">Steve</li>
                <li>John</li>
            </ul>
        </div>
    </div>

    <script src="js/dropLists/selectEmployeeList.js"></script>
</body>
</html>