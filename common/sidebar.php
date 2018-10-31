<?php
$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$find_who_row=$find_who->first();

?>
<!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="logo/<?php echo $branchData_Row->logo; ?>" alt="<?php echo $branchData_Row->name; ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $rowData->name?></div>
                    <div class="email"><?php echo $rowData->email?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="profile.php"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="invoice-setting.php"><i class="material-icons">assignment</i>Invoice Setting</a></li>
                            <!--<li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="seperator" class="divider"></li>-------->
                            <li><a href="logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active">
                        <a href="index.php">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
					<li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">person</i>
                            <span> View Sub Admins</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="subadmins.php">View Subadmin</a>
                            </li>
                            
                        </ul>
                    </li>
					<?php
			$loginType=$find_who_row->login_type;
			if($loginType==4)
			{
			?>
                   <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">swap_calls</i>
                            <span>Branches</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="branches.php">View Branches</a>
                            </li>
                            
                        </ul>
                    </li>
					
					<?php } ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">widgets</i>
                            <span><?php echo  ucfirst($product_name); ?>s Management</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="category.php">
                                   Category
                                </a>
								</li>
								<li>
										<a href="product.php">
										 <?php echo  ucfirst($product_name); ?>
										</a>
									</li>
                               </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
								<i class="material-icons">assignment</i>
                                    <span>Invoices</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
										<a href="taxable-invoices.php">
										   Taxable
										</a>
									</li>
									<li>
										<a href="non-taxable-invoices.php">
										 Non Taxable
										</a>
									</li>
                                </ul>
                            </li>
					<li>
                        <a href="pending-list.php">
                            <i class="material-icons">assignment</i>
                            <span>Pending Invoices</span>
                        </a>
                    </li>
					<li>
                                <a href="javascript:void(0);" class="menu-toggle">
								<i class="material-icons">assignment</i>
                                    <span>Expenses</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
										<a href="expense-category.php">
										   Category
										</a>
									</li>
									<li>
										<a href="expense.php">
										 Expenses
										</a>
									</li>
                                </ul>
                    </li>
					<li>
                        <a href="users.php">
                            <i class="material-icons">person</i>
                            <span>Users</span>
                        </a>
                    </li>
					<li>
                                <a href="javascript:void(0);" class="menu-toggle">
								<i class="material-icons">assignment</i>
                                    <span>SMS</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
										<a href="send-sms.php">
										   Send Sms
										</a>
									</li>
									<li>
										<a href="sms.php">
										 View Sms
										</a>
									</li>
                                </ul>
                    </li>
					<li>
                        <a href="enquiry.php">
                            <i class="material-icons">person</i>
                            <span>Enquiry</span>
                        </a>
                    </li>
					<!--<li>
                        <a href="reports.php">
                            <i class="material-icons">view_list</i>
                            <span>Reports</span>
                        </a>
                    </li> -->
					<li>
                                <a href="javascript:void(0);" class="menu-toggle">
								<i class="material-icons">assignment</i>
                                    <span>Report</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
										<a href="reports.php">
										   Invoice report
										</a>
									</li>
									<li>
										<a href="expense-report.php">
										 Expence Report
										</a>
									</li>
                                </ul>
                    </li>
					
					
                        </ul>
                    </li>
                    
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    <b>Helpline Number :</b> <a href="javascript:void(0);">+91-9936585666</a>.
                </div>
                <div class="version">
                    <b>Mail Us On: </b> support@compaddicts.in
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">Help Desk</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
							<li>
								<a href="logout.php"> 
									<img src="img/icons/fugue/control-power.png" alt="">
									Logout
								</a>
							</li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>