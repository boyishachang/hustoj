<?php if ( ! isset($cid) ):?>
<ul class="breadcrumb">
    <li><a href="/discuss/">Discuss</a> <span class="divider">/</span></li>
</ul>
<form class="form-inline well" role="form" action="/discuss" method="GET">
    <div class="form-group">
        <label class="sr-only" for="pid">Problem Id</label>
        <input placeholder="Problem Id" name="pid" id="pid" class="form-control"/>
    </div>
    <div class="form-group">
        <label class="sr-only" for="uid">User Id</label>
        <input placeholder="User Id" name="uid" id="uid" class="form-control"/>
    </div>
    <input type="submit" value="Filter" class="btn">
    <a href="/discuss/new" class="btn btn-info pull-right">New Topic</a>
</form>
<?php else:?>
    <?php echo(View::factory('contest/header', array('title' => $title, 'cid' => Request::$current->query('cid'), 'contest' => $contest)));?>
<div class="well">
    <a href="/discuss/new?cid=<?php echo($cid);?>" class="btn btn-info">New Topic</a>
</div>
<?php endif;?>
<hr class="clearfix"/>
<?php if ( $current_user->is_admin()):?>
<form action="/discuss/batch" method="post">
<?php endif;?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th class="col-sm-1"></th>
        <th>Title</th>
        <th class="col-sm-2">Author</th>
    </tr>
    </thead>
    <tbody>
    <?php /* @var Model_Topic[] $topic_list */ foreach ($topic_list as $t): ?>
    <tr>
        <?php if ( $current_user->is_admin()):?>
        <td>
            <input type="checkbox" name="tid[]" value="<?php echo($t->tid);?>">
        </td>
        <?php endif;?>
        <td>
            <?php if ($t->pid):?><a href="/problem/show/<?php echo($t->pid);?>" style="color: #000000"> <?php echo($t->pid);?> </a><?php endif;?></td>
        <td>
            <a href="/t/<?php echo($t->tid);?>"><strong><?php echo($t->title);?></strong></a>
        </td>
        <td><a href="<?php echo(Route::url('profile', array('uid' => $t->author_id)));?>"><?php echo($t->author_id);?></a></td>
    </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php if ( $current_user->is_admin()):?>
    <button name="action" value="deletetopic" class="btn btn-warning">Delete Topic</button> <button class="btn btn-danger" name="action" value="andblockuser">Delete And Block</button>
    </form>
<?php endif;?>
<ul class="pager" style="margin-left: 15%; margin-right: 15%">
    <?php $page = Request::$current->query('page');?>
    <?php if ($page != 1):?>
        <?php
        $params = Request::$current->query();
        $params['page'] = $page - 1;
        $query_param = URL::query($params);
        ?>
        <li class="previous"><?php echo HTML::anchor("/discuss/{$query_param}", '&larr; Newer');?></li>
    <?php endif;?>
    <?php if ($page < $total): ?>
        <?php
        $params['page'] = $page + 1;
        $query_param = URL::query($params);
        ?>
        <li class="next"><?php echo HTML::anchor("/discuss/{$query_param}", 'Older &rarr;');?></li>
    <?php endif;?>
</ul>