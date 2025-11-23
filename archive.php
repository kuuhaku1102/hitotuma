<?php get_header(); ?>

<div class="blog-archive-container">
  <div class="blog-archive-header">
    <h1 class="archive-title">
      <?php
      if ( is_category() ) {
        single_cat_title();
      } elseif ( is_tag() ) {
        single_tag_title();
      } elseif ( is_author() ) {
        the_author();
      } elseif ( is_date() ) {
        if ( is_day() ) {
          echo get_the_date();
        } elseif ( is_month() ) {
          echo get_the_date( 'Y年n月' );
        } elseif ( is_year() ) {
          echo get_the_date( 'Y年' );
        }
      } else {
        echo 'ブログ記事一覧';
      }
      ?>
    </h1>
    
    <?php if ( category_description() || tag_description() ) : ?>
      <div class="archive-description">
        <?php echo category_description() . tag_description(); ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="blog-posts-grid">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article class="blog-post-card">
          <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail">
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'medium' ); ?>
              </a>
            </div>
          <?php endif; ?>
          
          <div class="post-content">
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
            
            <h2 class="post-title">
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h2>
            
            <div class="post-excerpt">
              <?php echo wp_trim_words( get_the_excerpt(), 60, '...' ); ?>
            </div>
            
            <a href="<?php the_permalink(); ?>" class="read-more">
              続きを読む →
            </a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <div class="no-posts">
        <p>記事が見つかりませんでした。</p>
      </div>
    <?php endif; ?>
  </div>

  <?php if ( have_posts() ) : ?>
    <div class="pagination">
      <?php
      echo paginate_links( array(
        'prev_text' => '← 前へ',
        'next_text' => '次へ →',
        'type' => 'list',
        'mid_size' => 2,
      ) );
      ?>
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
