$(document).ready(function(){

    // populate the customer info table for student
    getCustomerDetailsToPopulateForStudent();

    // function for cancel request
    $(document).on('click', '.cancelBorrowRequestButton', function(){
        // Confirm before deleting
        var row = this.parentNode.parentNode;
        bootbox.confirm('Are you sure you want to cancel?', function(result){
            if(result){
                cancelBorrowRequest(row);
            }
        })
    })

    $(document).on('click', '.requestBorrowButton', function(){
        // Confirm before deleting
        var row = this.parentNode.parentNode;
        $("#v-pills-borrow-tab").trigger("click");
        getItemDetailsToPopulateForSaleTabForStudent(row);
    })
})

// to be displayed on customer details tab
function getCustomerDetailsToPopulateForStudent(){

    // Call the populateItemDetails.php script to get item details
    // relevant to the itemNumber which the user entered
    $.ajax({
        url: 'model/customer/populateCustomerDetailsByMatricNumber.php',
        method: 'POST',
        // data: {matricNumber:$('#session-matric-number').html()},
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
function cancelBorrowRequest(row){

    // Get the borrowRequestID from retrieved table
    var borrowDetailsBorrowRequestID = row.firstChild.textContent;
    console.log(borrowDetailsBorrowRequestID);

    // Call the cancelBorrowRequest.php script
    if (borrowDetailsBorrowRequestID != ''){
        $.ajax({
            url: 'model/borrow/cancelBorrowRequest.php',
            method: 'Post',
            data:{
                borrowDetailsBorrowRequestID:borrowDetailsBorrowRequestID,
            },
            success: function(data){
                $('#borrowDetailsMessage').fadeIn();
                $('#borrowDetailsMessage').html(data);
            },
            complete: function(){
                searchTableCreator('borrowRequestDetailsTableDiv', borrowRequestDetailsSearchTableCreatorFile, 'saleDetailsTable');
                reportsTableCreator('saleReportsTableDiv',saleReportsSearchTableCreatorFile,'saleReportsTable');
            }
        });
    }

}

// Function to populate borrow form for student
function getItemDetailsToPopulateForSaleTabForStudent(row){
    // Get the itemNumber entered in the text box
    var itemNumber = row.firstChild.textContent;
    var defaultImageData = '<img class="img-fluid" src="data/item_images/imageNotAvailable.jpg">';

    // Call the populateItemDetails.php script to get item details
    // relevant to the itemNumber which the user entered
    $.ajax({
        url: 'model/item/populateItemDetails.php',
        method: 'POST',
        data: {itemNumber:itemNumber},
        dataType: 'json',
        success: function(data){
            $('#borrowDetailsItemNumber').val(data.itemNumber);
            $('#borrowDetailsStudentMatricNumber').val(Number($('#session-matric-number').html()));
            $('#borrowDetailsStudentName').val(String($('#session-full-name').html()));
            $('#borrowDetailsItemName').val(data.itemName);
            $('#borrowDetailsTotalStock').val(data.stock);

            newImgUrl = 'data/item_images/' + data.itemNumber + '/' + data.imageURL;

            // Set the item image
            if(data.imageURL == 'imageNotAvailable.jpg' || data.imageURL == ''){
                $('#borrowDetailsImageContainer').html(defaultImageData);
            } else {
                $('#borrowDetailsImageContainer').html('<img class="img-fluid" src="' + newImgUrl + '">');
            }
        },
        complete: function() {
            calculateTotalInSaleTab();
        }
    });
}