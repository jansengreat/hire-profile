<?php
/**
 * Halaman profil satu halaman.
 *
 * @package Hire_Profile
 */

$hp_name     = hp_get( 'full_name' );
$hp_links    = hp_links();
$hp_stats    = array_slice( hp_rows( 'stats', 2 ), 0, 4 );
$hp_how      = hp_lines( 'how' );
$hp_groups   = hp_skill_groups();
$hp_services = hp_rows( 'services', 2 );
$hp_projects = hp_projects();
$hp_exp      = hp_rows( 'experience', 4 );
$hp_quotes   = hp_rows( 'testimonials', 2 );
$hp_msg      = isset( $_GET['hp_msg'] ) ? sanitize_key( $_GET['hp_msg'] ) : ''; // phpcs:ignore
?>
<main id="main" class="hp-main">

	<section class="hp-hero" aria-labelledby="hp-name">
		<div class="hp-wrap hp-hero__grid">
			<div class="hp-hero__text">
				<?php echo hp_status(); // phpcs:ignore ?>

				<div class="hp-block">
					<div class="hp-block__toolbar" aria-hidden="true">
						<span class="hp-tool hp-tool--type">
							<svg width="18" height="18" viewBox="0 0 24 24"><path d="M6 5v14M18 5v14M6 12h12" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
						</span>
						<span class="hp-tool"><b>B</b></span>
						<span class="hp-tool"><i>I</i></span>
						<span class="hp-tool">
							<svg width="18" height="18" viewBox="0 0 24 24"><path d="M10 14a4 4 0 005.7 0l3-3a4 4 0 00-5.7-5.7l-1 1M14 10a4 4 0 00-5.7 0l-3 3a4 4 0 005.7 5.7l1-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
						</span>
					</div>
					<h1 class="hp-name" id="hp-name"><?php echo esc_html( $hp_name ); ?><span class="hp-caret" aria-hidden="true"></span></h1>
				</div>

				<p class="hp-headline"><?php echo esc_html( hp_get( 'headline' ) ); ?></p>
				<?php if ( hp_get( 'pitch' ) ) : ?>
					<p class="hp-pitch"><?php echo esc_html( hp_get( 'pitch' ) ); ?></p>
				<?php endif; ?>

				<div class="hp-actions">
					<a class="hp-btn hp-btn--primary" href="<?php echo esc_url( hp_primary_href() ); ?>"><?php echo esc_html( hp_t( 'start' ) ); ?></a>
					<?php if ( hp_get( 'cv' ) ) : ?>
						<a class="hp-btn" href="<?php echo esc_url( hp_get( 'cv' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'cv' ) ); ?></a>
					<?php endif; ?>
				</div>

				<?php
				$hp_social = array_intersect_key( $hp_links, array_flip( array( 'linkedin', 'github', 'upwork' ) ) );
				if ( $hp_social ) :
					?>
					<ul class="hp-social">
						<?php foreach ( $hp_social as $l ) : ?>
							<li><a href="<?php echo esc_url( $l[1] ); ?>" target="_blank" rel="noopener me"><?php echo esc_html( $l[0] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<aside class="hp-card hp-facts" aria-label="Quick facts">
				<?php echo hp_photo( 'hp-facts__photo', 480 ); // phpcs:ignore ?>
				<dl>
					<?php if ( hp_get( 'location' ) ) : ?>
						<div><dt><?php echo esc_html( hp_t( 'location' ) ); ?></dt><dd><?php echo esc_html( hp_get( 'location' ) ); ?></dd></div>
					<?php endif; ?>
					<?php if ( hp_get( 'timezone' ) ) : ?>
						<div><dt><?php echo esc_html( hp_t( 'timezone' ) ); ?></dt><dd><?php echo esc_html( hp_get( 'timezone' ) ); ?></dd></div>
					<?php endif; ?>
					<?php if ( hp_get( 'years' ) ) : ?>
						<div><dt><?php echo esc_html( hp_t( 'experience_lbl' ) ); ?></dt><dd><?php echo esc_html( sprintf( hp_t( 'years' ), hp_get( 'years' ) ) ); ?></dd></div>
					<?php endif; ?>
					<?php if ( hp_get( 'rate' ) ) : ?>
						<div><dt><?php echo esc_html( hp_t( 'engagement' ) ); ?></dt><dd><?php echo esc_html( hp_get( 'rate' ) ); ?></dd></div>
					<?php endif; ?>
					<?php if ( hp_get( 'response' ) ) : ?>
						<div><dt><?php echo esc_html( hp_t( 'response' ) ); ?></dt><dd><?php echo esc_html( hp_get( 'response' ) ); ?></dd></div>
					<?php endif; ?>
				</dl>
			</aside>
		</div>

		<?php if ( $hp_stats ) : ?>
			<div class="hp-wrap">
				<ul class="hp-stats">
					<?php foreach ( $hp_stats as $s ) : ?>
						<li><strong><?php echo esc_html( $s[0] ); ?></strong><span><?php echo esc_html( $s[1] ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</section>

	<?php if ( hp_get( 'about' ) || $hp_how ) : ?>
	<section class="hp-section" id="about" aria-labelledby="hp-about-title">
		<div class="hp-wrap hp-split">
			<h2 class="hp-split__title" id="hp-about-title"><?php echo esc_html( hp_t( 'about' ) ); ?></h2>
			<div class="hp-split__body hp-about">
				<?php if ( hp_get( 'about' ) ) : ?>
					<div class="hp-prose"><?php echo wp_kses_post( wpautop( esc_html( hp_get( 'about' ) ) ) ); ?></div>
				<?php endif; ?>
				<?php if ( $hp_how ) : ?>
					<div class="hp-how">
						<h3><?php echo esc_html( hp_t( 'how' ) ); ?></h3>
						<ul>
							<?php foreach ( $hp_how as $h ) : ?>
								<li><?php echo esc_html( $h ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $hp_groups || $hp_services ) : ?>
	<section class="hp-section" id="skills" aria-labelledby="hp-skills-title">
		<div class="hp-wrap hp-split">
			<h2 class="hp-split__title" id="hp-skills-title"><?php echo esc_html( hp_t( 'skills' ) ); ?></h2>
			<div class="hp-split__body">
				<?php if ( $hp_groups ) : ?>
					<dl class="hp-skills">
						<?php foreach ( $hp_groups as $g ) : ?>
							<div>
								<?php if ( $g['name'] ) : ?><dt><?php echo esc_html( $g['name'] ); ?></dt><?php endif; ?>
								<dd>
									<ul class="hp-chips">
										<?php foreach ( $g['items'] as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?>
									</ul>
								</dd>
							</div>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>

				<?php if ( $hp_services ) : ?>
					<h3 class="hp-subtitle"><?php echo esc_html( hp_t( 'services' ) ); ?></h3>
					<dl class="hp-services">
						<?php foreach ( $hp_services as $s ) : ?>
							<div>
								<dt><?php echo esc_html( $s[0] ); ?></dt>
								<dd><?php echo esc_html( $s[1] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $hp_projects || current_user_can( 'edit_posts' ) ) : ?>
	<section class="hp-section hp-section--work" id="work" aria-labelledby="hp-work-title">
		<div class="hp-wrap">
			<h2 class="hp-section__title" id="hp-work-title"><?php echo esc_html( hp_t( 'work' ) ); ?></h2>
			<?php if ( ! $hp_projects ) : ?>
				<p class="hp-empty">
					<?php echo esc_html( hp_t( 'work_empty' ) ); ?>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=hp_project' ) ); ?>">Tambah Proyek</a>
				</p>
			<?php else : ?>
				<div class="hp-work">
					<?php foreach ( $hp_projects as $i => $p ) :
						$live   = get_post_meta( $p->ID, 'hp_live', true );
						$repo   = get_post_meta( $p->ID, 'hp_repo', true );
						$result = get_post_meta( $p->ID, 'hp_result', true );
						$role   = get_post_meta( $p->ID, 'hp_role', true );
						$tech   = hp_project_tech( $p->ID );
						$main   = $live ? $live : ( $repo ? $repo : '' );
						?>
						<article class="hp-project<?php echo 0 === $i ? ' hp-project--lead' : ''; ?>">
							<div class="hp-project__media">
								<?php if ( has_post_thumbnail( $p ) ) : ?>
									<?php echo get_the_post_thumbnail( $p, 'hp-project', array( 'loading' => 0 === $i ? 'eager' : 'lazy', 'alt' => get_the_title( $p ) ) ); ?>
								<?php else : ?>
									<div class="hp-project__placeholder" aria-hidden="true"><span><?php echo esc_html( hp_initials( get_the_title( $p ) ) ); ?></span></div>
								<?php endif; ?>
							</div>
							<div class="hp-project__body">
								<h3>
									<?php if ( $main ) : ?>
										<a href="<?php echo esc_url( $main ); ?>" target="_blank" rel="noopener"><?php echo esc_html( get_the_title( $p ) ); ?></a>
									<?php else : ?>
										<?php echo esc_html( get_the_title( $p ) ); ?>
									<?php endif; ?>
								</h3>
								<?php if ( $role ) : ?><p class="hp-project__role"><?php echo esc_html( $role ); ?></p><?php endif; ?>
								<?php if ( has_excerpt( $p ) ) : ?><p><?php echo esc_html( get_the_excerpt( $p ) ); ?></p><?php endif; ?>
								<?php if ( $result ) : ?><p class="hp-project__result"><?php echo esc_html( $result ); ?></p><?php endif; ?>
								<?php if ( $tech ) : ?>
									<ul class="hp-chips hp-chips--quiet" aria-label="<?php echo esc_attr( hp_t( 'tech' ) ); ?>">
										<?php foreach ( $tech as $t ) : ?><li><?php echo esc_html( $t ); ?></li><?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<p class="hp-project__links">
									<?php if ( $live ) : ?><a href="<?php echo esc_url( $live ); ?>" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'live' ) ); ?></a><?php endif; ?>
									<?php if ( $repo ) : ?><a href="<?php echo esc_url( $repo ); ?>" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'code' ) ); ?></a><?php endif; ?>
									<?php if ( '' !== trim( wp_strip_all_tags( $p->post_content ) ) ) : ?><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( hp_t( 'details' ) ); ?></a><?php endif; ?>
								</p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $hp_exp ) : ?>
	<section class="hp-section" id="experience" aria-labelledby="hp-exp-title">
		<div class="hp-wrap hp-split">
			<h2 class="hp-split__title" id="hp-exp-title"><?php echo esc_html( hp_t( 'experience' ) ); ?></h2>
			<ol class="hp-split__body hp-timeline">
				<?php foreach ( $hp_exp as $e ) : ?>
					<li>
						<p class="hp-timeline__period"><?php echo esc_html( $e[0] ); ?></p>
						<div>
							<h3><?php echo esc_html( $e[1] ); ?></h3>
							<?php if ( $e[2] ) : ?><p class="hp-timeline__org"><?php echo esc_html( $e[2] ); ?></p><?php endif; ?>
							<?php if ( $e[3] ) : ?><p><?php echo esc_html( $e[3] ); ?></p><?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $hp_quotes ) : ?>
	<section class="hp-section" aria-labelledby="hp-quotes-title">
		<div class="hp-wrap hp-split">
			<h2 class="hp-split__title" id="hp-quotes-title"><?php echo esc_html( hp_t( 'testimonials' ) ); ?></h2>
			<div class="hp-split__body hp-quotes">
				<?php foreach ( $hp_quotes as $q ) : ?>
					<figure class="hp-quote">
						<blockquote><p><?php echo esc_html( $q[0] ); ?></p></blockquote>
						<?php if ( $q[1] ) : ?><figcaption><?php echo esc_html( $q[1] ); ?></figcaption><?php endif; ?>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="hp-contact" id="contact" aria-labelledby="hp-contact-title">
		<div class="hp-wrap hp-contact__grid">
			<div class="hp-contact__intro">
				<h2 id="hp-contact-title"><?php echo esc_html( hp_t( 'contact' ) ); ?></h2>
				<p><?php echo esc_html( hp_t( 'contact_txt' ) ); ?></p>
				<?php if ( $hp_links ) : ?>
					<h3><?php echo esc_html( hp_t( 'direct' ) ); ?></h3>
					<ul class="hp-direct">
						<?php foreach ( $hp_links as $l ) : ?>
							<li>
								<span><?php echo esc_html( $l[0] ); ?></span>
								<a href="<?php echo esc_url( $l[1] ); ?>"<?php echo 0 === strpos( $l[1], 'mailto:' ) ? '' : ' target="_blank" rel="noopener"'; ?>><?php echo esc_html( $l[2] ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if ( hp_get( 'form' ) ) : ?>
				<form class="hp-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php if ( 'sent' === $hp_msg ) : ?>
						<p class="hp-notice hp-notice--ok" role="status"><?php echo esc_html( hp_t( 'sent' ) ); ?></p>
					<?php elseif ( in_array( $hp_msg, array( 'invalid', 'rate' ), true ) ) : ?>
						<p class="hp-notice hp-notice--err" role="alert"><?php echo esc_html( hp_t( 'err_' . $hp_msg ) ); ?></p>
					<?php endif; ?>

					<input type="hidden" name="action" value="hp_contact">
					<?php wp_nonce_field( 'hp_contact', 'hp_nonce' ); ?>
					<div class="hp-hp" aria-hidden="true">
						<label for="hp-website">Website</label>
						<input type="text" id="hp-website" name="hp_website" tabindex="-1" autocomplete="off">
					</div>

					<div class="hp-form__row">
						<p class="hp-field">
							<label for="hp-f-name"><?php echo esc_html( hp_t( 'f_name' ) ); ?></label>
							<input type="text" id="hp-f-name" name="hp_name" required autocomplete="name">
						</p>
						<p class="hp-field">
							<label for="hp-f-email"><?php echo esc_html( hp_t( 'f_email' ) ); ?></label>
							<input type="email" id="hp-f-email" name="hp_email" required autocomplete="email">
						</p>
					</div>
					<div class="hp-form__row">
						<p class="hp-field">
							<label for="hp-f-company"><?php echo esc_html( hp_t( 'f_company' ) ); ?> <small><?php echo esc_html( hp_t( 'f_optional' ) ); ?></small></label>
							<input type="text" id="hp-f-company" name="hp_company" autocomplete="organization">
						</p>
						<p class="hp-field">
							<label for="hp-f-budget"><?php echo esc_html( hp_t( 'f_budget' ) ); ?> <small><?php echo esc_html( hp_t( 'f_optional' ) ); ?></small></label>
							<input type="text" id="hp-f-budget" name="hp_budget">
						</p>
					</div>
					<fieldset class="hp-field hp-types">
						<legend><?php echo esc_html( hp_t( 'f_type' ) ); ?></legend>
						<?php foreach ( hp_t( 'types' ) as $ti => $type ) : ?>
							<label><input type="radio" name="hp_type" value="<?php echo esc_attr( $type ); ?>"<?php checked( 0, $ti ); ?>><span><?php echo esc_html( $type ); ?></span></label>
						<?php endforeach; ?>
					</fieldset>
					<p class="hp-field">
						<label for="hp-f-message"><?php echo esc_html( hp_t( 'f_message' ) ); ?></label>
						<textarea id="hp-f-message" name="hp_message" rows="5" required></textarea>
					</p>
					<button type="submit" class="hp-btn hp-btn--primary hp-btn--lg"><?php echo esc_html( hp_t( 'f_send' ) ); ?></button>
				</form>
			<?php endif; ?>
		</div>
	</section>

</main>
