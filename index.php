<?php
/**
 * Halaman lain: studi kasus proyek, halaman biasa, dan 404.
 *
 * @package Hire_Profile
 */

get_header();
?>
<main id="main" class="hp-main hp-page">
	<div class="hp-wrap hp-page__wrap">
		<p class="hp-back"><a href="<?php echo esc_url( hp_anchor( is_singular( 'hp_project' ) ? 'work' : 'about' ) ); ?>"><?php echo esc_html( hp_t( 'back' ) ); ?></a></p>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'hp-article' ); ?>>
					<h1 class="hp-article__title"><?php the_title(); ?></h1>

					<?php if ( is_singular( 'hp_project' ) ) :
						$live   = get_post_meta( get_the_ID(), 'hp_live', true );
						$repo   = get_post_meta( get_the_ID(), 'hp_repo', true );
						$result = get_post_meta( get_the_ID(), 'hp_result', true );
						$role   = get_post_meta( get_the_ID(), 'hp_role', true );
						$tech   = hp_project_tech( get_the_ID() );
						?>
						<?php if ( $role ) : ?><p class="hp-project__role"><?php echo esc_html( $role ); ?></p><?php endif; ?>
						<?php if ( $result ) : ?><p class="hp-project__result"><?php echo esc_html( $result ); ?></p><?php endif; ?>
						<?php if ( $tech ) : ?>
							<ul class="hp-chips hp-chips--quiet">
								<?php foreach ( $tech as $t ) : ?><li><?php echo esc_html( $t ); ?></li><?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if ( $live || $repo ) : ?>
							<div class="hp-actions">
								<?php if ( $live ) : ?><a class="hp-btn hp-btn--primary" href="<?php echo esc_url( $live ); ?>" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'live' ) ); ?></a><?php endif; ?>
								<?php if ( $repo ) : ?><a class="hp-btn" href="<?php echo esc_url( $repo ); ?>" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'code' ) ); ?></a><?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="hp-article__media"><?php the_post_thumbnail( 'hp-project' ); ?></figure>
					<?php endif; ?>

					<div class="hp-prose hp-article__content"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<h1 class="hp-article__title">404</h1>
			<p class="hp-prose"><?php echo esc_html( hp_t( 'not_found' ) ); ?></p>
			<p><a class="hp-btn hp-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( hp_t( 'see_profile' ) ); ?></a></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
