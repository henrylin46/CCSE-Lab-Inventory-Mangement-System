$(document).ready(function(){

    // populate the customer info table for student
    getCustomerDetailsToPopulate();

    // function for cancel request
    $(document).on('click', '.deleteSaleButton', function(){
        // Confirm before deleting
        console.log(this);
        var row = this.parentNode.parentNode;
        console.log(row);
        bootbox.confirm('Are you sure you want to delete?', function(result){
            if(result){
                deleteSale(row);
            }
        });
    });
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

// Function to delete sale from db
function deleteSale(row){

    var saleDetailsSaleID = row.firstChild.textContent;
    var saleDetailsQuantity =row.querySelector(':nth-child(7)').textContent;
    var saleDetailsItemNumber = row.querySelector(':nth-child(2)').textContent;
    // Get the SaleID from retrieved table

    // Call the deleteSale.php script
    if (saleDetailsSaleID != ''){
        $.ajax({
            url: 'model/sale/deleteSale.php',
            method: 'Post',
            data:{
                saleDetailsSaleID:saleDetailsSaleID,
                saleDetailsQuantity:saleDetailsQuantity,
                saleDetailsItemNumber:saleDetailsItemNumber,
            },
            success: function(data){
                $('#saleDetailsMessage').fadeIn();
                $('#saleDetailsMessage').html(data);
            },
            complete: function(){
                searchTableCreator('saleDetailsTableDiv',saleDetailsSearchTableCreatorFile,'saleDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }

}