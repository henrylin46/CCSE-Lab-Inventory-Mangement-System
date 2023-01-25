<!-- Body for student Page -->
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
                <a class="nav-link active" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="true">Search</a>
                <a hidden class="nav-link" id="v-pills-borrow-tab" data-toggle="pill" href="#v-pills-borrow" role="tab" aria-controls="v-pills-borrow" aria-selected="false">Sale</a>
                <a class="nav-link" id="v-pills-student-tab" data-toggle="pill" href="#v-pills-student" role="tab" aria-controls="v-pills-student" aria-selected="false">Student</a>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="tab-content" id="v-pills-tabContent">

                <div class="tab-pane fade show active" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">
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
                                    <a class="nav-link" data-toggle="tab" href="#borrowRequestSearchTab">Borrow History</a>
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
                                <div id="borrowRequestSearchTab" class="container-fluid tab-pane fade">
                                    <br>
                                    <p>Use the grid below to search borrow history details</p>
                                    <div class="table-responsive" id="borrowRequestDetailsTableDiv"></div>
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
                                        <label for="borrowDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="borrowDetailsItemNumber" name="borrowDetailsItemNumber" autocomplete="off" readonly>
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
                                        <label for="borrowDetailsItemLocation">Location</label>
                                        <input type="text" class="form-control" name="borrowDetailsItemLocation" id="borrowDetailsItemLocation" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="borrowDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
                                        <input type="number" class="form-control" id="borrowDetailsQuantity" name="borrowDetailsQuantity" value="0">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="borrowDetailsStudentMatricNumber">Matric No.<span class="requiredIcon">*</span></label>
                                        <input readonly type="text" class="form-control" id="borrowDetailsStudentMatricNumber" name="borrowDetailsStudentMatricNumber" autocomplete="off">
                                        <div id="borrowDetailsStudentMatricNumberSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                    <div class="form-group col-md-10">
                                        <label for="borrowDetailsStudentName">Student Name</label>
                                        <input type="text" class="form-control" id="borrowDetailsStudentName" name="borrowDetailsStudentName" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="borrowDetailsPurpose">Purpose<span class="requiredIcon">*</span></label>
                                        <textarea rows="6" class="form-control" placeholder="Purpose" id="borrowDetailsPurpose" name="borrowDetailsPurpose"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <div id="borrowDetailsImageContainer"></div>
                                    </div>
                                </div>
                                <button type="button" id="applyBorrowRequestButton" class="btn btn-success">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-student" role="tabpanel" aria-labelledby="v-pills-student-tab">
                    <!--left panel "Student"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Student Details</div>
                        <div class="card-body">
                            <!-- Div to show the ajax message from validations/db submission -->
                            <div id="studentDetailsMessage"></div>
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="studentDetailsStudentMatricNumber">Matric No.<span class="requiredIcon">*</span></label>
                                        <input readonly type="text" class="form-control" id="studentDetailsStudentMatricNumber" name="studentDetailsStudentMatricNumber">
                                        <!--<div id="studentDetailsStudentMatricNumberSuggestionsDiv" class="customListDivWidth"></div>-->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="studentDetailsStudentPassword">Password<span class="requiredIcon">*</span></label>
                                        <input type="password" class="form-control invTooltip" id="studentDetailsStudentPassword" name="studentDetailsStudentPassword" title="Do not enter leading 0">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="studentDetailsStatus">Status</label>
                                        <select id="studentDetailsStatus" name="studentDetailsStatus" class="form-control chosenSelect">
                                            <option value="Active">Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="studentDetailsStudentFullName">Full Name<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="studentDetailsStudentFullName" name="studentDetailsStudentFullName">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="studentDetailsStudentEmail">Email<span class="requiredIcon">*</span></label>
                                        <input type="email" class="form-control" id="studentDetailsStudentEmail" name="studentDetailsStudentEmail">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="studentDetailsStudentMobile">Phone<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control invTooltip" id="studentDetailsStudentMobile" name="studentDetailsStudentMobile" title="Do not enter leading 0">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="studentDetailsStudentIdentification">ID<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="studentDetailsStudentIdentification" name="studentDetailsStudentIdentification">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="studentDetailsStudentAddress">Address<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="studentDetailsStudentAddress" name="studentDetailsStudentAddress">
                                    </div>
                                </div>
                                <button type="button" id="updateStudentDetailsButton" class="btn btn-primary">Update</button>
                            </form>
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

<!-- External JS function for students-->
<script src="assets/js/student.js"></script>

</body>