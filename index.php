<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/assets/img/phone.png">
    <title>Phone Suppression System</title>
    <link rel="stylesheet" type="text/css" href="/assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lib/material-design-icons/css/material-design-iconic-font.min.css" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lib/jqvmap/jqvmap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lib/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lib/datatables/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lib/select2/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lib/bootstrap-slider/css/bootstrap-slider.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css" />
    <link rel="stylesheet" href="/assets/css/style.css" type="text/css" />
</head>

<body>
    <div class="be-wrapper be-fixed-sidebar">
        <nav class="navbar navbar-default navbar-fixed-top be-top-header">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="/views/dashboard.php" class="navbar-brand"></a>
                </div>
                <div class="be-right-navbar">
                    <div class="page-title">
                        <span>Phone Suppression System</span>
                    </div>
                </div>
            </div>
        </nav>
        <div class="be-content">
            <div id="dark" class="modal-container colored-header colored-header-dark modal-effect-10">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close">
                            <span class="mdi mdi-close"></span>
                        </button>
                        <h3 class="modal-title">Advanced Search Save</h3>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
            <div class="modal-overlay"></div>
            <div class="main-content container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default panel-table">
                            <div class="panel-heading">
                                <div class="tools dropdown">
                                    <a href="#" type="button" data-toggle="dropdown" class="dropdown-toggle">
                                        <span class="icon mdi mdi-more-vert"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li id="add-phone-popup">
                                            <a class="hover-link">Add phone</a>
                                        </li>
                                        <li id="advanced-search-popup">
                                            <a class="hover-link">Advanced Search</a>
                                        </li>
                                        <li id="reset-table-btn">
                                            <a class="hover-link">Reset Table</a>
                                        </li>
                                    </ul>
                                </div>
                                <span class="panel-subtitle"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group xs-mb-20">
                                        <input id="quicksearch-input" type="text" class="form-control" placeholder="Search by name or phone">
                                        <span class="input-group-btn">
                                            <button id="quicksearch-btn" type="button" class="btn btn-primary">Search</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="table2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="overflow: auto">
                                    <div class="row be-datatable-body">
                                        <div class="col-sm-12">
                                            <table id="table2" class="table table-striped table-hover table-fw-widget dataTable no-footer" role="grid" aria-describedby="table2_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th tabindex="0" aria-controls="table2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"
                                                            style="width: 294px;">Name</th>
                                                        <th tabindex="0" aria-controls="table2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 356px;">Phone</th>
                                                        <th tabindex="0" aria-controls="table2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                                            style="width: 189px;">Type</th>
                                                        <th tabindex="0" aria-controls="table2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                                            style="width: 189px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="phone-table-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row be-datatable-footer">
                                        <div class="col-sm-5">
                                            <div id="table-info-div" class="dataTables_info" id="table2_info" role="status" aria-live="polite">Showing 1 to 6 of 57 entries</div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="dataTables_paginate paging_simple_numbers" id="table2_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button previous disabled special-button" id="table2_previous">
                                                        <a class="hover-link" aria-controls="table2">Previous</a>
                                                    </li>
                                                    <li class="paginate_button active page" id="1">
                                                        <a class="hover-link" aria-controls="table2">1</a>
                                                    </li>
                                                    <li class="paginate_button page" id="2">
                                                        <a class="hover-link" aria-controls="table2">2</a>
                                                    </li>
                                                    <li class="paginate_button page" id="3">
                                                        <a class="hover-link" aria-controls="table2">3</a>
                                                    </li>
                                                    <li class="paginate_button page" id="4">
                                                        <a class="hover-link" aria-controls="table2">4</a>
                                                    </li>
                                                    <li class="paginate_button page" id="5">
                                                        <a class="hover-link" aria-controls="table2">5</a>
                                                    </li>
                                                    <li class="paginate_button next special-button" id="table2_next">
                                                        <a class="hover-link" aria-controls="table2">Next</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="/assets/js/main.js" type="text/javascript"></script>
    <script src="/assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/lib/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/assets/lib/datatables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js" type="text/javascript"></script>
    <script src="/assets/lib/datatables/plugins/buttons/js/buttons.html5.js" type="text/javascript"></script>
    <script src="/assets/lib/datatables/plugins/buttons/js/buttons.flash.js" type="text/javascript"></script>
    <script src="/assets/lib/datatables/plugins/buttons/js/buttons.print.js" type="text/javascript"></script>
    <script src="/assets/lib/datatables/plugins/buttons/js/buttons.colVis.js" type="text/javascript"></script>
    <script src="/assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js" type="text/javascript"></script>
    <script src="/assets/lib/jquery.gritter/js/jquery.gritter.js" type="text/javascript"></script>
    <script src="/assets/lib/jquery.niftymodals/dist/jquery.niftymodals.js" type="text/javascript"></script>
    <script src="/assets/js/app-tables-datatables.js" type="text/javascript"></script>

    <!--Custom JS-->
    <script src="/assets/js/custom/main.js" type="text/javascript"></script>
    <script src="/assets/js/custom/paginator.js" type="text/javascript"></script>
    <script src="/assets/js/custom/adv-search.js" type="text/javascript"></script>
    <script src="/assets/js/custom/popups.js" type="text/javascript"></script>
    <script src="/assets/js/custom/index.js" type="text/javascript"></script>
</body>

</html>