<?php get_header(); ?>

<div class="single-post-container">
  <?php while ( have_posts() ) : the_post(); ?>
    <article class="single-post">
      <header class="post-header">
        <div class="post-meta">
          <time class="post-date" datetime="<?php echo get_the_date( 'c' ); ?>">
            <?php echo get_the_date(); ?>
          </time>
          
          <?php
          $categories = get_the_category();
          if ( $categories ) :
          ?>
            <span class="post-categories">
              <?php foreach ( $categories as $category ) : ?>
                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-badge">
                  <?php echo esc_html( $category->name ); ?>
                </a>
              <?php endforeach; ?>
            </span>
          <?php endif; ?>
        </div>
        
        <h1 class="post-title"><?php the_title(); ?></h1>
      </header>
      
      <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-featured-image">
          <?php the_post_thumbnail( 'large' ); ?>
        </div>
      <?php endif; ?>
      
      <div class="post-content">
        <?php the_content(); ?>
      </div>
      
      <?php
      $tags = get_the_tags();
      if ( $tags ) :
      ?>
        <div class="post-tags">
          <span class="tags-label">タグ:</span>
          <?php foreach ( $tags as $tag ) : ?>
            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-badge">
              <?php echo esc_html( $tag->name ); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </article>
    
    <div class="post-navigation">
      <div class="nav-previous">
        <?php
        $prev_post = get_previous_post();
        if ( $prev_post ) :
        ?>
          <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="nav-link">
            <span class="nav-label">← 前の記事</span>
            <span class="nav-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
          </a>
        <?php endif; ?>
      </div>
      
      <div class="nav-next">
        <?php
        $next_post = get_next_post();
        if ( $next_post ) :
        ?>
          <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="nav-link">
            <span class="nav-label">次の記事 →</span>
            <span class="nav-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
          </a>
        <?php endif; ?>
      </div>
    </div>
    
    <div class="related-posts">
      <h2 class="related-posts-title">関連記事</h2>
      <div class="related-posts-grid">
        <?php
        $categories = get_the_category();
        if ( $categories ) {
          $category_ids = array();
          foreach ( $categories as $category ) {
            $category_ids[] = $category->term_id;
          }
          
          $related_args = array(
            'category__in' => $category_ids,
            'post__not_in' => array( get_the_ID() ),
            'posts_per_page' => 3,
            'orderby' => 'rand',
          );
          
          $related_query = new WP_Query( $related_args );
          
          if ( $related_query->have_posts() ) :
            while ( $related_query->have_posts() ) : $related_query->the_post();
        ?>
              <article class="related-post-card">
                <?php if ( has_post_thumbnail() ) : ?>
                  <div class="related-post-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                      <?php the_post_thumbnail( 'medium' ); ?>
                    </a>
                  </div>
                <?php endif; ?>
                
                <div class="related-post-content">
                  <time class="related-post-date" datetime="<?php echo get_the_date( 'c' ); ?>">
                    <?php echo get_the_date(); ?>
                  </time>
                  
                  <h3 class="related-post-title">
                    <a href="<?php the_permalink(); ?>">
                      <?php the_title(); ?>
                    </a>
                  </h3>
                </div>
              </article>
        <?php
            endwhile;
            wp_reset_postdata();
          else :
        ?>
            <p>関連記事はありません。</p>
        <?php
          endif;
        }
        ?>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
