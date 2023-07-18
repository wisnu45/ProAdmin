<!-- start: PAGE CONTENT -->
    <section class="content">
		<div class="container-fluid">
		<!-- Main content -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
						<div class="header">
                           	<h2><?php echo "Demo Plugin" ?></h2>
                          	<ul class="header-dropdown">
							<?php if(CheckPermission("demo", "own_create")){ ?>
								<button type="button" class="btn-sm  btn btn-primary waves-effect amDisable modalButton" data-src="" data-width="555" ><i class="material-icons">add</i>Add Button</button>
                          	<?php } ?>
                          	</ul>
                        </div>
                        <div class="body">
                        	<?php if(CheckPermission("demo", "own_create")){ ?>
                        	<h1>User can create own</h1>
                        	<?php } ?>
                        	<?php if(CheckPermission("demo", "own_read")){ ?>
                        	<h1>User can read own data.</h1>
                        	<?php } ?>
                        	<?php if(CheckPermission("demo", "own_update")){ ?>
                        	<h1>User can update own data.</h1>
                        	<?php } ?>
                        	<?php if(CheckPermission("demo", "own_delete")){ ?>
                        	<h1>User can delete own data.</h1>
                        	<?php } ?>
                        	<?php if(CheckPermission("demo", "all_read")){ ?>
                        	<h1>User can read all data.</h1>
                        	<?php } ?>
                        	<?php if(CheckPermission("demo", "all_update")){ ?>
                        	<h1>User can update all data.</h1>
                        	<?php } ?>
                        	<?php if(CheckPermission("demo", "all_delete")){ ?>
                        	<h1>User can delete all data.</h1>
                        	<?php } ?>
                        	
                        </div>
                    </div>
                     <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        <!-- /.Main-content -->
      	</div>
    </section>
<!-- /.content-wrapper -->