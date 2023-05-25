const  employeeDropDownList = document.querySelector(".employee-dropdown-list"),
selectBtn = employeeDropDownList.querySelector(".select-btn"),
searchInput = employeeDropDownList.querySelector("input"),
options = employeeDropDownList.querySelector(".options");


let listTags = employeeDropDownList.querySelectorAll(".options li");
let employees = [];

listTags.forEach(tag => {
    employees.push(tag.innerHTML);
});

function fillEmployees(selectedEmployee) {
    options.innerHTML = "";
    employees.forEach(employee=>{
        // if selected employee and employee value is the same then add selected class
        let isSelected = employee==selectedEmployee ? "selected" : "";
        // adding each employee inside li and inserting all li inside options tag
        let li = '<li onclick="updateName(this)" class="' + isSelected + '"/>' + employee + '</li>';
        options.insertAdjacentHTML("beforeend", li);
    });
}

function updateName(selectedLi) {
    searchInput.value = "";
    fillEmployees(selectedLi.innerText);
    employeeDropDownList.classList.remove("active");
    selectBtn.firstElementChild.innerText = selectedLi.innerText;
}

searchInput.addEventListener("keyup", ()=>{
    let arr = [];
    let searchedVal = searchInput.value.toLowerCase();
    arr = employees.filter(data=>{
        return data.toLowerCase().startsWith(searchedVal);
    }).map(data=>'<li onclick="updateName(this)">' + data + '</li>').join("");
    options.innerHTML = arr ? arr : '<p>Employee not found</p>';
});

selectBtn.addEventListener("click", ()=>{
    employeeDropDownList.classList.toggle("active");
});