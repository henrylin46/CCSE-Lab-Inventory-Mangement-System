// File that returns matricNumbers
showCustomerMatricNumberSuggestionsFile = 'model/customer/showMatricNumbers.php';

// File that returns matricNumbers for sale tab
showCustomerMatricNumberSuggestionsForSaleTabFile = 'model/customer/showMatricNumbersForSaleTab.php';

$(document).ready(function(){
    // Listen to MatricNumber text box in customer details tab
    $('#customerDetailsCustomerMatricNumber').keyup(function(){
        showSuggestions('customerDetailsCustomerMatricNumber', showCustomerMatricNumberSuggestionsFile, 'customerDetailsCustomerMatricNumberSuggestionsDiv');
    });
    // Remove the MatricNumber suggestions dropdown in the customer details tab
    // when user selects an item from it
    $(document).on('click', '#customerDetailsCustomerMatricNumberSuggestionsList li', function(){
        $('#customerDetailsCustomerMatricNumber').val($(this).text());
        $('#customerDetailsCustomerMatricNumberSuggestionsList').fadeOut();
        getCustomerDetailsToPopulate();
    });

    // Listen to CustomerID text box in sale details tab
    $('#borrowDetailsStudentMatricNumber').keyup(function(){
        showSuggestions('borrowDetailsStudentMatricNumber', showCustomerMatricNumberSuggestionsForSaleTabFile, 'borrowDetailsStudentMatricNumberSuggestionsDiv');
    });
    // Remove the CustomerID suggestions dropdown in the sale details tab
    // when user selects an item from it
    $(document).on('click', '#saleDetailsMatricNumberSuggestionsList li', function(){
        $('#borrowDetailsStudentMatricNumber').val($(this).text());
        $('#saleDetailsMatricNumberSuggestionsList').fadeOut();
        getCustomerDetailsToPopulateSaleTab();
    });
});

// Function to show suggestions
function showSuggestions(textBoxID, scriptPath, suggestionsDivID){
    // Get the value entered by the user
    var textBoxValue = $('#' + textBoxID).val();

    // Call the showPurchaseIDs.php script only if there is a value in the
    // purchase ID textbox
    if(textBoxValue != ''){
        $.ajax({
            url: scriptPath,
            method: 'POST',
            data: {textBoxValue:textBoxValue},
            success: function(data){
                $('#' + suggestionsDivID).fadeIn();
                $('#' + suggestionsDivID).html(data);
            }
        });
    }
}

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