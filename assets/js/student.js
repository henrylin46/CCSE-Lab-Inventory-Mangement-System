$(document).ready(function(){

    // populate the customer info table for student
    getCustomerDetailsToPopulateForStudent();

    // function for cancel request
    $(document).on('click', '.cancelSaleRequestButton', function(){
        // Confirm before deleting
        var row = this.parentNode.parentNode;
        bootbox.confirm('Are you sure you want to cancel?', function(result){
            if(result){
                deleteSale(row);
            }
        })
    })

    $(document).on('click', '.requestBorrowButton', function(){
        // Confirm before deleting
        console.log(this);
        var row = this.parentNode.parentNode;
        $("#v-pills-sale-tab").trigger("click");
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
        data: {matricNumber:$('#session-matric-number').html()},
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

    // Call the cancelSaleRequest.php script
    if (saleDetailsSaleID != ''){
        $.ajax({
            url: 'model/sale/cancelSaleRequest.php',
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
            $('#saleDetailsItemNumber').val(data.itemNumber);
            $('#saleDetailsCustomerMatricNumber').val($('#session-matric-number').html());
            $('#saleDetailsCustomerName').val($('#session-full-name').html());
            $('#saleDetailsItemName').val(data.itemName);
            $('#saleDetailsTotalStock').val(data.stock);

            newImgUrl = 'data/item_images/' + data.itemNumber + '/' + data.imageURL;

            // Set the item image
            if(data.imageURL == 'imageNotAvailable.jpg' || data.imageURL == ''){
                $('#saleDetailsImageContainer').html(defaultImageData);
            } else {
                $('#saleDetailsImageContainer').html('<img class="img-fluid" src="' + newImgUrl + '">');
            }
        },
        complete: function() {
            calculateTotalInSaleTab();
        }
    });
}