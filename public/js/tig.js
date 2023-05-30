// When the page is loaded, this Javascript file will execute
$(document).ready(function () {

    console.log("hey");

    fetchTickets(); // Fetches all the employees to be initially displayed in the employee table

    // Makes a get request to the fetch-employees route, which calls the employee controller's fetchemployee function. This returns a json file of the employees
    function fetchTickets()
    {
        $.ajax({
            type: "GET",
            url: "./fetch-tickets",
            dataType: "json",
            success: function (response) {
                $('tbody').html(""); // Clears all the previous html inside of the employee table body before the new list of employees is added to the employee table body

                // appends all the employee rows together inside  the employee table body
                console.log(response.tickets);
                $.each(response.tickets, function (key, item) {
                    $('tbody').append(
                    '<tr>\
                        <td>'+item[0].ticket_id+'</td>\
                        <td>'+item[0].ticket_title+'</td>\
                        <td>'+item[1].id+' '+item[1].first_name+' '+item[1].last_name+' '+'('+item[1].department_name+')'+'</td>\
                        <td>'+item[0].ticket_status+'</td>\
                        <td>'+item[0].ticket_priority+'</td>\
                        <td>'+item[0].created_at+'</td>\
                        <td>\
                            <button type="button" value="'+item.id+'" class="edit-ticket"><i class="uil uil-pen"></i></button>\
                            <button type="button" value="'+item.id+'" class="delete-ticket"><i class="uil uil-trash-alt"></i></button>\
                        </td>\
                    </tr>');
                });
            }
        });
    }
});