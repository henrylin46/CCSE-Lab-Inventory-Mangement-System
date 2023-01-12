<!-- Body for admin page -->
<body>
<?php
require 'inc/navigation.php';
?>
<!-- Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <h1 class="my-4"></h1>
            <!--Navigation Tab-->
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="true">Add Item</a>
                <a class="nav-link" id="v-pills-borrow-tab" data-toggle="pill" href="#v-pills-borrow" role="tab" aria-controls="v-pills-borrow" aria-selected="false">New Borrow</a>
                <a class="nav-link" id="v-pills-customer-tab" data-toggle="pill" href="#v-pills-customer" role="tab" aria-controls="v-pills-customer" aria-selected="false">Customer</a>
                <a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a>
                <a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</a>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
                    <!--left panel "Item"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Item Details</div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <!--hyperlink, use id for locating-->
                                    <a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Item</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#itemImageTab">Upload Image</a>
                                </li>
                            </ul>

                            <!-- Tab panes for item details and image sections -->
                            <div class="tab-content">
                                <div id="itemDetailsTab" class="container-fluid tab-pane active">
                                    <br>
                                    <!-- Div to show the ajax message from validations/db submission -->
                                    <div id="itemDetailsMessage"></div>
                                    <form>
                                        <div class="form-row">

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="itemDetailsLocation">Location<span class="requiredIcon">*</span></label>
                                                <input type="text" class="form-control" name="itemDetailsLocation" id="itemDetailsLocation">
                                            </div>
<!--                                            <div class="form-group col-md-2">-->
<!--                                                <label for="itemDetailsItemID">Item ID</label>-->
<!--                                                <input class="form-control invTooltip" type="number" readonly  id="itemDetailsItemID" name="itemDetailsItemID" title="This will be auto-generated when you add a new item">-->
<!--                                            </div>-->
                                            <div class="form-group col-md-2" style="display:inline-block">
                                                <label for="itemDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
                                                <input type="text" class="form-control" name="itemDetailsItemNumber" id="itemDetailsItemNumber" autocomplete="off">
                                                <div id="itemDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="itemDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
                                                <input type="text" class="form-control" name="itemDetailsItemName" id="itemDetailsItemName" autocomplete="off">
                                                <div id="itemDetailsItemNameSuggestionsDiv" class="customListDivWidth"></div>
                                            </div>
                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-4" style="display:inline-block">
                                                <label for="itemDetailsBarcode">Barcode (if have)</label>
                                                <input type="text" class="form-control" name="itemDetailsBarcode" id="itemDetailsBarcode">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="itemDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
                                                <input type="number" class="form-control" value="0" name="itemDetailsQuantity" id="itemDetailsQuantity">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="itemDetailsTotalStock">Total Stock</label>
                                                <input type="text" class="form-control" name="itemDetailsTotalStock" id="itemDetailsTotalStock" readonly>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="itemDetailsStatus">Status</label>
                                                <select id="itemDetailsStatus" name="itemDetailsStatus" class="form-control chosenSelect">
                                                    <?php include('inc/statusList.html'); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12" style="display:inline-block">
                                                <label for="itemDetailsDescription">Description</label>
                                                <textarea rows="6" class="form-control" placeholder="Description" name="itemDetailsDescription" id="itemDetailsDescription"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <div id="imageContainer"></div>
                                            </div>
                                        </div>
                                        <button type="button" id="addItem" class="btn btn-success">Add Item</button>
                                        <button type="button" id="updateItem" class="btn btn-primary">Update</button>
                                        <button type="button" id="deleteItem" class="btn btn-danger">Delete</button>
                                        <button type="reset" class="btn" id="itemClear">Clear</button>
                                    </form>
                                </div>
                                <div id="itemImageTab" class="container-fluid tab-pane fade">
                                    <br>
                                    <div id="itemImageMessage"></div>
                                    <p>You can upload an image for a particular item using this section.</p>
                                    <p>Please make sure the item is already added to database before uploading the image.</p>
                                    <br>
                                    <form name="imageForm" id="imageForm" method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-3" style="display:inline-block">
                                                <label for="itemImageItemNumber">Item Number<span class="requiredIcon">*</span></label>
                                                <input type="text" class="form-control" name="itemImageItemNumber" id="itemImageItemNumber" autocomplete="off">
                                                <div id="itemImageItemNumberSuggestionsDiv" class="customListDivWidth"></div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="itemImageItemName">Item Name</label>
                                                <input type="text" class="form-control" name="itemImageItemName" id="itemImageItemName" readonly>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-row">
                                            <div class="form-group col-md-7">
                                                <label for="itemImageFile">Select Image ( <span class="blueText">jpg</span>, <span class="blueText">jpeg</span>, <span class="blueText">gif</span>, <span class="blueText">png</span> only )</label>
                                                <input type="file" class="form-control-file btn btn-dark" id="itemImageFile" name="itemImageFile">
                                            </div>
                                        </div>
                                        <br>
                                        <button type="button" id="updateImageButton" class="btn btn-primary">Upload Image</button>
                                        <button type="button" id="deleteImageButton" class="btn btn-danger">Delete Image</button>
                                        <button type="reset" class="btn">Clear</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-borrow" role="tabpanel" aria-labelledby="v-pills-borrow-tab">
                    <!--left panel "Sale"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Apply New Borrow Request</div>
                        <div class="card-body">
                            <div id="borrowDetailsMessage"></div>
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="borrowDetailsBorrowRequestID">Borrow ID</label>
                                        <input type="text" class="form-control invTooltip" id="borrowDetailsBorrowRequestID" name="borrowDetailsBorrowRequestID" title="This will be auto-generated when you add a new record" autocomplete="off">
                                        <div id="borrowDetailsBorrowRequestIDSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="borrowDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="borrowDetailsItemNumber" name="borrowDetailsItemNumber" autocomplete="off">
                                        <div id="borrowDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="borrowDetailsItemName">Item Name</label>
                                        <input type="text" class="form-control invTooltip" id="borrowDetailsItemName" name="borrowDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="borrowDetailsTotalStock">Total Stock</label>
                                        <input type="text" class="form-control" name="borrowDetailsTotalStock" id="borrowDetailsTotalStock" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="borrowDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
                                        <input type="number" class="form-control" id="borrowDetailsQuantity" name="borrowDetailsQuantity" value="0">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="borrowDetailsStudentMatricNumber">Matric No.<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="borrowDetailsStudentMatricNumber" name="borrowDetailsStudentMatricNumber" autocomplete="off">
                                        <div id="borrowDetailsStudentMatricNumberSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="borrowDetailsStudentName">Student Name</label>
                                        <input type="text" class="form-control" id="borrowDetailsStudentName" name="borrowDetailsStudentName" readonly>
                                    </div>
<!--                                    <div class="form-group col-md-3">-->
<!--                                        <label for="saleDetailsSaleDate">Sale Date<span class="requiredIcon">*</span></label>-->
<!--                                        <input type="text" class="form-control datepicker" id="saleDetailsSaleDate" value="2018-05-24" name="saleDetailsSaleDate" readonly>-->
<!--                                    </div>-->
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="borrowDetailsPurpose">Purpose<span class="requiredIcon">*</span></label>
                                        <textarea rows="6" class="form-control" placeholder="Purpose" id="borrowDetailsPurpose" name="borrowDetailsPurpose"></textarea>
                                    </div>
<!--                                    <div class="form-group col-md-3">-->
<!--                                        <label for="borrowDetailsRequestStatus">Status<span class="requiredIcon">*</span></label>-->
<!--                                        <select id="borrowDetailsRequestStatus" name="borrowDetailsRequestStatus" class="form-control chosenSelect">-->
<!--                                            --><?php //include('inc/requestStatusList.html')?>
<!--                                        </select>-->
<!--                                    </div>-->
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <div id="borrowDetailsImageContainer"></div>
                                    </div>
                                </div>
                                <button type="button" id="applyBorrowRequestButton" class="btn btn-success">Apply</button>
                                <button type="button" id="updateBorrowRequestDetailButton" class="btn btn-primary">Update</button>
                                <button type="reset" id="borrowClear" class="btn">Clear</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-customer" role="tabpanel" aria-labelledby="v-pills-customer-tab">
                    <!--left panel "Customer"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Customer Details</div>
                        <div class="card-body">
                            <!-- Div to show the ajax message from validations/db submission -->
                            <div id="customerDetailsMessage"></div>
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="customerDetailsCustomerID">Customer ID</label>
                                        <input readonly type="text" class="form-control invTooltip" id="customerDetailsCustomerID" name="customerDetailsCustomerID" title="This will be auto-generated when you add a new customer" autocomplete="off">
                                        <div id="customerDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="customerDetailsCustomerMatricNumber">Matric No.<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="customerDetailsCustomerMatricNumber" name="customerDetailsCustomerMatricNumber">
                                        <div id="customerDetailsCustomerMatricNumberSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="customerDetailsCustomerPassword">Password<span class="requiredIcon">*</span></label>
                                        <input type="password" class="form-control invTooltip" id="customerDetailsCustomerPassword" name="customerDetailsCustomerPassword" title="Do not enter leading 0">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="customerDetailsStatus">Status</label>
                                        <select id="customerDetailsStatus" name="customerDetailsStatus" class="form-control chosenSelect">
                                            <?php include('inc/statusList.html'); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="customerDetailsCustomerFullName">Full Name<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="customerDetailsCustomerFullName" name="customerDetailsCustomerFullName">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="customerDetailsCustomerEmail">Email<span class="requiredIcon">*</span></label>
                                        <input type="email" class="form-control" id="customerDetailsCustomerEmail" name="customerDetailsCustomerEmail">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="customerDetailsCustomerMobile">Phone<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control invTooltip" id="customerDetailsCustomerMobile" name="customerDetailsCustomerMobile" title="Do not enter leading 0">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="customerDetailsCustomerIdentification">ID<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="customerDetailsCustomerIdentification" name="customerDetailsCustomerIdentification">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="customerDetailsCustomerAddress">Address<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="customerDetailsCustomerAddress" name="customerDetailsCustomerAddress">
                                    </div>
                                </div>
                                <button type="button" id="addCustomer" name="addCustomer" class="btn btn-success">Add Customer</button>
                                <button type="button" id="updateCustomerDetailsButton" class="btn btn-primary">Update</button>
                                <button type="button" id="deleteCustomerButton" class="btn btn-danger">Delete</button>
                                <button type="reset" class="btn">Clear</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">
                    <!--left panel "Search"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Search Inventory
                            <button id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#itemSearchTab">Item</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#customerSearchTab">Customer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#saleSearchTab">Sale</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="itemSearchTab" class="container-fluid tab-pane active">
                                    <br>
                                    <p>Use the grid below to search all details of items</p>
                                    <!-- <a href="#" class="itemDetailsHover" data-toggle="popover" id="10">wwwee</a> -->
                                    <div class="table-responsive" id="itemDetailsTableDiv"></div>
                                </div>
                                <div id="customerSearchTab" class="container-fluid tab-pane fade">
                                    <br>
                                    <p>Use the grid below to search all details of customers</p>
                                    <div class="table-responsive" id="customerDetailsTableDiv"></div>
                                </div>
                                <div id="saleSearchTab" class="container-fluid tab-pane fade">
                                    <br>
                                    <p>Use the grid below to search sale details</p>
                                    <div class="table-responsive" id="saleDetailsTableDiv"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
                    <!--left panel "Report"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Reports<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#itemReportsTab">Item</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#customerReportsTab">Customer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#saleReportsTab">Sale</a>
                                </li>
                            </ul>

                            <!-- Tab panes for reports sections -->
                            <div class="tab-content">
                                <div id="itemReportsTab" class="container-fluid tab-pane active">
                                    <br>
                                    <p>Use the grid below to get reports for items</p>
                                    <div class="table-responsive" id="itemReportsTableDiv"></div>
                                </div>
                                <div id="customerReportsTab" class="container-fluid tab-pane fade">
                                    <br>
                                    <p>Use the grid below to get reports for customers</p>
                                    <div class="table-responsive" id="customerReportsTableDiv"></div>
                                </div>
                                <div id="saleReportsTab" class="container-fluid tab-pane fade">
                                    <br>
                                    <!-- <p>Use the grid below to get reports for sales</p> -->
                                    <form>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="saleReportStartDate">Start Date</label>
                                                <input type="text" class="form-control datepicker" id="saleReportStartDate" value="2018-05-24" name="saleReportStartDate" readonly>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="saleReportEndDate">End Date</label>
                                                <input type="text" class="form-control datepicker" id="saleReportEndDate" value="2018-05-24" name="saleReportEndDate" readonly>
                                            </div>
                                        </div>
                                        <button type="button" id="showSaleReport" class="btn btn-dark">Show Report</button>
                                        <button type="reset" id="saleFilterClear" class="btn">Clear</button>
                                    </form>
                                    <br><br>
                                    <div class="table-responsive" id="saleReportsTableDiv"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require 'inc/footer.php';
?>
<script src="assets/js/populateByMatricNumberForAdmin.js"></script>
</body>