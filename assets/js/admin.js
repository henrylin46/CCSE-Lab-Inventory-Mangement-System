// File that returns matricNumbers
showCustomerMatricNumberSuggestionsFile = 'model/customer/showMatricNumbers.php';

// File that returns matricNumbers for sale tab
showCustomerMatricNumberSuggestionsForSaleTabFile = 'model/customer/showMatricNumbersForSaleTab.php';

$(document).ready(function() {

    // Listen to MatricNumber text box in customer details tab
    $('#customerDetailsCustomerMatricNumber').keyup(function () {
        showSuggestions('customerDetailsCustomerMatricNumber', showCustomerMatricNumberSuggestionsFile, 'customerDetailsCustomerMatricNumberSuggestionsDiv');
    });
    // Remove the MatricNumber suggestions dropdown in the customer details tab
    // when user selects an item from it
    $(document).on('click', '#customerDetailsCustomerMatricNumberSuggestionsList li', function () {
        $('#customerDetailsCustomerMatricNumber').val($(this).text());
        $('#customerDetailsCustomerMatricNumberSuggestionsList').fadeOut();
        getCustomerDetailsToPopulate();
    });

    // Listen to CustomerID text box in sale details tab
    $('#borrowDetailsStudentMatricNumber').keyup(function () {
        showSuggestions('borrowDetailsStudentMatricNumber', showCustomerMatricNumberSuggestionsForSaleTabFile, 'borrowDetailsStudentMatricNumberSuggestionsDiv');
    });
    // Remove the CustomerID suggestions dropdown in the sale details tab
    // when user selects an item from it
    $(document).on('click', '#saleDetailsMatricNumberSuggestionsList li', function () {
        $('#borrowDetailsStudentMatricNumber').val($(this).text());
        $('#saleDetailsMatricNumberSuggestionsList').fadeOut();
        getCustomerDetailsToPopulateSaleTab();
    });

    // listen to approve button in borrow request history in admin tab
    $(document).on('click', '.approveBorrowRequestButton', function () {
        var row = this.parentNode.parentNode;
        bootbox.confirm('Are you sure you want to approve this request?', function (result) {
            if (result) {
                approveBorrowRequest(row);
            }
        });
    });

    $(document).on('click', '.rejectBorrowRequestButton', function () {
        var row = this.parentNode.parentNode;
        bootbox.confirm('Are you sure you want to reject this request?', function (result) {
            if (result) {
                rejectBorrowRequest(row);
            }
        });
    });
})

// Function to send customerID so that customer details can be pulled from db
// to be displayed on customer details tab
function getCustomerDetailsToPopulate(){
    // Get the customerID entered in the text box
    var customerDetailsCustomerMatricNumber = $('#customerDetailsCustomerMatricNumber').val();

    // Call the populateItemDetails.php script to get item details
    // relevant to the itemNumber which the user entered
    $.ajax({
        url: 'model/customer/populateCustomerDetailsByMatricNumber.php',
        method: 'POST',
        data: {matricNumber:customerDetailsCustomerMatricNumber},
        dataType: 'json',
        success: function(data){
            $('#customerDetailsCustomerID').val(data.customerID);
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

// Function to send customerID so that customer details can be pulled from db
// to be displayed on sale details tab
function getCustomerDetailsToPopulateSaleTab(){
    // Get the customerID entered in the text box
    var borrowDetailsStudentMatricNumber = $('#borrowDetailsStudentMatricNumber').val();

    // Call the populateCustomerDetails.php script to get customer details
    // relevant to the customerID which the user entered
    $.ajax({
        url: 'model/customer/populateCustomerDetailsByMatricNumber.php',
        method: 'POST',
        data: {matricNumber:borrowDetailsStudentMatricNumber},
        dataType: 'json',
        success: function(data){
            //$('#saleDetailsCustomerID').val(data.customerID);
            $('#borrowDetailsStudentName').val(data.fullName);
        }
    });
}

// function to approve borrow request for admin
function approveBorrowRequest(row){

    var borrowRequestID = row.firstChild.textContent;

    // Call the cancelBorrowRequest.php script
    if (borrowRequestID !== ''){
        $.ajax({
            url: 'model/lend/approveBorrowRequest.php',
            method: 'Post',
            data:{
                borrowRequestID:borrowRequestID,
            },
            dataType: 'text',
            success: function(data){
                if(data === 'successful'){
                    bootbox.alert('Borrow request No.' + borrowRequestID + ' has been approved. For further operation, please check in lend history panel.');
                } else if(data === 'no stock') {
                    bootbox.alert('This item has no stock.');
                } else if(data === 'not enough stock') {
                    bootbox.alert('This item does not have enough stock for this request.');
                } else if(data === 'student not exist') {
                    bootbox.alert('Request student not found in DB.');
                } else if(data === 'invalid item') {
                    bootbox.alert('No such item in DB.');
                }
            },
            complete: function(){
                searchTableCreator('borrowRequestDetailsTableDiv', borrowRequestDetailsSearchTableCreatorFile, 'saleDetailsTable');
                searchTableCreator('approvalHistoryDetailsTableDiv', approvalHistoryDetailsSearchTableCreatorFile, 'approvalHistoryDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }
}

// function to reject borrow request for admin
function rejectBorrowRequest(row){

    var borrowRequestID = row.firstChild.textContent;

    // Call the cancelBorrowRequest.php script
    if (borrowRequestID !== ''){
        $.ajax({
            url: 'model/lend/rejectBorrowRequest.php',
            method: 'Post',
            data:{
                borrowRequestID:borrowRequestID,
            },
            dataType: 'text',
            success: function(data){
                if(data === 'successful'){
                    bootbox.alert('Borrow request No.' + borrowRequestID + ' You can check in lend history panel.');
                }
            },
            complete: function(){
                searchTableCreator('borrowRequestDetailsTableDiv', borrowRequestDetailsSearchTableCreatorFile, 'saleDetailsTable');
                searchTableCreator('approvalHistoryDetailsTableDiv', approvalHistoryDetailsSearchTableCreatorFile, 'approvalHistoryDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }
}