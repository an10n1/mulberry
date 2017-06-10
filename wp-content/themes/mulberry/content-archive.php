<div id="post-<?php the_ID(); ?>" class="post-row">
  <div class="row">
    <div class="post-row-top col-md-12">

      <header class="post-row-title">
        <a class="blog-title-row" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </header>

      <ul class="post-info">
        <li>
            <?php
            $id = get_the_ID();
            $date = get_the_date( 'F j, Y', $id);
            echo $date;
            ?>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/img/new-design/comment-icon.png"><?php  comments_number(); ?>
        </li>
        <li>
          <img src="<?php echo get_template_directory_uri(); ?>/img/new-design/category-icon.png"><?php $category = get_the_category();
            echo $category[0]->cat_name;  ?>
        </li>
      </ul>
    </div>
  </div>

  <div class="row">
    <div class="post-row-bottom col-md-12">

      <div class="post-row-img">
          <?php echo get_the_post_thumbnail(); ?>
      </div>

      <div class="post-row-short-text">
        <p class="blog-row-excerpt"><?php echo get_the_excerpt(); ?></p>

        <a class="post-readMore" href="<?php the_permalink(); ?>"">Читать дальше ...</a>
      </div>

    </div>
  </div>
</div>