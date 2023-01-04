$(document).ready(function(){

    // populate the customer info table for student
    getCustomerDetailsToPopulate();

})

// to be displayed on customer details tab
function getCustomerDetailsToPopulate(){
    // Get the studentMatricNumber from the session value
    var customerDetailsCustomerMatricNumber = $('#session-matric-number').html();
    // Call the populateItemDetails.php script to get item details
    // relevant to the itemNumber which the user entered
    $.ajax({
        url: 'model/customer/populateCustomerDetailsByMatricNumber.php',
        method: 'POST',
        data: {matricNumber:customerDetailsCustomerMatricNumber},
        dataType: 'json',
        success: function(data){
            $('#customerDetailsCustomerID').val(data.customerID);
            $('#customerDetailsCustomerMatricNumber').val(data.matricNumber);
            $('#customerDetailsCustomerFullName').val(data.fullName);
            $('#customerDetailsCustomerMobile').val(data.mobile);
            $('#customerDetailsCustomerPassword').val(data.password);
            $('#customerDetailsCustomerEmail').val(data.email);
            $('#customerDetailsCustomerAddress').val(data.address);
            $('#customerDetailsStatus').val(data.status).trigger("chosen:updated");
            $('#customerDetailsCustomerIdentification').val(data.identification);
        }
    });
}