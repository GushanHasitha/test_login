    <Script type="text/javascript">

        $(function() {
            fillUsersList();
            clearUserForm();
        });

        function clearUserForm() {
            $('#userForm').hide();
        }
        
        function cancelUserForm() {
            $('#userForm').hide();
        }

        function fillUsersList() {
            var rows = [];
            var URL = "<?php echo base_url(ROUTES::GET_ALL_USERS); ?>"
            $.post(URL, {}, function(data) {
                var actions = "";
                //console.log("users ==" + JSON.stringify(data));
                var users = JSON.parse(data);
                for(var i = 0; i < users.length; i++) {
                    var actions = '<i title="Update Users" class="action-btn material-icons" onclick="showUpdateUserForm(' + users[i].id +', \'' + users[i].user_name + '\', \'' + users[i].email + '\')" >mode_edit</i>';
                    actions += '<i title="Delete Users" class="action-btn text-danger material-icons" data-type="ajax-loader" onclick="deleteUser(' + users[i].id +', \''+ users[i].user_name + '\')" >delete_forever</i>';
                    rows.push([users[i].id, users[i].user_name, users[i].email, actions]);
                }

                $('#usersList').DataTable({
                "sPaginationType": "full_numbers",
                "bDestroy": true,
                'bAutoWidth': false,
                'aaData': rows,
                "columnDefs": [
                    { className: "action-btn-column", "targets": [ 3 ] }
                ],
                responsive: true
                });
            });
        }

        function showTransactionMessage(element, type, message) {
            var div = document.createElement('div');
            div.className = 'alert alert-dismissible';
            div.role = 'alert';
            div.innerHTML = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            
            switch(type) {
                case "success":
                    div.classList.add('alert-success');
                    break;
                case "failed": 
                    div.classList.add('alert-danger');
                    break;
            }

            var msg = document.createElement('div');
            msg.className = 'msg-text';
            msg.innerHTML = message;
            div.appendChild(msg);
            element.empty();
            element.append(div);
	    }

        
        function deleteUser(id, name) {
            //alert('working');
            confirmModal({
                type: "confirm",
                messageText: "Are you sure you want to delete the <b>" + name + "</b> user?",
                alertType: "info"
            }).done(function (e) {
                if(e === true) {
                    var URL = '<?php echo base_url(ROUTES::DELETE_USER_AJAX) ;?>';
                    $.post(URL, {'id': id}, function(data) {
                    console.log('result ===' + JSON.stringify(data));
                    var result = JSON.parse(data);
                    showTransactionMessage($('#alertMessage'), result.ret, result.message);
                    });
                    fillUsersList();
                }
            });
        }

        /*
        
        function confirmModal() {
                $('.js-sweetalert button').on('click', function () {
                var type = $(this).data('type');
                if (type === 'confirm') {
                    showConfirmMessage();
                }
                else if (type === 'cancel') {
                    showCancelMessage();
                }
            });
        }

        */
        function showAjaxLoaderMessage() {
    

        }
        
        function showUpdateUserForm(id, username, email) {
            $('#userForm').show();
            $('#userId').val(id);
            $('#userName').val(username);
            $('#email').val(email);
        }  
        
        function updateUser() {
            var id = $('#userId').val();
            var username = $('#userName').val();
            var email = $('#email').val();
            
            var URL = "<?php echo base_url(ROUTES::UPDATE_USER_AJAX) ;?>";
            $.post(URL, {'id': id, 'username': username, 'email': email}, function(data) {
                var result = JSON.parse(data);
                showTransactionMessage($('#alertMessage'), result.ret, result.message);
            });
            fillUsersList();
            cancelUserForm();
        }

    </Script>
    
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
            </div>

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="alertMessage"></div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="userForm">
                    <div class="card">
                        <div class="header">
                            <h2>
                                INPUT
                                <small>Different sizes and widths</small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <h2 class="card-inside-title">Basic Examples</h2>
                            <div class="row clearfix">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="userName">User Name</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Username" id="userName"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Email</label>
                                        <div class="form-line">
                                            <input type="email" class="form-control" placeholder="email" id="email"/>
                                        </div>
                                    </div>
                                    <input type="hidden" id="userId" value="0"/>
                                    <button type="button" class="btn btn-primary waves-effect float-right" onclick="cancelUserForm()">CANCEL</button>
                                    <button type="button" class="btn btn-primary waves-effect float-right" onclick="updateUser()">UPDATE USER</button>
                                </div>
                            </div>
                          
                        </div>
                       
                    </div>
                </div>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                BASIC EXAMPLE
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="">Action</a></li>
                                        <li><a href="">Another action</a></li>
                                        <li><a href="">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="usersList" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>User Id</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>User Id</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>