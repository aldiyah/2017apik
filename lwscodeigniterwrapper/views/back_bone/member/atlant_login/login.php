<?php
$login_success = isset($login_success) ? $login_success : FALSE;
$model_user_attributes = isset($model_user_attributes) && array_have_value($model_user_attributes) ? $model_user_attributes : FALSE;
$attention_messages = isset($attention_messages) ? $attention_messages : FALSE;
?>

<div class="block">
    <?php echo load_partial("back_bone/shared/attention_message"); ?>
</div>
<form class="form-horizontal" method="post">
    <div class="form-group">
        <div class="col-md-12">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $model_user_attributes ? $model_user_attributes['username'] : ""; ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $model_user_attributes ? $model_user_attributes['password'] : ""; ?>">
        </div>
    </div>
    <div class="form-group">
        <?php
        /*
        <div class="col-md-6">
            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
        </div>
         * 
         */
        ?>
        <div class="col-md-12">
            <button type="submit" class="btn btn-info btn-block">Log In</button>
        </div>
    </div>
</form>