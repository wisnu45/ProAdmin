<div class="modal fade" id="__todo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="box-title" id="myModalLabel">
                    <span class="edit-title hide"><?php echo lang('todo_edit_title'); ?></span>
                    <span class="add-title hide"><?php echo lang('todo_add_title'); ?></span>
                </h4>
            </div>
            <form action="<?php echo base_url().'todo/todo/todo' ?>" id="add_new_todo_item" method="post"> 
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="todo_id" value="">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                    <label for="description" class="form-label">Description</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
                    <button type="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
