<div class="container-fluid module-01-header">
    <nav class="navbar navbar-icon-top navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">Nhom G</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo esc_url(home_url('/')); ?>">Home <span class="sr-only">(current)</span></a></li>

                    <?php
                    $m1_categories = get_categories(array(
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => true,
                        'parent'     => 0,
                    ));
                    ?>
                    <?php if (! empty($m1_categories)) : ?>
                        <li class="dropdown module-01-cat<?php echo is_category() ? ' active' : ''; ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Danh mục <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($m1_categories as $m1_cat) : ?>
                                    <li<?php echo is_category($m1_cat->term_id) ? ' class="active"' : ''; ?>>
                                        <a href="<?php echo esc_url(get_category_link($m1_cat->term_id)); ?>">
                                            <?php echo esc_html($m1_cat->name); ?>
                                            <span class="m1-cat-count"><?php echo (int) $m1_cat->count; ?></span>
                                        </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                </li>
            <?php endif; ?>
            </ul>
            <form class="navbar-form navbar-left" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="form-group">
                    <input type="search" class="form-control" name="s" placeholder="Tìm kiếm bài viết..." value="<?php echo esc_attr(get_search_query()); ?>">
                </div>
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Tìm</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#">
                        <i class="fa fa-envelope-o">
                            <span class="badge badge-danger">11</span>
                        </i>
                        Messages
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user-circle-o"></i>
                        Account <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>