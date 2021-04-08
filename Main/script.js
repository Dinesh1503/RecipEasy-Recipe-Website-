
function fav(id, userId, elementId) {

    var elementName = elementId;
    var checkbox = document.getElementById(elementName);
    var isChecked = 0;
    
    if (checkbox.checked) {
        isChecked = 1;
    }

    $.ajax({
        type: "POST",
        url: 'query.php',
        data: { 'id' : id , 'userId' : userId,  'isChecked' : isChecked},
        success: function()
        {
                if(isChecked){
                    alert("Favorite!");
                }
                else{
                    alert("Cancel Favorite");
                }  
        }
    });
}

function mealPlan(id, userId, elementId, isChangeDate) {

    
    var checkbox = document.getElementById(elementId);

    var date = document.getElementById('date').value;
    
    var isChangeD = parseInt(isChangeDate);

    if(isChangeD == 1) {
        isChecked = 2;
    } 

    else {

        if (checkbox.checked) {
            isChecked = 1;
        }
    
        if(checkbox.checked) {
            if(elementId=='breakfast'){
                document.getElementById("dinner").checked = false;
                document.getElementById("lunch").checked = false;
            }
            if(elementId=='lunch'){
                document.getElementById("breakfast").checked = false;
                document.getElementById("dinner").checked = false;
            }
            if(elementId=='dinner'){
                document.getElementById("breakfast").checked = false;
                document.getElementById("lunch").checked = false;
            }
    }
    
    }

    $.ajax({
        type: "POST",
        url: 'query.php',
        data: { 'id' : id , 'userId' : userId,  'isChecked' : isChecked, 'date' : date, 'mealTime': elementId},
        success: function()
        {
                if(isChecked==1){
                    alert(elementId);
                    console.log(date);
                    console.log(id);
                    console.log(userId);
                    console.log(elementId);
                    console.log(isChecked);
                }
                else if(isChecked ==2){
                    alert("change date sucess!");
                }
                else{
                    alert("cancel!");
                }  
        }
    });
}

// in mealplan.php refresh date
function refresh() {
    var date = document.getElementById('mealDate').value;
    console.log(date);
    
    $.ajax({
        type: "POST",
        url: 'mealplan.php',
        data: { 'date' : date},
    });
    location.reload();
    
}