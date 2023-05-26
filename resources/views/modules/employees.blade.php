<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crud</title>
</head>
<body>
    <h1>Employee list</h1>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        let table = $(".data-table").DataTable({
            serverSide:true,
            processing:true,
            ajax:"{{route('employees.index')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'name', name:'name'},
                {data:'email', name:'email'},
                {data:'action', name:'action'}
            ]
        });
    </script>
</body>
</html>